<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Questions extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Questions_model', 'M_user' => 'user', 'Survey_model' => 'survey']);
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("welcome"));
        }
    }

    public function index()
    {
        $survey_id = $this->input->get('param');
        $survey = $this->survey->get_by_id($survey_id);
        $data['survey_id'] = $survey_id;
        $data['title'] = 'IEP Survey | ' . $survey->title;
        $data['title_table'] =  $survey->title;
        $data['user'] = $this->user->getUserById();
        // $data['layanan'] = $this->user->getLayanan();
        $this->load->view('umum/u_header', $data);
        $this->load->view('umum/layanan', $data);
        $this->load->view('umum/u_footer');
    }

    function get_data_question()
    {
        $list = $this->Questions_model->get_table_layanan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $tombol = "<a class='btn btn-success mx-1' id='btnEditquestion' data-id='" . $field->id . "'>Edit</a><a class='btn btn-danger mx-1' id='btnDelquestion' data-id='" . $field->id . "'>Hapus</a>";
            $no++;
            $row = array();
            $row[] = $field->position;
            $row[] = $field->label;
            $row[] = $field->type;
            $row[] = $tombol;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Questions_model->count_all1(),
            "recordsFiltered" => $this->Questions_model->count_filtered1(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function reorder()
    {
        $positions = $this->input->post('positions'); // [id => newPosition]
        if (!empty($positions)) {
            foreach ($positions as $id => $pos) {
                $this->Question_model->update($id, ['position' => $pos]);
            }
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }


    public function list($survey_id)
    {
        echo json_encode($this->Questions_model->get_all($survey_id));
    }

    public function save()
    {
        try {
            # code...
            $data = [
                'survey_id' => $this->input->post('survey_id'),
                'type' => $this->input->post('type'),
                'label' => $this->input->post('label'),
                'meta' => $this->input->post('meta'),
                'position' => $this->input->post('position')
            ];
            $id = $this->input->post('id');
            if ($id) {
                $this->Questions_model->update($id, $data);
                echo json_encode(['status' => 'updated']);
            } else {
                $newid = $this->Questions_model->insert($data);
                echo json_encode(['status' => 'inserted', 'id' => $newid]);
            }
        } catch (\Throwable $e) {
            # code...
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            # code...
            $this->Questions_model->delete($id);
            echo json_encode(['status' => 'deleted']);
        } catch (\Throwable $e) {
            # code...
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function get($id)
    {
        echo json_encode($this->Questions_model->get_by_id($id));
    }
}