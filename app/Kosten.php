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
            'extra_kosten' => 'Extra kosten niet actief lid',
            'overig' => 'Overig'
        ];
    }
}
