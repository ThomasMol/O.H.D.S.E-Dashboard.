<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inkomsten extends Model
{
    use SoftDeletes;

    protected $table = 'inkomsten';
    protected $primaryKey = 'inkomsten_id';
    protected $guarded = [];

}
