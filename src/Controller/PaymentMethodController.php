<?php

namespace CamboDev\Statement\Controller;

use App\Http\Controllers\Controller;
use CamboDev\Statement\Controller\BaseController;
use CamboDev\Statement\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends BaseController
{
    public function __construct()
    {
        $this->module = 'category';
        $this->modelClass = PaymentMethod::class;
        $this->validation = true;
        $this->useUUID = true;
        $this->deleteWithClean = true;

        $this->validation = [[
            'va_category_name' => 'required',
        ],[],[
            'va_category_name' => trans('Category Name'),
        ]];

        $this->dbSelect = ['id_ref as slug','va_payment_method_name', 'va_payment_method_description', 'is_default', 'created_at'];
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
            PaymentMethod::where('is_default', true)->update([
                'is_default' => false
            ]);
        }
    }
}
