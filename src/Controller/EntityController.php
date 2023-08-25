<?php

namespace CamboDev\Statement\Controller;

use App\Http\Controllers\Controller;
use CamboDev\Statement\Controller\BaseController;
use CamboDev\Statement\Models\Entity;
use Illuminate\Http\Request;

class EntityController extends BaseController
{
    public function __construct()
    {
        $this->module = 'entity';
        $this->modelClass = Entity::class;
        $this->validation = true;
        $this->useUUID = true;
        $this->deleteWithClean = true;

        $this->validation = [[
            'va_entity_name' => 'required',
        ],[],[
            'va_entity_name' => trans('Name'),
        ]];

        $this->dbSelect = ['id_ref as slug',
            'va_entity_name',
            'va_entity_description',
            'dt_registered',
            'va_entity_address',
            'va_entity_address_city',
            'va_entity_phone_number',
            'va_entity_email',
            'va_entity_web',
            'created_at'
        ];
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

    protected function afterSave($model, $request = null, $id = null)
    {
        $users = request('user_ids');

        if (count($users)){
            $model->entity_users()->sync($users);
        }
    }
}
