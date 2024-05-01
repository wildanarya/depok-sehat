<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pasien extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		cek_login();
		cek_user();
	}

	public function index()
	{
		$data['judul'] = 'Pasien';
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

		// Ubah role dari angka 2 menjadi 'admin'
		if ($data['user']['role_id'] == 2) {
			$data['user']['role_id'] = 'Admin';
		} else {
			$data ['user']['role_id'] = 'Petugas';
		}

		// Get Data Pasien
		$data['pasien'] = $this->ModelPasien->getPasienLimit();

		$this->load->view('templates/admin/header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('templates/admin/topbar', $data);
		$this->load->view('pasien/index', $data);
		$this->load->view('templates/admin/footer');
	}

	public function tambahPasien() {
		$data['judul'] = 'Tambah Pasien';
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$data['list_kecamatan'] = $this->ModelPasien->getAllKecamatan();

		$this->load->view('templates/admin/header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('templates/admin/topbar', $data);
		$this->load->view('pasien/tambah_pasien', $data);
		$this->load->view('templates/admin/footer');
	}

	public function createPasien() {
		$data = array(
			'id_pasien' => $this->input->post('nik'),
			'nama' => $this->input->post('nama'),
			'tanggal_lahir' => $this->input->post('tanggal_lahir'),
			'info_kontak' => $this->input->post('info_kontak'),
			'id_kecamatan' => $this->input->post('id_kecamatan'),
			'alamat' => $this->input->post('alamat')
		);

		// Panggil model untuk menyimpan data
    $result = $this->ModelPasien->simpanPasien($data);

    // Periksa hasil simpan
    if ($result) {
			// Simpan berhasil
			echo "<script>alert('Data pasien berhasil disimpan');</script>";
			redirect('pasien'); // Redirect ke halaman pasien setelah simpan
	} else {
			// Simpan gagal
			echo "<script>alert('Gagal menyimpan data pasien. Mohon coba lagi');</script>";
	}
	}

	public function editpasien($id) {
		$data['judul'] = 'Edit Pasien';
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$data['pasien'] = $this->ModelPasien->getPasienById($id);
		$data['list_kecamatan'] = $this->ModelPasien->getAllKecamatan();


		$this->load->view('templates/admin/header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('templates/admin/topbar', $data);
		$this->load->view('pasien/edit_pasien', $data);
		$this->load->view('templates/admin/footer');
	}

	public function updatePasien() {
    // Ambil data dari form
    $data = array(
        'nama' => $this->input->post('nama'),
        'tanggal_lahir' => $this->input->post('tanggal_lahir'),
        'info_kontak' => $this->input->post('info_kontak'),
        'id_kecamatan' => $this->input->post('id_kecamatan'),
        'alamat' => $this->input->post('alamat')
    );

		
    // Ambil ID pasien dari form
    $id_pasien = $this->input->post('nik');
		
    // Panggil model untuk melakukan update data
    $result = $this->ModelPasien->updatePasien($id_pasien, $data);
		
    if ($result) {
        // Update berhasil
				echo "<script>alert('Data pasien berhasil di edit');</script>";
        redirect('pasien'); // Redirect ke halaman pasien setelah update
    } else {
        // Update gagal
        echo "<script>alert('Gagal menyimpan data pasien. Mohon coba lagi');</script>";
    }
}

public function searchPasien() {
        
	// Ahmad Search
	// Mengambil kata kunci pencarian dari form
	cek_login(1);
	$data['judul'] = 'Data Pasien';

	$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
	$data['pasien'] = $this->ModelPasien->getPasienLimit();
	$keyword = $this->input->post('keyword');

	// Melakukan pencarian dengan memanggil fungsi searchPasien
	$data['search_pasien'] = $this->ModelPasien->searchPasien($keyword)->result_array();

	// Memeriksa apakah hasil pencarian kosong
	if (empty($data['search_pasien'])) {
	// Jika kosong, atur pesan yang akan ditampilkan
		$data['search_message'] = 'Data tidak ditemukan.';
		$this->session->set_flashdata('datanotfound', '<div class="alert alert-danger alert-message" role="alert">Data tidak ditemukan</div>');
                    redirect('pasien/index');
	}

	// Bila route diakses dengan TIDAK membawa parameter        
		$this->load->view('templates/admin/header', $data);
		$this->load->view('templates/admin/sidebar', $data);
		$this->load->view('templates/admin/topbar', $data);

		// Tampilkan view sesuai dengan kondisi
		if (empty($data['search_message'])) {
			$this->load->view('pasien/index', $data);
		} else {
            redirect('pasien');
		}

		$this->load->view('templates/admin/footer', $data);

}


}