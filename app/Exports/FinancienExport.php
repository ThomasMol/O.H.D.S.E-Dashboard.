<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Financien;
use App\Lid;

class FinancienExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $financien = Lid::select('type_lid','roepnaam','achternaam', 'verschuldigd','overgemaakt','schuld','gespaard')
        ->leftJoin('financien', 'lid.lid_id','financien.lid_id')
        ->orderBy('schuld','desc')->get();
        return $financien;
    }

    public function headings(): array
    {
        return [
            'Type lid',
            'Naam',
            'Achternaam',
            'Verschuldigd',
            'Overgemaakt',
            'Schuld',
            'Gespaard'
        ];
    }
}
