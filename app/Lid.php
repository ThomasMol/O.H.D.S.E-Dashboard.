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

    public function scopeLidDeelname($query,$table_deelname,$model_id,$id){
        return $query->select('lid.lid_id', 'roepnaam', 'achternaam',$table_deelname.'.lid_id as deelname','type_lid')->leftJoin($table_deelname, function($join) use ($id, $table_deelname, $model_id){
            $join->on('lid.lid_id', $table_deelname . '.lid_id');
            $join->where($table_deelname . '.' . $model_id,$id);
        });
    }

    public function scopeLidDeelnameUitgave($query,$table_deelname,$model_id,$id){
        return $query->select('lid.lid_id', 'roepnaam', 'achternaam',
        $table_deelname.'.lid_id as aanwezig',
        $table_deelname.'.afgemeld as afgemeld',
        $table_deelname.'.naheffing as naheffing',
        $table_deelname.'.boete_id as boete_id',
        $table_deelname.'.extra_kosten_id as extra_kosten_id',
        'type_lid')->leftJoin($table_deelname, function($join) use ($id, $table_deelname, $model_id){
            $join->on('lid.lid_id', $table_deelname . '.lid_id');
            $join->where($table_deelname . '.' . $model_id,$id);
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
