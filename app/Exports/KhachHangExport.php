<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;
class KhachHangExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithStyles
{
    use Exportable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data)->map(function ($item, $index) {
            $itemArray = $item->toArray();  // Explicitly convert to array if $item is an Eloquent model
            return array_merge(['index' => $index + 1], $itemArray);
        });
    }

    public function map($item): array
    {
        return [
            $item['index'],
            $item['ten_khach_hang'] ?? 'N/A',  // Default to 'N/A' if not set
            $item['email'] ?? 'N/A',  // Default to 'N/A' if not set
            $item['so_dien_thoai'] ?? 'N/A',  // Default to 'N/A' if not set
        ];
    }

    public function headings(): array
    {
        return [
            'STT',
            'ten_khach_hang',
            'email',
            'so_dien_thoai',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:D1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);

                // Đóng khung toàn bộ sheet
                $event->sheet->getDelegate()->getStyle(
                    'A1:D' . $event->sheet->getDelegate()->getHighestRow()
                )->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'FFFF00']]],
        ];
    }

}
