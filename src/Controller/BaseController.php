<?php

namespace CamboDev\Statement\Controller;

use App\Http\Controllers\Controller;
use CamboDev\Statement\Controller\HelperController;
use Illuminate\Http\Request;
use DB;

abstract class BaseController extends Controller
{
    use HelperController;

    protected $module;
    protected $modelClass;
    protected $softDelete = false;
    protected $useUUID = false;
    protected $model;
    protected $validation;
    protected $dbRelations = false;
    protected $dbSelect;
    protected $listRelations;
    protected $messages;
    protected $deleteWithClean;
    protected $useOrder = true;

    function __construct(Module $module)
    {
        //middleware before access
        $this->middleware('auth');
        $this->module = $module;

        // check permission first todo anything
        $this->middleware('permission:'.$this->module.'-list|'.$this->module.'-create|'.$this->module.'-edit|'.$this->module.'-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:'.$this->module.'-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:'.$this->module.'-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:'.$this->module.'-delete', ['only' => ['destroy']]);
        // end check
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = new $this->modelClass;

        if (request('pre')) {
            return $this->preRequisite($table->getTable(), $this->modelClass);
        }

        if ($this->listRelations && is_array($this->listRelations) && sizeof($this->listRelations) > 0) {
            $list = $this->modelClass::with($this->listRelations)
                ->whereNotNull($table->getTable().'.id');
        } else{
            $list = $this->modelClass::whereNotNull($table->getTable().'.id');
        }

        $orderBy = 'DESC';
        if(request('sort_by')) {
            $orderBy = request('sort_by');
        }

        $list->select($this->dbSelect);
        if ($this->useOrder)
            $list->orderBy($table->getTable().'.id', $orderBy);

        $list->where($table->getTable().'.sta_rec_id', 1)
            ->where($table->getTable().'.sta_rec_code', 'A');

        if ($this->dbRelations) {
            $this->fillRelation($list, $table->getTable());
        }

        $this->searchFilter($list, $table->getTable());

        return $this->listIt($list);
    }

    protected function listIt($list)
    {
        return $list->paginate(request('perPage'));
    }

    protected function joinRelationship($list)
    {
        $list->getRelation();

        return $list;
    }

    protected function searchFilter($list, $table)
    {
        $compactResource = $this->customFilter($list);
        if ($compactResource) {
            return $this->queryDefaultSort($list, $table);
        }else {

            if (request('name')) {
                $list->where($table . '.name', 'ilike', '%' . request('name') . '%');
            }
            if (request('ref_desc')) {
                $list->where($table . '.ref_desc', 'ilike', '%' . request('ref_desc') . '%')
                    ->orWhere($table . '.ref_desc_en', 'ilike', '%' . request('ref_desc') . '%');
            }
        }

        $this->queryDefaultSort($list, $table);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$this->validation) {
            return response()->json([
                'errors' => [
                    'message' => ['technical error']
                ]], 422);
        }
        $customMsg = $this->customOnSaveValidation();

        if ($customMsg) {
            return response()->json([
                'errors' => [
                    'message' => [$customMsg]
                ]], 422);
        }

