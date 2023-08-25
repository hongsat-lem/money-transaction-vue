<?php

namespace CamboDev\Statement\Controller;

use App\Http\Controllers\Controller;
use CamboDev\Statement\Controller\BaseController;
use CamboDev\Statement\Models\Supplier;
use CamboDev\Statement\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends BaseController
{
    public function __construct()
    {
        $this->module = 'transaction';
        $this->modelClass = Transaction::class;
        $this->validation = true;
        $this->useUUID = true;
        $this->deleteWithClean = true;

        $this->validation = [[
            'am_transaction' => 'required',
            'dt_transaction' => 'required',
        ],[],[
            'am_transaction' => trans('Transaction Amount'),
            'dt_transaction' => trans('Transaction Date'),
        ]];

        $this->dbSelect = ['id_ref as slug','*'];

        $this->listRelations = ['entity','category','chat_account','bank_account','payment_method'];
    }

    protected function fillCreate($model, $request = null)
    {
       //
    }
    /**
     * @inheritDoc
     */
    protected function fillUpdate($model, $request = null)
    {
        //
    }
}
