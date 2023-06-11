<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;


class MeetingSchedule extends Authenticatable
{

    public $timestamps = false;
    protected $fillable = [
        'uid',
        'name',
        'birthday',
        'birthtime',
        
        'meeting-date',
        'meeting-method',
        'meeting-time',
        'note',

        'phone',
        'email',
        'date-create',
    ];

}
