<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekeningnummer extends Model
{
    protected $table = 'rekeningnummer';
    protected $primaryKey = 'lid_id';
    protected $fillable = ['rekeningnummer'];
}
