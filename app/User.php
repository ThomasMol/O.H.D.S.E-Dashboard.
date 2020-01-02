<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $fillable = [
        'email', 'password',
    ];


    protected $hidden = [
        'password',
    ];

    protected $table = 'lid';
    protected $primaryKey = 'lid_id';
    public $remember_token=false;

}


