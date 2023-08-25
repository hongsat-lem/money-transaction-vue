<?php

namespace CamboDev\Statement\Controller;

use App\Http\Controllers\Controller;
use CamboDev\Statement\Controller\BaseController;
use CamboDev\Statement\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function __construct()
    {
        $this->module = 'category';
        $this->modelClass = Categories::class;
        $this->validation = true;
        $this->useUUID = true;
        $this->deleteWithClean = true;

        $this->validation = [[
            'va_category_name' => 'required',
        ],[],[
            'va_category_name' => trans('Category Name'),
        ]];

        $this->dbSelect = ['id_ref as slug','va_category_name', 'va_category_description', 'is_income', 'is_default', 'enu_income_exp', 'created_at'];

        $this->listRelations = ['entity'];
    }

    protected function fillCreate($model, $request = null)
    {
        $model->is_default = $request->is_default?true:false;
    }
    /**
     * @inheritDoc
     */
    protected function fillUpdate($model, $request = null)
    {
        $model->is_default = $request->is_default?true:false;
    }

    protected function beforeSave($model, $request = null, $id = null)
    {
        if ($request->is_default){
            Categories::where('is_default', true)->update([
                'is_default' => false
            ]);
        }
    }
}
