<?php

namespace App\Exports;

use App\Models\HoaDonBanHang;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class HoaDonBanHangExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithStyles
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

    public function map($hoadonbanhang): array
    {
        return [
            $hoadonbanhang->name_table,
            $hoadonbanhang->first_last_name,
            $hoadonbanhang->tong_tien_truoc_giam,
            $hoadonbanhang->phan_tram_giam != 0 ? $hoadonbanhang->phan_tram_giam : '0',
            $hoadonbanhang->tien_thuc_nhan,
            $hoadonbanhang->is_done == 1 ? 'Đã Thanh Toán' : 'Chưa Thanh Toán',
        ];
    }

    public function headings(): array
    {
        return [
            'Bàn',
            'Tên Nhân Viên',
            'Tổng Tiền Trước Giảm',
            'Phần Trăm Giảm',
            'Tiền Thực Nhận',
            'Trạng Thái'
        ];
    }

    public function calculateTotalRevenue($invoices) {
        $totalRevenue = 0;
        foreach ($invoices as $invoice) {
            $totalRevenue += $invoice->tien_thuc_nhan;
        }
        return $totalRevenue;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:F1'; // Tất cả header
                $event->sheet->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getStyle('A1:F' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Lặp qua từng dòng để thiết lập màu sắc cho cột "Trạng Thái" (cột F)
                $lastRow = $event->sheet->getHighestRow();
                for ($row = 2; $row <= $lastRow; $row++) {
                    $statusCell = 'F' . $row; // Ô trong cột "Trạng Thái" ở dòng hiện tại
                    $status = $event->sheet->getCell($statusCell)->getValue();

                    // Kiểm tra giá trị của ô và thiết lập màu tương ứng
                    if ($status == 'Đã Thanh Toán') {
                        $event->sheet->getStyle($statusCell)
                            ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
                    } elseif ($status == 'Chưa Thanh Toán') {
                        $event->sheet->getStyle($statusCell)
                            ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                    }
                }

                // Calculate total revenue and add it at the bottom
                $totalRevenue = $this->calculateTotalRevenue($this->data);
                $event->sheet->setCellValue('E' . ($lastRow + 1), 'Tổng Doanh Thu:');
                $event->sheet->setCellValue('F' . ($lastRow + 1), $totalRevenue);
                $event->sheet->getStyle('E' . ($lastRow + 1) . ':F' . ($lastRow + 1))->getFont()->setBold(true);
                $event->sheet->getStyle('F' . ($lastRow + 1))->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'FFFF00']]],
        ];
    }
}


