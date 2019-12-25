<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kosten extends Model
{
    protected $table = 'kosten';
    protected $primaryKey = 'kosten_id';
    protected $guarded = [];

    public function kostenOptions(){
        return [
            'boete'=>'Boete',
            'kosten_niet_lid' => 'Extra kosten niet actief lid',
            'overig' => 'Overig'
        ];
    }
}
