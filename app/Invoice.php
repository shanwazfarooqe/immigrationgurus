<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $dates = ['created_at','updated_at','invoice_date','payment_duedate'];

    public function setInvoiceDateAttribute($value)
    {
    	$this->attributes['invoice_date'] = date('Y-m-d',strtotime(str_replace('/', '-', $value)));
    }

    public function setPaymentDuedateAttribute($value)
    {
    	$this->attributes['payment_duedate'] = date('Y-m-d',strtotime(str_replace('/', '-', $value)));
    }

    public function services()
    {
        return $this->hasMany('App\Service');
    }

    public function payment_records()
    {
        return $this->hasMany('App\PaymentRecord');
    }
}
