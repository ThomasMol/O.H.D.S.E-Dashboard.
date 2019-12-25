<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UitgaveDeelname extends Model
{
    protected $table = 'uitgave_deelname';
    public $incrementing = false;
    
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('uitgave_id', '=', $this->getAttribute('uitgave_id'))
            ->where('lid_id', '=', $this->getAttribute('lid_id'));
        return $query;
    }
}
