<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		cek_login();
		cek_user();
	}

	public function index()
	{
		$data['judul'] = 'Penyakit';
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

		// Get Data Penyakit
		$data['penyakit'] = $this->ModelPenyakit->getPenyakit()->result_array();

		// TODO (Med)
		// - Add Penyakit (Rich Text Editor)
		//   Referensi :
		//     - https://www.petanikode.com/codeigniter-quilljs/
		//     - tinymce 
		//     - Textarea WYSIWYG editor
		// - Edit Penyakit
		// - Delete Penyakit

		$this->load->view('templates/admin/header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('templates/admin/topbar', $data);
		$this->load->view('penyakit/index', $data);
		$this->load->view('templates/admin/footer');
	}

	public function addPenyakit()
	{
		$data['judul'] = 'Tambah Penyakit';
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$data['last_id'] = $this->ModelPenyakit->getLastIdPenyakit();


		$this->load->view('templates/admin/header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('templates/admin/topbar', $data);
		$this->load->view('penyakit/tambah_penyakit', $data);
		$this->load->view('templates/admin/footer');
	}

	public function tambahPenyakit()
	{
		$data = array(
			'id_penyakit' => $this->input->post('id_penyakit'),
			'nama_penyakit' => $this->input->post('nama_penyakit'),
			'info_gejala' => $this->input->post('info_gejala'),
			'info_pencegahan' => $this->input->post('info_pencegahan'),
			'info_pengobatan' => $this->input->post('info_pengobatan'),
			'gambar_penyakit' => $this->input->post('gambar_penyakit')
		);

		$rules = [
			[
				'field' => 'id_penyakit',
				'label' => 'Id Penyakit',
				'rules' => 'required'
			],
			[
				'field' => 'nama_penyakit',
				'label' => 'Nama Penyakit',
				'rules' => 'required'
			],
			[
				'field' => 'info_gejala',
				'label' => 'Info Gejala',
				'rules' => 'required'
			],
			[
				'field' => 'info_pencegahan',
				'label' => 'Info Pencegahan',
				'rules' => 'required'
			],
			[
				'field' => 'info_pengobatan',
				'label' => 'Info Pengobatan',
				'rules' => 'required'
			],
			// [
			// 	'gambar_penyakit',
			// 	'Gambar Penyakit',
			// 	'required', [
			// 		'required' => 'Gambar Penyakit harus diisi',
			// 	]
			// ],
		];
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() != true) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">' . validation_errors() . '</div>');
			redirect('Penyakit/addPenyakit');
		}

		// Panggil model untuk menyimpan data
		$result = $this->ModelPenyakit->simpanPenyakit($data);

		// Periksa hasil simpan
		if ($result) {
			// Simpan berhasil
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Data berhasil disimpan</div>');
			redirect('penyakit'); // Redirect ke halaman penyakit setelah simpan
		} else {
			// Simpan gagal
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Gagal menyimpan data. Mohon coba lagi</div>');
			redirect('Penyakit/addPenyakit');
		}
	}

	public function editPenyakit($id)
	{
		$data['judul'] = 'Edit Penyakit';
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$data['penyakit'] = $this->ModelPenyakit->getPenyakitById($id);

		$this->load->view('templates/admin/header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('templates/admin/topbar', $data);
		$this->load->view('penyakit/ubah_penyakit', $data);
		$this->load->view('templates/admin/footer');
	}

	public function updatePenyakit()
	{
		// Ambil data dari form
		$data = array(
			'id_penyakit' => $this->input->post('id_penyakit'),
			'nama_penyakit' => $this->input->post('nama_penyakit'),
			'info_gejala' => $this->input->post('info_gejala'),
			'info_pencegahan' => $this->input->post('info_pencegahan'),
			'info_pengobatan' => $this->input->post('info_pengobatan'),
			'gambar_penyakit' => $this->input->post('gambar_penyakit')
		);

		$rules = [

			[
				'field' => 'nama_penyakit',
				'label' => 'Nama Penyakit',
				'rules' => 'required'
			],
			[
				'field' => 'info_gejala',
				'label' => 'Info Gejala',
				'rules' => 'required'
			],
			[
				'field' => 'info_pencegahan',
				'label' => 'Info Pencegahan',
				'rules' => 'required'
			],
			[
				'field' => 'info_pengobatan',
				'label' => 'Info Pengobatan',
				'rules' => 'required'
			],
			// [
			// 	'gambar_penyakit',
			// 	'Gambar Penyakit',
			// 	'required', [
			// 		'required' => 'Gambar Penyakit harus diisi',
			// 	]
			// ],
		];
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() != true) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">' . validation_errors() . '</div>');
			redirect('Penyakit/editPenyakit/' . $data['id_penyakit']);
		}

		// Ambil ID penyakit dari form
		$id_penyakit = $this->input->post('id_penyakit');

		// Panggil model untuk melakukan update data
		$result = $this->ModelPenyakit->updatePenyakit($id_penyakit, $data);

		if ($result) {
			// Update berhasil
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Data berhasil disimpan</div>');
			redirect('penyakit'); // Redirect ke halaman penyakit setelah update
		} else {
			// Update gagal
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Gagal menyimpan data. Mohon coba lagi</div>');
			redirect('Penyakit/editPenyakit/' . $data['id_penyakit']);
		}
	}
}
