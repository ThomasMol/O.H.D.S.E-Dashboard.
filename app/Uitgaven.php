<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uitgaven extends Model
{
    protected $table = 'uitgaven';
    protected $primaryKey = 'uitgaven_id';
    protected $guarded = [];
}
