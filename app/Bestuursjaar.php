<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bestuursjaar extends Model
{
    protected $table = 'bestuursjaar';
    protected $primaryKey = 'jaargang';
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'van','tot'];

    public function scopeHuidigJaar($query){
        $date = date('Y-m-d');
        return $query->where('tot','>=',$date)->where('van','<=',$date)->firstOr(function(){
            return $last_bestuursjaar = Bestuursjaar::latest('tot')->firstOrFail();
        });
    }
}
