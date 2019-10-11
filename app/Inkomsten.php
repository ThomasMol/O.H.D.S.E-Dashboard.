<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inkomsten extends Model
{
    protected $table = 'inkomsten';
    protected $primaryKey = 'jaargang';
    protected $guarded = [];
}
