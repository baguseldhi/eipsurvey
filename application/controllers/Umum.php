<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Umum extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_user' => 'user', 'M_loket' => 'loket']);
        // if ($this->session->userdata('status') != "login") {
        //     redirect(base_url("welcome"));
        // }

        // if ($this->session->userdata('role') == '300') {
        //     redirect('loket');
        // } elseif ($this->session->userdata('role') == '400') {
        //     redirect('user');
        // }
    }

    public function index()
    {
        $user['title'] = "umum | EIP Survey";
        $user['user'] = $this->user->getUserById();
        $user['ply'] = $this->user->getply();
        $user['loketuser'] = $this->user->loketuser()->result_array();
        $user['tot_pemohon'] = $this->user->tot_pemohon()->num_rows();
        $user['antri_hari'] = $this->user->antri_hari()->num_rows();
        $user['blm_proses'] = $this->user->blm_proses()->num_rows();
        $this->load->view('umum/u_header', $user);
        $this->load->view('umum/umum', $user);
        $this->load->view('umum/u_footer', $user);
    }

    public function getLimit()
    {
        $limit = $this->db->get('t_batas')->row_array();
        echo $limit['nilai'];
    }
    public function limitAll()
    {
        $limit = $this->db->get('t_batas')->row_array();
        echo json_encode($limit);
    }

    public function setLimitAll()
    {
        $nilai = $this->input->post('nilai');
        $ket = $this->input->post('ket');
        $id = $this->input->post('id');
        $user_id = $this->input->post('user_id');
        $data = ['nilai' => $nilai, 'user_id' => $user_id, 'keterangan' => $ket, 'tgl_batas' => date('Y-m-d H:i:s')];
        $this->db->where('id_batas', $id);
        $update = $this->db->update('t_batas', $data);
        if ($update) {
            echo json_encode(['stat' => true, 'msg' => 'Batas Antrian Telah diubah.']);
        } else {
            echo json_encode(['stat' => false, 'msg' => 'Batas Antrian gagal diubah.']);
        }
    }

    public function profil()
    {
        $user['title'] = "profil | EIP Survey";
        $user['user'] = $this->user->getUserById();
        $this->load->view('umum/u_header', $user);
        $this->load->view('umum/profil', $user);
        $this->load->view('umum/u_footer');
    }

    public function aksiprofil()
    {
        $id = $this->input->post('id');
        $username = $this->input->post('username');
        $pass = $this->input->post('pass');
        $this->loket->updateAkun($id, $username, $pass);
        $akun = $this->db->get_where('t_user', array('id_user' => $id))->row_array();
        echo json_encode(['stat' => true, 'username' => $akun['username'], 'pass' => $akun['password'], 'msg' => 'akun berhasil di ubah🤗']);
    }

    public function question($id)
    {
        $data['title'] = 'IEP Survey | Question';
        $data['user'] = $this->user->getUserById();
        // $data['layanan'] = $this->user->getLayanan();
        $this->load->view('umum/u_header', $data);
        $this->load->view('umum/layanan', $data);
        $this->load->view('umum/u_footer');
    }
    public function pelayanan()
    {
        $data['title'] = 'EIP Survey | Layanan';
        $data['layanan'] = $this->user->getLayanan();
        $this->load->view('utama/header', $data);
        $this->load->view('utama/nav_utama');
        $this->load->view('umum/layanan', $data);
    }
    public function users()
    {
        $data['title'] = 'EIP Survey | Pengguna';
        $data['user'] = $this->user->getUserById();
        $data['loket'] = $this->user->getLoket();
        $this->load->view('umum/u_header', $data);
        $this->load->view('umum/users', $data);
        $this->load->view('umum/f_admin', $data);
    }

    public function berkas()
    {
        $data['title'] = 'EIP Survey | booking';
        $data['user'] = $this->user->getUserById();
        $data['loket'] = $this->user->getLoket();
        $this->load->view('umum/u_header', $data);
        $this->load->view('umum/berkas', $data);
        $this->load->view('umum/f_admin', $data);
    }

    public function get_data_booking()
    {
        $list = $this->user->get_data_booking();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            if ($field->stat_booking == '0') {
                $role = "belum proses";
            } elseif ($field->stat_booking == 'v') {
                $role = "proses";
            } elseif ($field->stat_booking == '*') {
                $role = "selesai";
            } elseif ($field->stat_booking == 'x') {
                $role = "tidak hadir";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nama_user;
            $row[] = date('d-m-Y', strtotime($field->tgl_booking));
            $row[] = $field->no_tiket;
            $row[] = $field->nama_pelayanan;
            $row[] = $field->nama_loket;
            $row[] = $role;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->count_all1(),
            "recordsFiltered" => $this->user->count_filtered1(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
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
            $row[] = "<a class='btn btn-success mx-1' id='editUser' onclick='editUser($field->id_user)'>Edit</a><a class='btn btn-danger mx-1' id='hapusUser' onclick='hapusUser($field->id_user)'>Hapus</a>";

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

    public function getUserId()
    {
        $id = $this->input->post('id');
        $userId = $this->user->getUserId($id);
        echo json_encode($userId);
    }
    public function hapusUser()
    {
        $id = $this->input->post('id');
        $cek = $this->db->get_where('t_user', array('id_user' => $id))->row_array();
        if ($cek['role'] == '300') {
            echo json_encode(['stat' => false, 'msg' => 'cobalah untuk mengubah data pengguna loket']);
        } else {
            $this->db->where('id_user', $id);
            $this->db->update('t_user', ['stat_user' => '0']);
            echo json_encode(['stat' => true, 'msg' => 'Data user telah dihapus.😁']);
        }
    }

    public function createUser()
    {
        $this->form_validation->set_rules('ktp', 'No.KTP', 'required|numeric|max_length[17]|min_length[15]|is_unique[t_user_detail.nik]');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[t_user.username]');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['stat' => false, 'msg' => validation_errors()]);
        } else {
            $cekLoket = $this->user->cekUserLoket($this->input->post('loket'))->num_rows();
            if ($cekLoket > 0) {
                echo json_encode(['stat' => false, 'msg' => "Loket " . $this->input->post('loket') . " sudah diisi cobalah untuk lakukan edit pengguna loket"]);
            } else {
                $data = [
                    'username' => $this->input->post('username'),
                    'nama_user' => $this->input->post('nama'),
                    'password' => md5($this->input->post('pass')),
                    'role' => $this->input->post('role'),
                    'stat_user' => '1',
                    'tgl_aktive' => date("Y-m-d H:i:s"),
                    'loket_nama' => $this->input->post('loket')
                ];
                $ins1 = $this->db->insert('t_user', $data);
                $user_id = $this->db->insert_id();
                //insert t_user_detail
                $data1 = [
                    'user_id' => intval($user_id),
                    'nik' => intval($this->input->post('ktp')),
                    'keterangan' => $this->input->post('pass'),
                    'telp' => intval($this->input->post('telp')),
                    'jns_kelamin' => $this->input->post('jk'),
                    'alamat' => $this->input->post('alamat')
                ];
                $ins2 = $this->db->insert('t_user_detail', $data1);
                if ($ins1 && $ins2) {
                    echo json_encode(['stat' => true, 'msg' => 'Data User berhasil ditambahkan.👌']);
                } else {
                    echo json_encode(['stat' => false, 'msg' => 'gagal menambah user.😒']);
                }
            }
        }
    }
    public function editUsers()
    {
        $this->form_validation->set_rules('ktp', 'No.KTP', 'required|numeric|max_length[17]|min_length[15]');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['stat' => false, 'msg' => validation_errors()]);
        } else {
            $id = $this->input->post('id');
            $pass = $this->input->post('pass');
            $loket = ($this->input->post('loket') == "") ? NULL : $this->input->post('loket');
            //insert t_user
            if ($pass == "") {
                $data = [
                    'username' => $this->input->post('username'),
                    'nama_user' => $this->input->post('nama'),
                    'role' => $this->input->post('role'),
                    'stat_user' => $this->input->post('aktive'),
                    'loket_nama' => $loket
                ];
            } else {
                $data = [
                    'username' => $this->input->post('username'),
                    'nama_user' => $this->input->post('nama'),
                    'role' => $this->input->post('role'),
                    'stat_user' => $this->input->post('aktive'),
                    'loket_nama' => $this->input->post('loket'),
                    'password' => md5($pass)
                ];
            }
            $this->user->updateUser($id, $data);
            //insert t_user_detail
            if ($pass == "") {
                $data1 = [
                    'nik' => intval($this->input->post('ktp')),
                    'telp' => intval($this->input->post('telp')),
                    'jns_kelamin' => $this->input->post('jk'),
                    'alamat' => $this->input->post('alamat')
                ];
            } else {
                $data1 = [
                    'nik' => intval($this->input->post('ktp')),
                    'telp' => intval($this->input->post('telp')),
                    'jns_kelamin' => $this->input->post('jk'),
                    'alamat' => $this->input->post('alamat'),
                    'keterangan' => $pass
                ];
            }
            $this->user->updateDetail($id, $data1);
            echo json_encode(['stat' => true, 'msg' => 'Data User berhasil diUbah.👌']);
        }
    }

    function get_data_question()
    {
        $list = $this->loket->get_table_layanan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $tombol = "<a class='btn btn-success mx-1' id='editUser' onclick='editPelayanan($field->id_pelayanan)'>Edit</a><a class='btn btn-danger mx-1' id='hapusPelayanan' onclick='hapusPelayanan($field->id_pelayanan)'>Hapus</a>";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->title;
            $row[] = $field->label;
            $row[] = $tombol;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->loket->count_all1(),
            "recordsFiltered" => $this->loket->count_filtered1(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    function get_data_limit()
    {
        $list = $this->loket->get_table_limit();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $tombol = "<a class='btn btn-success mx-1' id='editUser' onclick='setLimit($field->id_batas)'>Set Limit</a>";
            $no++;
            $row = array();
            $row[] = $field->nilai;
            $row[] = date('d-m-Y H:i:s', strtotime($field->tgl_batas));
            $row[] = $field->nama_user;
            $row[] = $field->keterangan;
            $row[] = $tombol;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->loket->count_all2(),
            "recordsFiltered" => $this->loket->count_filtered2(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function tambahPelayanan()
    {
        $pel = $this->input->post('nama_pelayanan');
        $loket = intval($this->input->post('nama_loket'));
        //insert pelayanan
        $nama_pelayanan = ['nama_pelayanan' => $pel];
        $ins1 = $this->db->insert('t_pelayanan', $nama_pelayanan);
        $pelayanan_id = $this->db->insert_id();
        //insert loket
        $nama_loket = ['pelayanan_id' => $pelayanan_id, 'nama_loket' => $loket];
        $ins2 = $this->db->insert('t_loket', $nama_loket);
        if ($ins1 && $ins2) {
            echo json_encode(['stat' => true, 'msg' => 'Pelayanan dan Loker ditambahkan.🤗']);
        } else {
            echo json_encode(['stat' => false, 'msg' => 'Pelayanan dan Loker gagal ditambahkan.😒']);
        }
    }
    public function editPelayanan()
    {
        $pel = $this->input->post('nama_pelayanan');
        $id_pel = $this->input->post('id_pel');
        $loket = intval($this->input->post('nama_loket'));
        //insert pelayanan
        $nama_pelayanan = ['nama_pelayanan' => $pel];
        $this->db->where('id_pelayanan', $id_pel);
        $ins1 = $this->db->update('t_pelayanan', $nama_pelayanan);
        //insert loket
        $nama_loket = ['nama_loket' => $loket];
        $this->db->where('pelayanan_id', $id_pel);
        $ins2 = $this->db->update('t_loket', $nama_loket);
        if ($ins1 && $ins2) {
            echo json_encode(['stat' => true, 'msg' => 'Pelayanan dan Loker diubah.🤗']);
        } else {
            echo json_encode(['stat' => false, 'msg' => 'Pelayanan dan Loker gagal diubah.😒']);
        }
    }

    public function hapusPelayanan()
    {
        $id = $this->input->post('id');
        //hapus pelayanan
        $this->db->where('id_pelayanan', $id);
        $del1 = $this->db->delete('t_pelayanan');
        //hapus loket
        $this->db->where('pelayanan_id', $id);
        $del2 = $this->db->delete('t_loket');
        if ($del1 && $del2) {
            echo json_encode(['stat' => true, 'msg' => 'pelayanan dan loket berhasil dihapus.']);
        } else {
            echo json_encode(['stat' => false, 'msg' => 'pelayanan dan loket gagal dihapus.']);
        }
    }

    public function getPelId()
    {
        $id = $this->input->post('id');
        $cek_pel = $this->loket->getPelId($id)->row_array();
        echo json_encode($cek_pel);
    }
}

/* End of file Controllername.php */