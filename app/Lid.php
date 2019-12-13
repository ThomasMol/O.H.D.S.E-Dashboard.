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

    public function scopeLedenGesorteerd($query){
        return $query->where('type_lid','!=','Geen')->orderBy('type_lid','asc')->orderBy('roepnaam','asc');
    }
}
