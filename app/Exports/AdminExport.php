<?php

namespace App\Exports;

use App\Models\Admin;
use Maatwebsite\Excel\Facades\Excel;
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

class AdminExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithStyles
{
    use Exportable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($admin): array
    {
        return [
            $admin->first_last_name,
            $admin->email,
            $admin->phone_number,
            $this->formatDateOfBirth($admin->date_birth),
            $admin->status == 1 ? 'Đang làm' : 'Đã nghỉ',
            $admin->name_permission
        ];
    }

    public function headings(): array
    {
        return [
            'First Last Name',
            'Email',
            'Phone Number',
            'Date of Birth',
            'Status',
            'Permission Name'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:F1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);

                // Đóng khung toàn bộ sheet
                $event->sheet->getDelegate()->getStyle(
                    'A1:F' . $event->sheet->getDelegate()->getHighestRow()
                )->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }

    protected function formatDateOfBirth($dateOfBirth)
    {
        if (empty($dateOfBirth)) return null;
        return \Carbon\Carbon::createFromFormat('Y-m-d', $dateOfBirth)->format('d/m/Y');
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'FFFF00']]],
        ];
    }

}
