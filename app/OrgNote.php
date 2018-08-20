<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgNote extends Model
{
    protected $fillable = [
        'organization_id', 'user_id', 'content'
    ];

    protected $dates = ['created_at'];
}
