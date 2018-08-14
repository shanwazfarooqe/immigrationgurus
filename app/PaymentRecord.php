<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    protected $fillable = [
        'invoice_id', 'payment_date', 'amount', 'method', 'description'
    ];

    protected $dates = ['created_at','updated_at','payment_date'];

    public function setPaymentDateAttribute($value)
    {
    	$this->attributes['payment_date'] = date('Y-m-d',strtotime(str_replace('/', '-', $value)));
    }
}
