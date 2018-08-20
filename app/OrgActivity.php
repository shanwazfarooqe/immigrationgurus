<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgActivity extends Model
{
    protected $fillable = [
        'organization_id', 'user_id', 'log_a_call', 'out_come', 'datetime', 'content'
    ];

    protected $dates = ['datetime','created_at'];

    public function setDatetimeAttribute($value)
    {
    	$this->attributes['datetime'] = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $value)));
    }
}
