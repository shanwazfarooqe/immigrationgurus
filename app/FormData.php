<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
	protected $dates = ['created_at'];
	
    public function form()
    {
        return $this->belongsTo('App\Form');
    }
	
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
