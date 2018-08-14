<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    public function mailTemplate()
    {
        return $this->hasOne('App\MailTemplate');
    }

    public function module()
    {
        return $this->belongsTo('App\Module');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d M Y',strtotime($value));
    }
}
