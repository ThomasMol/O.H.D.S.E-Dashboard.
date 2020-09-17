<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SErekening extends Model
{
    //
    protected $table = 'semper_excelsius_rekening';
    protected $primaryKey = 'rekening_id';
    protected $guarded = [];
}
