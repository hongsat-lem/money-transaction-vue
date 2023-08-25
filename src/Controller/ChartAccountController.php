<?php

namespace CamboDev\Statement\Controller;

use App\Http\Controllers\Controller;
use CamboDev\Statement\Controller\BaseController;
use CamboDev\Statement\Models\ChartAccount;
use Illuminate\Http\Request;

class ChartAccountController extends BaseController
{
    public function __construct()
    {
        $this->module = 'chart-account';
        $this->modelClass = ChartAccount::class;
        $this->validation = true;
        $this->useUUID = true;
        $this->deleteWithClean = true;

        $this->validation = [[
            'va_chat_account_title' => 'required',
            'va_chat_account_number' => 'required',
        ],[],[
            'va_chat_account_title' => trans('Chart Account Title'),
            'va_chat_account_number' => trans('Chart Account Number'),
        ]];

        $this->dbSelect = ['id_ref as slug','va_chat_account_number', 'va_chat_account_title', 'enu_trans_type_id', 'is_default', 'va_note', 'created_at'];

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
            ChartAccount::where('is_default', true)->update([
                'is_default' => false
            ]);
        }
    }
}
