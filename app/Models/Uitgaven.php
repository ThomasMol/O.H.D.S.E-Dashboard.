<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uitgaven extends Model
{
    use SoftDeletes;

    protected $table = 'uitgaven';
    protected $primaryKey = 'uitgaven_id';
    protected $guarded = [];
}
