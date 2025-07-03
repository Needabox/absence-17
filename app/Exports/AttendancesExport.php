<?php
namespace App\Exports;

use App\Models\Attendance;
use App\Models\Classes;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AttendancesExport implements FromArray, WithEvents, WithTitle
{
    protected $date;
    protected $rowStyles = [];

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function array(): array
    {
        $rows = [];
        $currentRow = 1;

        // Header Laporan
        $rows[] = ['LAPORAN PIKET KBM HARIAN'];
        $this->rowStyles[$currentRow] = ['type' => 'title', 'merge' => 'A:H'];
        $currentRow++;

        $rows[] = ['SMK NEGERI 17 JAKARTA'];
        $this->rowStyles[$currentRow] = ['type' => 'subtitle', 'merge' => 'A:H'];
        $currentRow++;

        // Menentukan semester berdasarkan bulan
        $month = date('n', strtotime($this->date));
        $year = date('Y', strtotime($this->date));
        if ($month >= 7 && $month <= 12) {
            $semester = 'GANJIL';
            $tahunAjaran = $year . '/' . ($year + 1);
        } else {
            $semester = 'GENAP';
            $tahunAjaran = ($year - 1) . '/' . $year;
        }

        $rows[] = ['SEMESTER ' . $semester . ' TAHUN AJARAN ' . $tahunAjaran];
        $this->rowStyles[$currentRow] = ['type' => 'subtitle', 'merge' => 'A:H'];
        $currentRow++;

        $rows[] = [''];
        $currentRow++;

        $rows[] = ['LAPORAN KETIDAKHADIRAN SISWA (' . date('d F Y', strtotime($this->date)) . ')'];
        $this->rowStyles[$currentRow] = ['type' => 'report_title', 'merge' => 'A:H'];
        $currentRow++;

        $rows[] = [''];
        $currentRow++;

        // Ambil classes berdasarkan major_id dan kelompokkan
        $classesByMajor = Classes::with('major')->orderBy('major_id')->orderBy('name')->get()->groupBy('major_id');
        $rekapPerKelas = [];

        foreach ($classesByMajor as $majorId => $classes) {
            $majorName = $classes->first()->major->name ?? 'Major ' . $majorId;

            // Header Major
            $rows[] = ['JURUSAN: ' . $majorName];
            $this->rowStyles[$currentRow] = ['type' => 'major_header', 'merge' => 'A:H'];
            $currentRow++;

            $rows[] = [''];
            $currentRow++;

            // Bagi kelas menjadi pasangan (2 kelas per baris)
            $classArray = $classes->toArray();
            $classPairs = array_chunk($classArray, 2);

            foreach ($classPairs as $pair) {
                $class1 = $pair[0];
                $class2 = isset($pair[1]) ? $pair[1] : null;

                // Header untuk 2 kelas berdampingan
                $headerRow = [
                    'KELAS: ' . $class1['name'], '', '', ''
                ];

                if ($class2) {
                    $headerRow = array_merge($headerRow, ['KELAS: ' . $class2['name'], '', '', '']);
                } else {
                    $headerRow = array_merge($headerRow, ['', '', '', '']);
                }

                $rows[] = $headerRow;
                $this->rowStyles[$currentRow] = ['type' => 'class_header_pair'];
                $currentRow++;

                // Header kolom untuk kedua kelas
                $columnHeaderRow = [
                    'Nama Siswa', 'NIS', 'Status Kehadiran', ''
                ];

                if ($class2) {
                    $columnHeaderRow = array_merge($columnHeaderRow, ['Nama Siswa', 'NIS', 'Status Kehadiran', '']);
                } else {
                    $columnHeaderRow = array_merge($columnHeaderRow, ['', '', '', '']);
                }

                $rows[] = $columnHeaderRow;
                $this->rowStyles[$currentRow] = ['type' => 'table_header_pair'];
                $currentRow++;

                // Ambil data absensi untuk kedua kelas
                $absensi1 = Attendance::with('student')
                    ->where('class_id', $class1['id'])
                    ->where('date', $this->date)
                    ->whereIn('status', [2, 3, 4])
                    ->get();

                $absensi2 = [];
                if ($class2) {
                    $absensi2 = Attendance::with('student')
                        ->where('class_id', $class2['id'])
                        ->where('date', $this->date)
                        ->whereIn('status', [2, 3, 4])
                        ->get();
                }

                // Hitung jumlah data maksimal untuk menentukan jumlah baris
                $maxRows = max($absensi1->count(), count($absensi2), 1);

                // Buat baris data untuk kedua kelas
                for ($i = 0; $i < $maxRows; $i++) {
                    $dataRow = ['', '', '', ''];

                    // Data kelas 1
                    if ($i < $absensi1->count()) {
                        $a1 = $absensi1[$i];
                        $statusText1 = match ($a1->status) {
                            2 => 'Sakit',
                            3 => 'Izin',
                            4 => 'Alpha',
                            default => 'Tidak Diketahui'
                        };
                        $dataRow[0] = $a1->student->name;
                        $dataRow[1] = $a1->student->nis;
                        $dataRow[2] = $statusText1;
                    } elseif ($i == 0 && $absensi1->count() == 0) {
                        $dataRow[0] = 'Tidak ada siswa yang tidak hadir';
                        $dataRow[1] = '-';
                        $dataRow[2] = '-';
                    }

                    // Data kelas 2
                    if ($class2) {
                        if ($i < count($absensi2)) {
                            $a2 = $absensi2[$i];
                            $statusText2 = match ($a2->status) {
                                2 => 'Sakit',
                                3 => 'Izin',
                                4 => 'Alpha',
                                default => 'Tidak Diketahui'
                            };
                            $dataRow[4] = $a2->student->name;
                            $dataRow[5] = $a2->student->nis;
                            $dataRow[6] = $statusText2;
                        } elseif ($i == 0 && count($absensi2) == 0) {
                            $dataRow[4] = 'Tidak ada siswa yang tidak hadir';
                            $dataRow[5] = '-';
                            $dataRow[6] = '-';
                        }
                    }

                    $rows[] = $dataRow;
                    $this->rowStyles[$currentRow] = ['type' => 'data_row_pair'];
                    $currentRow++;
                }

                // Hitung subtotal untuk kedua kelas
                $jumlah1 = ['sakit' => 0, 'izin' => 0, 'alpha' => 0];
                foreach ($absensi1 as $a) {
                    if ($a->status == 2) $jumlah1['sakit']++;
                    if ($a->status == 3) $jumlah1['izin']++;
                    if ($a->status == 4) $jumlah1['alpha']++;
                }

                $jumlah2 = ['sakit' => 0, 'izin' => 0, 'alpha' => 0];
                if ($class2) {
                    foreach ($absensi2 as $a) {
                        if ($a->status == 2) $jumlah2['sakit']++;
                        if ($a->status == 3) $jumlah2['izin']++;
                        if ($a->status == 4) $jumlah2['alpha']++;
                    }
                }

                // Baris subtotal
                $subtotalRow = [
                    'Subtotal ' . $class1['name'] . ':',
                    'Sakit: ' . $jumlah1['sakit'],
                    'Izin: ' . $jumlah1['izin'] . ' | Alpha: ' . $jumlah1['alpha'],
                    ''
                ];

                if ($class2) {
                    $subtotalRow = array_merge($subtotalRow, [
                        'Subtotal ' . $class2['name'] . ':',
                        'Sakit: ' . $jumlah2['sakit'],
                        'Izin: ' . $jumlah2['izin'] . ' | Alpha: ' . $jumlah2['alpha'],
                        ''
                    ]);
                } else {
                    $subtotalRow = array_merge($subtotalRow, ['', '', '', '']);
                }

                $rows[] = $subtotalRow;
                $this->rowStyles[$currentRow] = ['type' => 'subtotal_pair'];
                $currentRow++;

                // Simpan data untuk rekapitulasi
                $rekapPerKelas[] = [
                    $class1['name'],
                    $jumlah1['sakit'],
                    $jumlah1['izin'],
                    $jumlah1['alpha'],
                    array_sum($jumlah1)
                ];

                if ($class2) {
                    $rekapPerKelas[] = [
                        $class2['name'],
                        $jumlah2['sakit'],
                        $jumlah2['izin'],
                        $jumlah2['alpha'],
                        array_sum($jumlah2)
                    ];
                }

                // Spasi antar pasangan kelas
                $rows[] = [''];
                $currentRow++;
            }

            // Spasi antar major
            $rows[] = [''];
            $currentRow++;
        }

        // Rekapitulasi Per Kelas
        $rows[] = ['REKAPITULASI KETIDAKHADIRAN SISWA PER KELAS'];
        $this->rowStyles[$currentRow] = ['type' => 'recap_title', 'merge' => 'A:E'];
        $currentRow++;

        $rows[] = ['Kelas', 'Sakit', 'Izin', 'Alpha', 'Total Tidak Hadir'];
        $this->rowStyles[$currentRow] = ['type' => 'recap_header'];
        $currentRow++;

        $total = ['sakit' => 0, 'izin' => 0, 'alpha' => 0];

        foreach ($rekapPerKelas as $rekap) {
            $rows[] = $rekap;
            $this->rowStyles[$currentRow] = ['type' => 'recap_data'];
            $currentRow++;

            $total['sakit'] += $rekap[1];
            $total['izin'] += $rekap[2];
            $total['alpha'] += $rekap[3];
        }

        // Rekap total semua kelas
        $rows[] = ['TOTAL KESELURUHAN', $total['sakit'], $total['izin'], $total['alpha'], array_sum($total)];
        $this->rowStyles[$currentRow] = ['type' => 'grand_total'];
        $currentRow++;

        return $rows;
    }

    public function title(): string
    {
        return 'Laporan Absensi ' . date('d-m-Y', strtotime($this->date));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set column widths untuk layout berdampingan
                $sheet->getColumnDimension('A')->setWidth(25); // Nama Siswa 1
                $sheet->getColumnDimension('B')->setWidth(12); // NIS 1
                $sheet->getColumnDimension('C')->setWidth(18); // Status 1
                $sheet->getColumnDimension('D')->setWidth(3);  // Pemisah
                $sheet->getColumnDimension('E')->setWidth(25); // Nama Siswa 2
                $sheet->getColumnDimension('F')->setWidth(12); // NIS 2
                $sheet->getColumnDimension('G')->setWidth(18); // Status 2
                $sheet->getColumnDimension('H')->setWidth(3);  // Pemisah

                foreach ($this->rowStyles as $row => $styleData) {
                    $type = $styleData['type'];
                    $merge = $styleData['merge'] ?? '';

                    switch ($type) {
                        case 'title':
                            $sheet->mergeCells('A' . $row . ':H' . $row);
                            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '5B9BD5']],
                                'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            ]);
                            $sheet->getRowDimension($row)->setRowHeight(25);
                            break;

                        case 'subtitle':
                            $sheet->mergeCells('A' . $row . ':H' . $row);
                            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '9DC3E6']],
                                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '000000']],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            ]);
                            $sheet->getRowDimension($row)->setRowHeight(20);
                            break;

                        case 'report_title':
                            $sheet->mergeCells('A' . $row . ':H' . $row);
                            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                                'font' => ['bold' => true, 'size' => 14],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                                'borders' => [
                                    'outline' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '5B9BD5']]
                                ]
                            ]);
                            $sheet->getRowDimension($row)->setRowHeight(22);
                            break;

                        case 'major_header':
                            $sheet->mergeCells('A' . $row . ':H' . $row);
                            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '5B9BD5']],
                                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            ]);
                            break;

                        case 'class_header_pair':
                            // Header kelas 1
                            $sheet->mergeCells('A' . $row . ':C' . $row);
                            $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'B4C7E7']],
                                'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            ]);

                            // Header kelas 2
                            $sheet->mergeCells('E' . $row . ':G' . $row);
                            $sheet->getStyle('E' . $row . ':G' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'B4C7E7']],
                                'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            ]);

                            // Kolom pemisah
                            $sheet->getStyle('D' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                            ]);
                            $sheet->getStyle('H' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                            ]);
                            break;

                        case 'table_header_pair':
                            // Header kolom kelas 1
                            $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E2F3']],
                                'font' => ['bold' => true],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            ]);

                            // Header kolom kelas 2
                            $sheet->getStyle('E' . $row . ':G' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E2F3']],
                                'font' => ['bold' => true],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            ]);

                            // Kolom pemisah
                            $sheet->getStyle('D' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                            ]);
                            $sheet->getStyle('H' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                            ]);
                            break;

                        case 'data_row_pair':
                            // Data kelas 1
                            $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                            ]);

                            // Data kelas 2
                            $sheet->getStyle('E' . $row . ':G' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                            ]);

                            // Kolom pemisah
                            $sheet->getStyle('D' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8F9FA']],
                            ]);
                            $sheet->getStyle('H' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8F9FA']],
                            ]);
                            break;

                        case 'subtotal_pair':
                            // Subtotal kelas 1
                            $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E2F3']],
                                'font' => ['bold' => true],
                                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                            ]);

                            // Subtotal kelas 2
                            $sheet->getStyle('E' . $row . ':G' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E2F3']],
                                'font' => ['bold' => true],
                                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                            ]);

                            // Kolom pemisah
                            $sheet->getStyle('D' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                            ]);
                            $sheet->getStyle('H' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                            ]);
                            break;

                        case 'recap_title':
                            $sheet->mergeCells('A' . $row . ':E' . $row);
                            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '5B9BD5']],
                                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            ]);
                            break;

                        case 'recap_header':
                            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'B4C7E7']],
                                'font' => ['bold' => true],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            ]);
                            break;

                        case 'recap_data':
                            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            ]);
                            break;

                        case 'grand_total':
                            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '5B9BD5']],
                                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            ]);
                            break;
                    }
                }

                // Apply border to all filled cells
                $highestRow = $sheet->getHighestDataRow();
                $sheet->getStyle('A1:H' . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '5B9BD5'],
                        ],
                    ],
                ]);

                // Set print settings
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageMargins()->setTop(0.75);
                $sheet->getPageMargins()->setRight(0.25);
                $sheet->getPageMargins()->setLeft(0.25);
                $sheet->getPageMargins()->setBottom(0.75);
            }
        ];
    }
}