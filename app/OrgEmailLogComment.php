<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgEmailLogComment extends Model
{
    	protected $dates = ['updated_at','created_at'];

        public function emaillog()
        {
            return $this->belongsTo('App\OrgEmailLog');
        }

        public function user()
        {
            return $this->belongsTo('App\User');
        }
}
