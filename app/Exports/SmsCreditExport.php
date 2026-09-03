<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SmsCreditExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected $records;

    public function __construct(Collection $records)
    {
        $this->records = $records;
    }

    public function collection()
    {
        $rows = $this->records->map(function ($row) {

            return [

                optional($row->branch)->branch_name,

                Carbon::parse($row->date)->format('d-m-Y')
                . "\n"
                . Carbon::parse($row->created_at)->format('h:i A'),

                $row->message,

                number_format($row->submit_count),

                number_format($row->credit),

            ];

        });

        // Total Row
        $rows->push([
            '',
            '',
            'TOTAL',
            number_format($this->records->sum('submit_count')),
            number_format($this->records->sum('credit')),
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Branch',
            'Date & Time',
            'Message',
            'Submit Count',
            'Credit',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Heading
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '0D6EFD',
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Wrap Date & Message
        $sheet->getStyle('B:B')->getAlignment()->setWrapText(true);
        $sheet->getStyle('C:C')->getAlignment()->setWrapText(true);

        // Message Left Align
        $sheet->getStyle('C:C')->getAlignment()->setHorizontal(
            Alignment::HORIZONTAL_LEFT
        );

        // Other Columns Center
        $sheet->getStyle('A:B')->getAlignment()->setHorizontal(
            Alignment::HORIZONTAL_CENTER
        );

        $sheet->getStyle('D:E')->getAlignment()->setHorizontal(
            Alignment::HORIZONTAL_CENTER
        );

        // Vertical Center
        $sheet->getStyle('A:E')->getAlignment()->setVertical(
            Alignment::VERTICAL_CENTER
        );

        return [];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                $lastRow = $sheet->getHighestRow();

                // Borders
                $sheet->getStyle("A1:E{$lastRow}")
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                // Total Row
                $sheet->getStyle("A{$lastRow}:E{$lastRow}")
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'FFF3CD',
                            ],
                        ],
                    ]);

                // Row Height Auto
                for ($i = 2; $i <= $lastRow; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(-1);
                }

                // Column Width (Optional)
                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(22);
                $sheet->getColumnDimension('C')->setWidth(60);
                $sheet->getColumnDimension('D')->setWidth(15);
                $sheet->getColumnDimension('E')->setWidth(15);
            }

        ];
    }
}