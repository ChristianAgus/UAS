<?php

namespace App\Exports;

use Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\LogBook;
use App\UserMap;
use Carbon\Carbon;
use Auth;

class LBReportExport implements FromView, WithEvents
{
    public function view(): View
    {
        if (Request::input('fromExcel') &&  Request::input('toExcel')) {
            $dataFilter = LogBook::query();

            $fromDate = Request::input('fromExcel');
            $toDate = Request::input('toExcel');

            if ($fromDate && $toDate) {
                $dataFilter->whereBetween('created_at', [$fromDate, $toDate]);
            }

            $data['logs'] = $dataFilter->get();
            $data['title'] = "LogBook Report from {$fromDate} to {$toDate}";

            return view('logbooks.reportexcel', $data);
        } else {
            return redirect()->back();
        }
    }

    // You can customize the AfterSheet event if needed
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->styleCells(  
                    'A:T',
                    [
                        'alignment' => [
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ]
                    ]
                );
               
            },
        ];
    }
}
