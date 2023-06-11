<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Users extends Authenticatable
{

    protected $fillable = [
        'uid',
        'username',
        'password',
    ];


    protected $hidden = [
        'password',
    ];
}
