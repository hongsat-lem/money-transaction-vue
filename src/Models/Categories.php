<?php

namespace CamboDev\Statement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'tu_income_expense_categories';

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }
}
