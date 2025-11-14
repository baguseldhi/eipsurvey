<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user', 'user');
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("welcome"));
        }

        if ($this->session->userdata('role') == '300') {
            redirect('loket');
        } elseif ($this->session->userdata('role') == '400') {
            redirect('user');
        }
    }


    public function index()
    {
        // $user['title'] = "umum | EIP Survey";
        // $user['user'] = $this->user->getUserById();
        // $this->load->view('admin/a_header', $user);
        // $this->load->view('admin/admin', $user);
        // $this->load->view('admin/a_footer');
    }

    function get_data_user()
    {
        $list = $this->user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            if ($field->role == '400') {
                $role = "Umum";
            } elseif ($field->role == '100') {
                $role = "Admin";
            } else {
                $role = "loket";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nik;
            $row[] = $field->nama_user;
            $row[] = $role;
            $row[] = "<a class='btn btn-success mx-1' id='editUser' data-bs-toggle='modal' data-bs-target='#dataUser' data-user='$field->id_user'>Edit</a><a class='btn btn-danger mx-1' href='" . base_url() . "umum/hapususer/$field->id_user'>Edit</a>";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->count_all(),
            "recordsFiltered" => $this->user->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function export()
    {

        require 'vendor/autoload.php';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $styleJudul = [
            'font' => [
                'bold' => true,
                'size' => 11
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]

        ];
        $per_awal = $_GET['a'];
        $per_akhir = $_GET['b'];
        $a = date('Y-m-d', strtotime($per_awal));
        $b = date('Y-m-d', strtotime($per_akhir));
        $sheet->setCellValue('A1', "LAPORAN ANTRIAN PERMOHONAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->setCellValue('A2', "BADAN PERTANAHAN NASIONAL");
        $sheet->setCellValue('A3', "KABUPATEN KARAWANG");
        $sheet->mergeCells('A2:G2'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->mergeCells('A3:G3'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->applyFromArray($styleJudul); // Set bold kolom A1
        $sheet->getStyle('A2')->applyFromArray($styleJudul); // Set bold kolom A1
        $sheet->getStyle('A3')->applyFromArray($styleJudul); // Set bold kolom A1
        $sheet->setCellValue('A5', "periode : $per_awal s/d $per_akhir");
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A6', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B6', "TGL ANTRIAN"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('C6', "NAMA PEMOHON"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('D6', "NO ANTRIAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('E6', "PELAYANAN"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('F6', "LOKET"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('G6', "STATUS"); // Set kolom E3 dengan tulisan "ALAMAT"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A6')->applyFromArray($style_col);
        $sheet->getStyle('B6')->applyFromArray($style_col);
        $sheet->getStyle('C6')->applyFromArray($style_col);
        $sheet->getStyle('D6')->applyFromArray($style_col);
        $sheet->getStyle('E6')->applyFromArray($style_col);
        $sheet->getStyle('F6')->applyFromArray($style_col);
        $sheet->getStyle('G6')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $booking = $this->user->getBooking($a, $b);
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($booking as $data) { // Lakukan looping pada variabel siswa
            if ($data['stat_booking'] == '0') {
                $status = 'Belum Proses';
            } elseif ($data['stat_booking'] == 'v') {
                $status = 'Proses';
            } elseif ($data['stat_booking'] == '*') {
                $status = 'selesai';
            } elseif ($data['stat_booking'] == 'x') {
                $status = 'Tidak Hadir';
            }
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, date('d-m-Y', strtotime($data['tgl_booking'])));
            $sheet->setCellValue('C' . $numrow, $data['nama_user']);
            $sheet->setCellValue('D' . $numrow, $data['no_tiket']);
            $sheet->setCellValue('E' . $numrow, $data['nama_pelayanan']);
            $sheet->setCellValue('F' . $numrow, 'LOKET ' . $data['nama_loket']);
            $sheet->setCellValue('G' . $numrow, $status);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(30); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(15); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("laporan_antrian");
        $filename = 'laporan_antrian' . date('dmYHis') . '.xlsx';
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");;
        header("Content-Disposition: attachment;filename=" . $filename);
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function ppdf()
    {
        $per_awal = $_GET['a'];
        $per_akhir = $_GET['b'];
        $a = date('Y-m-d', strtotime($per_awal));
        $b = date('Y-m-d', strtotime($per_akhir));
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');

        // title dari pdf
        //$this->data['title_pdf'] = 'Laporan Penjualan Toko Kita';
        //$tgl = date('2022-09-06');
        $this->data['antrian'] = $this->user->getBooking($a, $b);
        $this->data['tgl_a'] = $per_awal;
        $this->data['tgl_b'] = $per_akhir;
        // var_dump($this->data['tiket']);
        // die();
        // filename dari pdf ketika didownload
        $file_pdf = 'Laporan_antrian' . date('dmYHis');
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = $this->load->view('umum/ppdf', $this->data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }
}

/* End of file Controllername.php */