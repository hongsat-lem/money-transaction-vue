<?php

namespace CamboDev\Statement\Controller;

use App\Http\Controllers\Controller;
use CamboDev\Statement\Controller\BaseController;
use CamboDev\Statement\Models\Supplier;
use Illuminate\Http\Request;

class SupplyerController extends BaseController
{
    public function __construct()
    {
        $this->module = 'supplier';
        $this->modelClass = Supplier::class;
        $this->validation = true;
        $this->useUUID = true;
        $this->deleteWithClean = true;

        $this->validation = [[
            'va_supplier_name' => 'required',
            'va_phone' => 'required',
        ],[],[
            'va_supplier_name' => trans('Name'),
            'va_phone' => trans('Phone'),
        ]];

        $this->dbSelect = ['id_ref as slug',
            'va_supplier_name',
            'va_company_name',
            'va_vat_number',
            'va_email',
            'va_web',
            'va_phone',
            'va_telegram',
            'va_wechat',
            'va_address',
            'va_country',
            'va_city',
            'va_state',
            'va_postal_code',
            'created_at'
        ];

        $this->listRelations = ['entity'];
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
