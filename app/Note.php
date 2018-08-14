<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'lead_id', 'user_id', 'content'
    ];

    protected $dates = ['created_at'];
}
