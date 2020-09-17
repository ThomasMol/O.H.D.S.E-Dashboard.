<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Lid;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LedenExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $leden = Lid::select('type_lid','roepnaam','voornamen','achternaam','email','telefoonnummer','straatnaam','postcode','stad','land', 'geboorteplaats', 'geboortedatum','lichting')
        ->leftJoin('lid_gegevens', 'lid.lid_id','lid_gegevens.lid_id')
        ->orderBy('type_lid','asc')->orderBy('roepnaam','asc')->get();
        return $leden;
    }

    public function headings(): array
    {
        return [
            'Type lid',
            'Roepnaam',
            'Voornamen',
            'Achternaam',
            'Emailadres',
            'Telefoonnummer',
            'Straatnaam',
            'Postcode',
            'Stad',
            'Land',
            'Geboorteplaats',
            'Geboortedatum',
            'Lichting'
        ];
    }
}
