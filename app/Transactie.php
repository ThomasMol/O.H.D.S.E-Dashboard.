<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactie extends Model
{
    protected $table = 'transactie';
    protected $primaryKey = 'transactie_id';
    protected $guarded = [];
}
