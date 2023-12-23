<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Financien;
use App\Models\Lid;
use App\Models\SErekening;
use App\Models\Transactie;
use App\Models\Uitgave;

class FinancienExport implements FromCollection, WithHeadings
{
    public function __construct()
    {
        
    }

    public function collection()
    {
        $financien = Lid::select('type_lid','roepnaam','achternaam', 'verschuldigd','overgemaakt','schuld','gespaard')
        ->leftJoin('financien', 'lid.lid_id','financien.lid_id')
        ->orderBy('schuld','desc')->get();
        return $financien;
    }

    public function headings(): array
    {
        // Add the headings for the Type lid, Naam, etc.
        return [
            'Type lid',
            'Naam',
            'Achternaam',
            'Verschuldigd',
            'Overgemaakt',
            'Schuld',
            'Gespaard',
        ];
    }
}
