<?php

namespace CamboDev\Statement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'tu_suppliers';

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }
}
