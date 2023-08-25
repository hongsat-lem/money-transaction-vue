<?php

namespace CamboDev\Statement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $table = 'tu_entities';

    public function entity_users()
    {
       return $this->hasMany(EntityUsers::class, 'entity_id', 'id');
    }
}
