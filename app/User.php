<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'first_name', 'last_name', 'phone', 'email', 'password', 'address', 'image', 'level', 'company', 'logo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role','level');
    }

    public function parent()
    {
        return $this->belongsTo('App\User', 'company');
    }

    public function children()
    {
        return $this->hasMany('App\User', 'company');
    }
}
