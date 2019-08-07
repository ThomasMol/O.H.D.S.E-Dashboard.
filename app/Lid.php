<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lid extends Model
{

    use SoftDeletes;
    protected $guarded = ['password'];
    protected $table = 'lid';
    protected $primaryKey = 'lid_id';


}
