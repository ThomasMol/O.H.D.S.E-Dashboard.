<?php

namespace App\Imports;

use App\Transactie;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;


class TransactieImport implements ToCollection
{

    public function collection(Collection $rows)
    {
         $i = 0;
        foreach($rows as $row){

            if($i!=0){

                Transactie::create([
                    'datum' => Carbon::parse(strval($row[0]))->format("Y-m-d"),
                    'naam' => $row[1],
                    'tegenrekening' => $row[3],
                    'af_bij' => $row[5],
                    'bedrag' => str_replace(',','.',$row[6]),
                    'mutatie_soort' => $row[4],
                    'mededelingen' => $row[7],
                ]);
            }
            $i++;
        } 
    }
}
