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
    protected $additionalInfo;

    public function __construct($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;
    }

    public function collection()
    {
        // Create an array with the title row and data rows
        $data = [
            [
                "SE rekening",
                $this->additionalInfo['serekening'],
            ],
            [
                "SE liquiditeit",
                $this->additionalInfo['liquiditeit'],
            ],
            [
                "Totaal Bij",
                $this->additionalInfo['bij'],
            ],
            [
                "Totaal Af",
                $this->additionalInfo['af'],
            ],
            [
                "Totaal Uitgaven",
                $this->additionalInfo['uit'],
            ],
        ];

        // Add an empty row for spacing
        $data[] = [];

        // Add the headings row
        $data[] = [
            'Type lid',
            'Naam',
            'Achternaam',
            'Verschuldigd',
            'Overgemaakt',
            'Schuld',
            'Gespaard'
        ];

        $financien = Lid::select('type_lid','roepnaam','achternaam', 'verschuldigd','overgemaakt','schuld','gespaard')
            ->leftJoin('financien', 'lid.lid_id','financien.lid_id')
            ->orderBy('schuld','desc')->get();

        foreach ($financien as $item) {
            $data[] = [
                $item->type_lid,
                $item->roepnaam,
                $item->achternaam,
                $item->verschuldigd,
                $item->overgemaakt,
                $item->schuld,
                $item->gespaard,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [];
    }
}