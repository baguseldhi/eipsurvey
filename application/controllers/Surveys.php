<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Surveys extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Survey_model', 'M_user']);
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("welcome"));
        }
    }

    public function index()
    {
        $data['title'] = 'IEP Survey | Surveys';
        $data['user'] = $this->M_user->getUserById();
        $this->load->view('umum/u_header', $data);
        $this->load->view('umum/surveys', $data);
        $this->load->view('umum/u_footer');
    }

    public function list()
    {
        echo json_encode($this->Survey_model->get_all());
    }

    public function get($id)
    {
        echo json_encode($this->Survey_model->get_by_id($id));
    }

    public function save()
    {
        $data = [
            'title' => $this->input->post('title'),
            'posisi' => $this->input->post('posisi'),
            'slug' => url_title($this->input->post('title'), '-', TRUE)
        ];

        $id = $this->input->post('id');
        if ($id) {
            $this->Survey_model->update($id, $data);
            echo json_encode(['status' => 'updated']);
        } else {
            $newid = $this->Survey_model->insert($data);
            echo json_encode(['status' => 'inserted', 'id' => $newid]);
        }
    }

    public function delete($id)
    {
        $this->Survey_model->delete($id);
        echo json_encode(['status' => 'deleted']);
    }


    public function export($survey_id)
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
        $survey = $this->Survey_model->get_by_id($survey_id);

        $sheet->setCellValue('A1', "LAPORAN DATA RESPONDEN SURVEY ECO INDUSTRY PARK"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A2', strtoupper($survey->title));
        $sheet->mergeCells('A2:G2'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->mergeCells('A3:G3'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->applyFromArray($styleJudul); // Set bold kolom A1
        $sheet->getStyle('A2')->applyFromArray($styleJudul); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        // Ambil label pertanyaan dari table question untuk survey ini
        $questions = $this->db
            ->select('*')
            ->where('survey_id', $survey_id)
            ->order_by('id', 'ASC')
            ->get('questions')
            ->result();

        // Jika tidak ada pertanyaan, fallback ke header default
        $colIndex = 1;
        foreach ($questions as $q) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($col . '6', $q->label);
            $sheet->getStyle($col . '6')->applyFromArray($style_col);
            $colIndex++;
        }

        $no = 1;
        $numrow = 7;

        // Get all answers for this survey
        $question_ids = array_map(function ($q) {
            return $q->id;
        }, $questions);
        // var_dump($question_ids);
        // die();
        $answers = $this->db
            ->select('response_id, question_id, value')
            ->where_in('question_id', $question_ids)
            ->get('answers')
            ->result_array();
        // Group answers by respondent
        $grouped_answers = [];
        foreach ($answers as $answer) {
            $grouped_answers[$answer['response_id']][$answer['question_id']] = $answer['value'];
        }

        // Get unique respondents
        $respondents = $this->db
            ->select('response_id')
            ->distinct()
            ->where_in('question_id', $question_ids)
            ->get('answers')
            ->result_array();

        foreach ($respondents as $respondent) {
            $resp_id = $respondent['response_id'];
            $sheet->setCellValue('A' . $numrow, $no);

            // Fill in answer values based on question_id
            $colIndex = 2;
            foreach ($questions as $q) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $value = isset($grouped_answers[$resp_id][$q->id]) ? $grouped_answers[$resp_id][$q->id] : '';
                $sheet->setCellValue($col . $numrow, $value);
                $sheet->getStyle($col . $numrow)->applyFromArray($style_row);
                $colIndex++;
            }

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $no++;
            $numrow++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("laporan_survey");
        $filename = "laporan_" . $survey->title . '-' . date('dmYHis') . '.xlsx';
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
}