        return $this->saveOrUpdate($request, null, $this->validation);
    }

    protected function saveOrUpdate(Request $request=null, $id=null, $validation=[], $upload=false)
    {
        if ($validation && sizeof($validation) > 0) {
            if (sizeof($validation) != 3) {
                return response()->json([
                    'errors' => [
                        'message' => [trans('general.request_validation_technical')]
                    ]], 422);
            }
            request()->validate($validation[0], $validation[1], $validation[2]);
        }

        $actionUpdate = ($id && ($this->useUUID ? $id != null : $id > 0));

        DB::beginTransaction();
        try {
            if ($actionUpdate) {
                if ($this->useUUID) {
                    $model = $this->modelClass::whereIdRef($id)->first();
                }else{
                    $model = $this->modelClass::find($id);
                }
                if (array_key_exists('usr_upd', $model->toArray())) {
                    $model->usr_upd = authId();
                }

            }else {
                $model = new $this->modelClass;

                if ($this->useUUID) {
                    $model->id_ref = generateUuid();
                }
                $model->sta_rec_id = 1;
                $model->sta_rec_code = 'A';

                if (array_key_exists('usr_cre', $model->toArray())) {
                    $model->usr_cre = authId();
                }
            }
            $this->beforeSave($model, $request, $id);
            $model->fill(request()->all());

            if ($actionUpdate) {
                $this->fillUpdate($model, $request);
            }else{
                $this->fillCreate($model, $request);
            }
            $model->save();

            $this->afterSave($model, $request, $id, $actionUpdate);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
        }

        $this->model = $model;
        $msg = trans($this->module . ($actionUpdate? ' ' . 'updated': ' ' . 'added'));
        if ($this->messages) {
            $msg = $this->messages;
        }
        $id = $this->useUUID ? $model->id_ref : $model->id;

        return response()->json([
            'success' => ['message' => ucwords($msg), 'id' => $id]
        ], 200);
    }

    protected function customFilter($list, $table = null, $request=null)
    {
        //
    }
    protected function customShowFilter($list, $table = null, $request=null)
    {
        //
    }
    /**
     * Only if need for creation rule
     * @param $model
     * @param Request $request
     */
    protected function fillCreate($model, $request=null)
    {
        //
    }

    /**
     * @param $model
     * @param Request $request
     */
    protected function beforeSave($model, $request=null, $id=null)
    {
        //
    }

    /**
     * @param $model
     * @param Request $request
     */
    protected function afterSave($model, $request=null, $id=null)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$this->validation) {
            return response()->json([
                'errors' => [
                    'message' => [trans('general.request_validation_technical')]
                ]], 422);
        }

        $customMsg = $this->customOnSaveValidation($id);
        if ($customMsg) {
            return response()->json([
                'errors' => [
                    'message' => [$customMsg]
                ]], 422);
        }

        return $this->saveOrUpdate($request, $id, $this->validation);
    }


    /**
     * @param $model
     * @param Request $request
     * @return mixed
     */
    abstract protected function fillUpdate($model, $request=null);

    protected function customOnSaveValidation($id=null)
    {
        return null;
    }

    public function show($id)
    {
        if ($this->useUUID) {
            $data = $this->modelClass::whereIdRef($id);
            if ($this->listRelations && is_array($this->listRelations) && sizeof($this->listRelations) > 0) {
                $data = $this->modelClass::with($this->listRelations)
                    ->whereIdRef($id);
            }
            $cus = $this->customShowFilter($data);
            if ($cus) {
                return $cus->first();
            }

            $data = $data->first();
        } else {
            $data = $this->modelClass::find($id);
        }

        if(!$data)
            return response()->json([
                'errors' => [
                    'message' => trans('Could Not Find')
                ]], 422);

        $compactResource = $this->performAfterShow($data);
        if ($compactResource) {
            return $compactResource;
        }

        return $data;
    }

    /**
     * Display the specified resource (after show function)
     */
    protected function performAfterShow($model) {
        return null;
    }

    /**
     * Used to delete <model>
     * @delete ("/api/<model>/{id}")
     * @param ({
     *      @Parameter("id", type="integer", required="true", description="Id of <model>"),
     * })
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->useUUID) {
            $model = $this->modelClass::whereIdRef($id)->first();
        } else {
            $model = $this->modelClass::find($id);
        }

        if(!$model)
            return response()->json([
                'errors' => [
                    'message' => trans('Invalid data')
                ]], 422);

        $arrModel = $model->toArray();

        if(array_key_exists('is_default', $arrModel) && $arrModel['is_default'] == true)
            return response()->json([
                'errors' => [
                    'message' => trans('Default Cannot Be Deleted')
                ]], 422);

        $this->logActivity(['module' => $this->module, 'module_id' => $model->id, 'activity' => 'deleted']);

        if ($this->deleteWithClean) {
            $model->delete();
        }else{
            $model->sta_rec_id = 0;
            $model->sta_rec_code = 'D';
            if (array_key_exists('is_deleted', $model->toArray())) {
                $model->is_deleted = true;
            }
            if (array_key_exists('usr_upd', $model->toArray())) {
                $model->usr_upd = authId();
            }
            if (array_key_exists('dt_upd', $model->toArray())) {
                $model->dt_upd = date('Y-m-d');
            }
            $model->save();
        }

        $this->afterDelete($model, $id);

        return response()->json([
            'success' => ['message' => ucwords($this->module). ' deleted']
        ], 200);
    }

    protected function afterDelete($model, $id=null)
    {
        //
    }
}
