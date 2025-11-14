<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Survey_model', 'Questions_model']);
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$data['title'] = "EIP Survey | selamat datang.";
		$surveys = $this->Survey_model->get_by_posisi();
		$data['slug'] = $surveys->slug;
		$this->load->view('landing/header', $data);
		$this->load->view('landing/content', $data);
		$this->load->view('landing/footer');
	}

	public function form($slug)
	{
		$survey = $this->Survey_model->get_by_slug($slug);
		if (!$survey) show_404();
		$data['questions'] = $this->Questions_model->get_by_survey($survey->id);
		$data['survey'] = $survey;
		$data['surveys'] = $this->Survey_model->get_all();
		$data['title'] = $survey->title;
		$this->load->view('utama/header', $data);
		$this->load->view('utama/nav_utama', $data);
		$this->load->view('utama/utama', $data);
		$this->load->view('utama/footer');
	}

	public function submit()
	{
		$survey_id = $this->input->post('survey_id');
		$post = $this->input->post();

		// kumpulkan jawaban
		$answers = [];
		foreach ($post as $key => $val) {
			if (strpos($key, 'q_') === 0) {
				$qid = str_replace('q_', '', $key);
				$answers[$qid] = $val;
			}
		}

		// simpan hasil ke database
		$this->Survey_model->save_response($survey_id, $answers);
		redirect('welcome/next_halaman/' . $survey_id);
	}

	public function next_halaman($survey_id)
	{
		// $next = $this->Survey_model->get_next_survey($survey_id);
		// $data['surveys'] = $this->Survey_model->get_all();
		// $data['next'] = $next;
		// $survey = $this->Survey_model->get_by_id($survey_id);
		// $data['title'] = $survey->title;
		// $this->load->view('utama/header');
		// $this->load->view('utama/nav_utama', $data);
		// $this->load->view('utama/thanks', $data);
		// $this->load->view('utama/footer');
		$next = $this->Survey_model->get_next_survey($survey_id);
		if ($next) {
			redirect('welcome/form/' . $next->slug);
		} else {
			$this->load->view('utama/header', ['title' => 'EIP Survey | Terima Kasih']);
			$this->load->view('utama/nav_utama');
			$this->load->view('utama/thanks');
			$this->load->view('utama/footer');
		}
	}

	public function daftar()
	{
		$data['title'] = "EIP Survey | Buat Akun.";
		$this->load->view('utama/header', $data);
		$this->load->view('utama/nav_utama');
		$this->load->view('utama/daftar');
		$this->load->view('utama/footer');
	}
}