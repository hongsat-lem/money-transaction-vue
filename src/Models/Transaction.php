<?php

namespace CamboDev\Statement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'td_transactions';

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'incom_exp_cat_id', 'id');
    }

    public function chat_account()
    {
        return $this->belongsTo(ChartAccount::class, 'chat_account_id', 'id');
    }

    public function bank_account()
    {
        return $this->belongsTo(BankAccount::class, 'account_id', 'id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
