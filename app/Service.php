<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'invoice_id', 'name', 'description', 'hrs', 'rate'
    ];
}
