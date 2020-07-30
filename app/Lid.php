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
        return $query->orderBy('type_lid','asc')->orderBy('roepnaam','asc');
    }
    public function scopeActieveLeden($query){
        return $query->where('type_lid','Actief')->orderBy('roepnaam','asc');
    }
    public function scopePassieveLeden($query){
        return $query->where('type_lid','Passief')->orderBy('roepnaam','asc');
    }
    public function scopeReunisten($query){
        return $query->where('type_lid','Reünist')->orderBy('roepnaam','asc');
    }
    public function scopeGeenLeden($query){
        return $query->where('type_lid','Geen')->orderBy('roepnaam','asc');
    }

    public function scopeLidDeelname($query,$table,$id){
        return $query->select('lid.lid_id', 'roepnaam', 'achternaam',$table.'.lid_id as deelname','type_lid')->leftJoin($table, function($join) use ($id, $table){
            $join->on('lid.lid_id', $table . '.lid_id');
            $join->where($table . '.contributie_id',$id);
        });
    }

    public function lidTypeOptions(){
        return [
            'Actief' => 'Actief',
            'Passief' => 'Passief',
            'Reünist' => 'Reünist',
            'Geen' => 'Geen',
        ];
    }
    public function adminOptions(){
        return [
            0 => 'Nee',
            1 => 'Ja'
        ];
    }
}
