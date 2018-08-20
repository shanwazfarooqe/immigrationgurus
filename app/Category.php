<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function forms()
    {
        return $this->hasMany('App\Form');
    }

    public function form_datas()
    {
        return $this->hasManyThrough('App\FormData','App\Form');
    }
}
