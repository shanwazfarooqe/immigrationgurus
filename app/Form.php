<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
	protected $dates = ['created_at'];
	
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y',strtotime($value));
    }
}
