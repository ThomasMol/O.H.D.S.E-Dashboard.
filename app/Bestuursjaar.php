<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bestuursjaar extends Model
{
    protected $table = 'bestuursjaar';
    protected $primaryKey = 'jaargang';
    protected $guarded = [];
}
