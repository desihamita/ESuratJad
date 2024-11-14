<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Events\AfterSheet;

class DosenPromotionExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithEvents, ShouldAutoSize
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct($data, $startDate, $endDate)
    {
        $this->data = $data;
        $this->startDate = \Carbon\Carbon::parse($startDate)->format('F Y');
        $this->endDate = \Carbon\Carbon::parse($endDate)->format('F Y');
    }

    public function collection()
    {
        return $this->data->map(function($item, $index) {
            return [
                'No' => $index + 1,
                'Nama' => $item->nama_dosen,
                'Jabatan Akademik Sebelumnya' => $item->jabatan_akademik_sebelumnya,
                'Jabatan Akademik Diusulkan' => $item->jabatan_akademik_di_usulkan,
                'Tanggal Proses' => \Carbon\Carbon::parse($item->tanggal_proses)->format('d F Y'),
                'Tanggal Selesai' => \Carbon\Carbon::parse($item->tanggal_selesai)->format('d F Y'),
                'Surat Pengantar Pimpinan' => $item->surat_pengantar_pimpinan_pts 
                    ? '=HYPERLINK("' . url($item->surat_pengantar_pimpinan_pts) . '", "Klik untuk buka file")'
                    : null,
                'Berita Acara Senat' => $item->berita_acara_senat 
                    ? '=HYPERLINK("' . url($item->berita_acara_senat) . '", "Klik untuk buka file")'
                    : null, 
            ];
        });
    }

    public function headings(): array
    {
        return [
            ['Laporan Data Dosen'], // Report title
            ['Periode : ' . $this->startDate . ' - ' . $this->endDate], // Report period
            [], // Empty row
            ['No', 'Nama', 'Jabatan Akademik Sebelumnya', 'Jabatan Akademik Diusulkan', 'Tanggal Proses', 'Tanggal Selesai', 'Surat Pengantar Dosen', 'Berita Acara Senat'], // Table header
        ];
    }

    public function title(): string
    {
        return 'Laporan Data Dosen';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style for the report title
            'A1' => ['font' => ['bold' => true, 'size' => 20]],
            'A2' => ['font' => ['italic' => true, 'size' => 12]],
            // Align title and period to the center
            'A1:H1' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'A2:H2' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]],
            // Style for table header
            'A4:H4' => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF2CC']],
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
            // Set borders for data rows
            'A5:H' . ($this->data->count() + 4) => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function($event) {
                // Merge cells for title and period rows
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->mergeCells('A2:H2');
                // Auto size columns for readability
                foreach (range('A', 'H') as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
