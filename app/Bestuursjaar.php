<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bestuursjaar extends Model
{
    protected $table = 'bestuursjaar';
    protected $primaryKey = 'jaargang';
    protected $guarded = [];

    public function scopeHuidigJaar($query){
        $date = date('Y-m-d');
        return $query->where('tot','>=',$date)->where('van','<=',$date)->first();
    }
}
