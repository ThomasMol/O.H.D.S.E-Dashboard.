<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDO;

class Contributie extends Model
{
    protected $guarded = [];
    protected $table = 'contributie';
    protected $primaryKey = 'contributie_id';


    //Not used
    public function contributieSoortOptions(){
        return [
            'Maandcontributie' => 'Maandcontributie',
            'Half jaars contributie' => 'Half jaars contributie',
            'Kerstdiner' => 'Kerstdiner',
            '1e Weekend' => '1e Weekend',
            '2e Weekend' => '2e Weekend',
            'Overig' => 'Overig'
        ];
    }

}



