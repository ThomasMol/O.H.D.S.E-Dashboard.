<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

class InkomstenUitgavenExport implements FromView, WithHeadings
{
    protected $inkomstenList;
    protected $uitgavenList;
    protected $additionalInfo;

    public function __construct($inkomstenList, $uitgavenList, $additionalInfo)
    {
        $this->inkomstenList = $inkomstenList;
        $this->uitgavenList = $uitgavenList;
        $this->additionalInfo = $additionalInfo;
    }

    public function view(): View
    {
        return ViewFacade::make('exports.inkomsten_uitgaven', [
            'inkomstenList' => $this->inkomstenList,
            'uitgavenList' => $this->uitgavenList,
            'additionalInfo' => $this->additionalInfo,
        ]);
    }

    public function headings(): array
    {
        // Add the headings for the Type lid, Naam, etc.
        return [];
    }
}
