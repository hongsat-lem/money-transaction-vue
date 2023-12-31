<?php

namespace CamboDev\Statement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartAccount extends Model
{
    use HasFactory;

    protected $table = 'tu_chart_of_accounts';

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }
}
