<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;


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


