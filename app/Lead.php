<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public function social()
    {
        return $this->belongsTo('App\Social');
    }

    public function visa()
    {
        return $this->belongsTo('App\Visa');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
