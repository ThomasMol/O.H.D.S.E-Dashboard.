<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LidGegevens extends Model
{
    protected $guarded = ['lid_id'];
    protected $table = 'lid_gegevens';
    protected $primaryKey = 'lid_id';
}
