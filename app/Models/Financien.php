<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financien extends Model
{
    protected $guarded = ['lid_id'];
    protected $table = 'financien';
    protected $primaryKey = 'lid_id';
}
