<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrelAanwezigheid extends Model
{
    protected $guarded = [];
    protected $table = 'borrel_aanwezigheid';
    protected $primaryKey = 'lid_id';
}
