<?php

namespace App\Http\Controllers;

use App\Models\PemesananKendaraan;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportPemesanan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $query = PemesananKendaraan::with(['user', 'kendaraan', 'approver1', 'approver2']);

        if ($bulan && $tahun) {
            $query->whereMonth('tanggal_mulai', $bulan)
                ->whereYear('tanggal_mulai', $tahun);
        }

        $pemesanan = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = [
            'A1' => 'Pemesan',
            'B1' => 'Kendaraan',
            'C1' => 'Driver',
            'D1' => 'Approver 1',
            'E1' => 'Approver 2',
            'F1' => 'Tanggal Mulai',
            'G1' => 'Tanggal Selesai',
            'H1' => 'Keperluan',
            'I1' => 'Status',
        ];

        foreach ($headers as $cell => $title) {
            $sheet->setCellValue($cell, $title);
        }

        // Styling Header
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'DDEBF7']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ];

        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);
        $sheet->getRowDimension('1')->setRowHeight(25);

        // Data Rows
        $row = 2;
        foreach ($pemesanan as $item) {
            $sheet->setCellValue('A' . $row, $item->user->name ?? '-');
            $sheet->setCellValue('B' . $row, $item->kendaraan->nama ?? '-');
            $sheet->setCellValue('C' . $row, $item->driver);
            $sheet->setCellValue('D' . $row, $item->approver1->name ?? '-');
            $sheet->setCellValue('E' . $row, $item->approver2->name ?? '-');
            $sheet->setCellValue('F' . $row, $item->tanggal_mulai ? Carbon::parse($item->tanggal_mulai)->format('d-m-Y') : '-');
            $sheet->setCellValue('G' . $row, $item->tanggal_selesai ? Carbon::parse($item->tanggal_selesai)->format('d-m-Y') : '-');
            $sheet->setCellValue('H' . $row, $item->keperluan);
            $sheet->setCellValue('I' . $row, ucfirst($item->status));
            $row++;
        }

        // Styling all data rows
        $dataRange = 'A2:I' . ($row - 1);
        $sheet->getStyle($dataRange)->applyFromArray([
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ]);

        // Auto-size all columns
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'pemesanan_kendaraan.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
