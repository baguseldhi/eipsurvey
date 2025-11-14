<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Questions_model extends CI_Model
{
    var $column_order1 = array(null, 'nama_pelayanan', 'nama_loket'); //field yang ada di table user
    var $column_search1 = array('nama_user'); //field yang diizin untuk pencarian 
    var $order1 = array('questions.position' => 'asc'); // default order 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_table_layanan($survey_id)
    {
        $this->_get_layanan_query($survey_id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_all1($survey_id)
    {
        $this->db->from('questions');
        $this->db->where('questions.survey_id', $survey_id);
        return $this->db->count_all_results();
    }

    function count_filtered1($survey_id)
    {
        $this->_get_layanan_query($survey_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _get_layanan_query($survey_id)
    {
        $this->db->select('*');
        $this->db->from('questions');
        $this->db->where('questions.survey_id', $survey_id);
        $i = 0;

        foreach ($this->column_search1 as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search1) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order1)) {
            $order = $this->order1;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_all($survey_id)
    {
        return $this->db->order_by('position', 'asc')->get_where('questions', ['survey_id' => $survey_id])->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('questions', ['id' => $id])->row();
    }

    public function insert($data)
    {
        $this->db->insert('questions', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id)->update('questions', $data);
    }

    public function delete($id)
    {
        $this->db->delete('questions', ['id' => $id]);
    }

    public function get_by_survey($survey_id)
    {
        return $this->db->order_by('position', 'asc')->get_where('questions', ['survey_id' => $survey_id])->result();
    }
}