<?php
defined('BASEPATH') or exit('No direct script access allowed');

class login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_login', 'login');
    }


    public function index()
    {
        $data['title'] = "EIP Survey";
        $this->load->view('login', $data);
    }

    public function aksiLogin()
    {
        $username = htmlspecialchars($this->input->post('username'));
        $pass = htmlspecialchars($this->input->post('password'));
        $cek = $this->login->getUserByUsername($username);
        if (!is_null($cek)) {
            if (md5($pass) == $cek['password']) {
                $data = array(
                    'nama' => $cek['name'],
                    'status' => "login",
                    'id' => $cek['id']
                );
                $this->session->set_userdata($data);
                redirect('surveys');
            } else {
                $this->session->set_flashdata('gagalLogin', 'Username dan Password tidak sesuai.😒');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('gagalLogin', 'Username tidak ditemukan.😒');
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('loket_id');
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('status');
        redirect('welcome', 'refresh');
    }
}

/* End of file Controllername.php */