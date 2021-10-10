<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('login');
		}
		date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index()
	{
		$toko = $this->db->get('toko')->row();
		$data['toko'] = $toko;
		$this->load->view('admin/pengaturan', $data);
	}

	public function set_toko()
	{
		$data = array(
			'nama' => $this->input->post('nama'),
			'minPoint' => $this->input->post('point'),
            'jumUang' => $this->input->post('uang'),
			'uang' => $this->input->post('dapatuang'),
			'point' => $this->input->post('dapatpoint'),
			'alamat' => $this->input->post('alamat')
		);

		$this->db->where('id', 1);
		if ($this->db->update('toko', $data)) {
			$this->db->select('nama, alamat');
			$toko = $this->db->get('toko')->row();
			$this->session->set_userdata('toko', $toko);
			echo json_encode('sukses');
		}
	}
}
