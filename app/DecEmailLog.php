<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DecEmailLog extends Model
{
    protected $dates = ['updated_at','created_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function emaillogcomments()
    {
        return $this->hasMany('App\DecEmailLogComment');
    }
}
