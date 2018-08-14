<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'lead_id', 'user_id', 'subject', 'datetime', 'content'
    ];

    protected $dates = ['datetime','created_at'];

    public function setDatetimeAttribute($value)
    {
    	$this->attributes['datetime'] = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $value)));
    }
}
