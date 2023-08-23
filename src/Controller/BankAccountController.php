<?php

namespace CamboDev\Statement\Controller;

use App\Http\Controllers\Controller;
use CamboDev\Statement\Controller\BaseController;
use CamboDev\Statement\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends BaseController
{
    public function __construct()
    {
        $this->module = 'bank-account';
        $this->modelClass = BankAccount::class;
        $this->validation = true;
        $this->useUUID = true;
        $this->deleteWithClean = true;

        $this->validation = [[
            'va_account_title' => 'required',
            'va_account_number' => 'required',
        ],[],[
            'va_account_title' => 'Account Title',
            'va_account_number' => 'Account Number',
        ]];

        $this->dbSelect = ['id_ref as slug','va_account_number', 'va_account_title', 'dt_opening', 'am_opening_balance', 'is_default', 'va_note', 'created_at'];
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
            BankAccount::where('is_default', true)->update([
                'is_default' => false
            ]);
        }
    }
}
