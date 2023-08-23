<?php


namespace CamboDev\Statement\Controller;
use Image;
use File;
use Illuminate\Support\Facades\Schema;

trait HelperController
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function queryDefaultSort($list, $table)
    {
        $sortBy = $this->getValueFromRequest('sortBy',$table.'.updated_at');

        $sortOrder = $this->getValueFromRequest('order', 'DESC');
        return $list->orderBy($sortBy, $sortOrder);
    }

    public function getValueFromRequest($key, $default = null) {
        if ($this->checkIfRequestValid($key)) {
            return request($key);
        }
        if ($this->checkIfRequestValid(strtolower($key))) {
            return request(strtolower($key));
        }
        return $default ? $default : null;
    }

    public function checkIfRequestValid($key) {
        if (!$key) return false;
        if (!request()->has($key)) return false;
        $value = request($key);
        if (!$value || $value == '') return false;
        if (!isset($value)) return false;
        return true;
    }

    public function preRequisite($table, $model)
    {
        $locale = request('locale');
        $list = [];
        if (Schema::hasColumn($table, 'name')) {
            $list = $model::where('sta_rec_id', 1)->pluck('name', 'id');
        }
        if (Schema::hasColumn($table, 'ref_desc')){
            if ($locale=='km')
                $list = $model::select('ref_desc as name', 'id', 'is_default')->where('sta_rec_id', 1)->get();
            else
                $list = $model::select('ref_desc_en as name', 'id', 'is_default')->where('sta_rec_id', 1)->get();
        }


        if (Schema::hasColumn($table, 'name_kh')){
            if ($locale=='km')
                $list = $model::select('name_kh as name', 'id', 'is_default');
            else
                $list = $model::select('name_en as name', 'id', 'is_default');

            if (request('prvin_id')) {
                $list->where('prvin_id', request('prvin_id'));
            }
            if (request('distr_id')) {
                $list->where('distr_id', request('distr_id'));
            }
            if (request('commu_id')) {
                $list->where('commu_id', request('commu_id'));
            }

            $list = $list->where('sta_rec_id', 1)->get();
        }

        return generateSelectOption($list);
    }

    public function uploadFile($image, $type, $validate_on)
    {
        $this->validate(request(), [
            $validate_on => 'max:5120',
        ]);

        $imageName = date("dHis-").preg_replace("/[^a-zA-Z0-9.]/","",$image->getClientOriginalName());
        $uploadPath = storage_path('app/public/'.$type.'/').date("Y/m");
        $image->move($uploadPath,$imageName);
        //Thumbnail Creation
        $thumbPath = $uploadPath.'/thumbs/';

        File::isDirectory($thumbPath) or File::makeDirectory($thumbPath,0775,true,true);
        if($image->getClientOriginalExtension() != 'svg'){
            $imageThmb = \Image::make($uploadPath.'/'.$imageName);
            $imageThmb->fit(300,300,function($constraint){$constraint->upsize();})->save($uploadPath.'/thumbs/thm_'.$imageName,80);
        }
        else{
            File::copy($uploadPath.'/'.$imageName,$uploadPath.'/thumbs/thm_'.$imageName);
        }

        $FullPath = url('storage/'.$type.'/'.date('Y/m').'/'.$imageName);

        return $FullPath;
    }
}
