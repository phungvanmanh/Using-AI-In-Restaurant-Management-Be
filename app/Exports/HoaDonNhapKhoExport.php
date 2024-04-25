<?php

namespace App\Exports;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class HoaDonNhapKhoExport implements WithMultipleSheets
{
    use Exportable;
    private $data;
    private $length;

    public function __construct($data)
    {
        $this->data = $data;
        $this->length = count($data);  // Calculate length based on actual data
    }

    public function sheets(): array
    {
        $sheets = [];
        for ($i = 0; $i < $this->length; $i++) {  // Start from index 0 to length-1
            if (isset($this->data[$i])) {
                $sheets[] = new SingleSheetExport($i + 1, $this->data[$i]);
            }
        }
        return $sheets;
    }
}

class SingleSheetExport implements FromCollection, WithTitle,  WithEvents
{
    private $sheetNumber;
    private $data;

    public function __construct(int $sheetNumber, $data)
    {
        $this->sheetNumber = $sheetNumber;
        $this->data        = $data;
        Log::info("Sheet $sheetNumber Data:", $this->data);
    }

    public function collection()
    {
        return collect([
            ['Row 1', 'Sheet' . $this->sheetNumber],
            ['Row 2', 'Sheet' . $this->sheetNumber],
        ]);
    }

    public function title(): string
    {
        return 'Sheet' . $this->sheetNumber;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(2)->setRowHeight(45);
                $sheet->getRowDimension(3)->setRowHeight(30);

                $headerStyle = [
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => StyleAlignment::HORIZONTAL_CENTER],
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FFFF00']],
                ];
                $headerStyleHeder = [
                    'alignment' => ['horizontal' => StyleAlignment::HORIZONTAL_LEFT],
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
                ];
                $headerStyleFoodter = [
                    'alignment' => ['horizontal' => StyleAlignment::HORIZONTAL_RIGHT],
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
                ];

                $sheet = $event->sheet;

                // Access data for the sheet
                $diaChi = $this->data['dia_chi'] ?? 'Default Address';
                $maSoThue = $this->data['ma_so_thue'] ?? 'Default Tax Code';
                $nguoiMua = $this->data['first_last_name'] ?? 'Default Buyer';
                $tenCongTy = $this->data['ten_cong_ty'] ?? 'N/A';
                $tongTien = $this->data['tong_tien'] ?? '000';
                $list = $this->data['list'] ?? 'N/A';
                $sheet->getStyle('A1:F1')->getAlignment()->setWrapText(true);
                $sheet->getStyle('A2:F2')->getAlignment()->setWrapText(true);
                $sheet->getStyle('A3:F3')->getAlignment()->setWrapText(true);
                $sheet->setCellValue('A1', "HÓA ĐƠN NHẬP HÀNG\n" . "Ngày 26 Tháng 04 Năm 2024");
                $sheet->setCellValue('A2', "Đơn vị bán hàng:$tenCongTy\n" . "Địa chỉ:$diaChi\n" . "Mã số thuế:$maSoThue");
                $sheet->setCellValue('A3', "Họ tên người mua:$nguoiMua\n" . "Địa chỉ:Đà Nẵng");
                $sheet->getDelegate()->setCellValue('A4', 'STT');
                $sheet->getDelegate()->setCellValue('B4', 'Tên Hàng hóa, dịch vụ');
                $sheet->getDelegate()->setCellValue('C4', 'Đơn vị tính');
                $sheet->getDelegate()->setCellValue('D4', 'Số lượng');
                $sheet->getDelegate()->setCellValue('E4', 'Đơn Giá');
                $sheet->getDelegate()->setCellValue('F4', 'Thành tiền');

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(20);

                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $sheet->mergeCells('A3:F3');

                $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);
                $sheet->getStyle('A2:F2')->applyFromArray($headerStyleHeder);
                $sheet->getStyle('A3:F3')->applyFromArray($headerStyleHeder);
                $sheet->getStyle('A4')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
                $sheet->getStyle('B4')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
                $sheet->getStyle('C4')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
                $sheet->getStyle('D4')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
                $sheet->getStyle('E4')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
                $sheet->getStyle('F4')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
                $startingRow = 5;
                foreach ($list as $index => $item) {
                    $currentRow = $startingRow + $index;
                    $sheet->setCellValue('A' . $currentRow, $index + 1);
                    $sheet->setCellValue('B' . $currentRow, $item['ten_nguyen_lieu']);
                    $sheet->setCellValue('C' . $currentRow, $item['don_vi_tinh']);
                    $sheet->setCellValue('D' . $currentRow, $item['so_luong']);
                    $sheet->setCellValue('E' . $currentRow, $item['don_gia']);
                    $sheet->setCellValue('F' . $currentRow, $item['thanh_tien']);
                    $sheet->getStyle('A' . $currentRow)->applyFromArray([
                        'borders' => [
                            'outline' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ],
                    ]);
                    $sheet->getStyle('B' . $currentRow)->applyFromArray([
                        'borders' => [
                            'outline' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ],
                    ]);
                    $sheet->getStyle('C' . $currentRow)->applyFromArray([
                        'borders' => [
                            'outline' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ],
                    ]);
                    $sheet->getStyle('D' . $currentRow)->applyFromArray([
                        'borders' => [
                            'outline' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ],
                    ]);
                    $sheet->getStyle('E' . $currentRow)->applyFromArray([
                        'borders' => [
                            'outline' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ],
                    ]);
                    $sheet->getStyle('F' . $currentRow)->applyFromArray([
                        'borders' => [
                            'outline' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ],
                    ]);
                    $sheet->getStyle('F' . $currentRow)->getNumberFormat()->setFormatCode('#,##0" VNĐ"');
                }

                $leghtData = $startingRow + count($list);
                $sheet->mergeCells('A' . $leghtData . ':E' . $leghtData);
                $sheet->setCellValue('A' . $leghtData, 'Tổng cộng tiền thanh toán:');
                $sheet->getStyle('A' . $leghtData . ':E' . $leghtData)->applyFromArray($headerStyleFoodter);
                // $sheet->setCellValue('F' . $leghtData, '100000');
                $sheet->setCellValue('F' . $leghtData, $tongTien);
                $sheet->getStyle('F' . $leghtData)->getNumberFormat()->setFormatCode('#,##0" VNĐ"');
                $sheet->getStyle('F' . $leghtData)->applyFromArray($headerStyleFoodter);
            }
        ];
    }
}
