<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uitgave extends Model
{
    protected $guarded = [];
    protected $table = 'uitgave';
    protected $primaryKey = 'uitgave_id';
}
