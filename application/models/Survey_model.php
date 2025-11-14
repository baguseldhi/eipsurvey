<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Survey_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all()
    {
        return $this->db->order_by('posisi', 'asc')->get('surveys')->result();
    }

    public function get_by_posisi()
    {
        return $this->db->where('posisi', '1')->get('surveys')->row();
    }

    public function get_by_slug($slug)
    {
        return $this->db->get_where('surveys', ['slug' => $slug])->row();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('surveys', ['id' => $id])->row();
    }

    public function insert($data)
    {
        $this->db->insert('surveys', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id)->update('surveys', $data);
    }

    public function save_response($survey_id, $answers)
    {
        $this->db->insert('responses', ['survey_id' => $survey_id]);
        $response_id = $this->db->insert_id();

        foreach ($answers as $qid => $ans) {
            if (is_array($ans)) $ans = implode(', ', $ans);
            $this->db->insert('answers', [
                'response_id' => $response_id,
                'question_id' => $qid,
                'value' => $ans
            ]);
        }
    }

    public function get_next_survey($current_id)
    {
        $current = $this->db->get_where('surveys', ['id' => $current_id])->row();
        if (!$current) return null;

        $next = $this->db
            ->order_by('posisi', 'asc')
            ->where('posisi >', $current->posisi)
            ->get('surveys')
            ->row();

        return $next;
    }

    public function delete($id)
    {
        $this->db->delete('surveys', ['id' => $id]);
    }
}