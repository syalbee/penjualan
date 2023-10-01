<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login') {
			redirect('/');
		}
		$this->load->model('pelanggan_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		// $this->load->view('template/header');
		// $this->load->view('template/sidebar');
		$this->load->view('admin/pelanggan');
	}

	public function indexPoint()
	{
		$this->load->view('admin/pelanggan_point');
	}

	public function read()
	{
		header('Content-type: application/json');
		if ($this->pelanggan_model->read()->num_rows() > 0) {
			foreach ($this->pelanggan_model->read()->result() as $pelanggan) {
				if ($pelanggan->id != 0) {
					$data[] = array(
						'id' => $pelanggan->id,
						'memberid' => $pelanggan->memberid,
						'nama' => $pelanggan->nama,
						'point' => $pelanggan->point,
						'alamat' => $pelanggan->alamat,
						'telepon' => $pelanggan->telepon,
						'nik' => $pelanggan->nik,
						'action' => '<button class="btn btn-sm btn-warning" onclick="edit(' . $pelanggan->id . ')"><i class="fas fa-user-edit"></i></button> <button class="btn btn-sm btn-danger" onclick="remove(' . $pelanggan->id . ')"><i class="fas fa-user-times"></i></button>'
					);
				}
			}
		} else {
			$data = array();
		}
		$pelanggan = array(
			'data' => $data
		);
		echo json_encode($pelanggan);
	}

	public function add()
	{
		$memberId = $this->_generateId();
		$data = array(
			'memberid' => $memberId,
			'nama' => $this->input->post('nama'),
			'point' => 0,
			'alamat' => $this->input->post('alamat'),
			'nik' => $this->input->post('nik'),
			'telepon' => $this->input->post('telepon'),
		);

		if ($this->pelanggan_model->create($data) && $this->pelanggan_model->idTambah($memberId)) {
			echo json_encode('sukses');
		}
	}

	public function delete()
	{
		$id = $this->input->post('id');
		if ($this->pelanggan_model->delete($id)) {
			echo json_encode('sukses');
		}
	}

	public function edit()
	{
		$id = $this->input->post('id');
		$data = array(
			'nama' => $this->input->post('nama'),
			'alamat' => $this->input->post('alamat'),
			'telepon' => $this->input->post('telepon'),
		);
		if ($this->pelanggan_model->update($id, $data)) {
			echo json_encode('sukses');
		}
	}

	public function get_pelanggan()
	{
		$id = $this->input->post('id');
		$pelanggan = $this->pelanggan_model->getPelanggan($id);
		if ($pelanggan->row()) {
			echo json_encode($pelanggan->row());
		}
	}

	public function search()
	{
		header('Content-type: application/json');
		$pelanggan = $this->input->post('nama');
		$search = $this->pelanggan_model->search($pelanggan);
		foreach ($search as $pelanggan) {
			$data[] = array(
				'id' => $pelanggan->id,
				'text' => $pelanggan->nama
			);
		}
		echo json_encode($data);
	}

	public function _generateId()
	{
		$idmax = $this->pelanggan_model->maxId();
		return $idmax[0]['memberid'] + 1;
	}

	public function cekdataPoint()
	{
		header('Content-type: application/json');
		$pelanggan = $this->input->post('id');

		$toko = $this->db->get('toko')->row();
		$search = $this->pelanggan_model->cariPoint($pelanggan);
		$data = array(
			'nama' => $search->nama,
			'point' => $search->point,
			'uang' => $toko->uang,
			'minpoint' => $toko->minPoint
		);

		echo json_encode($data);
	}

	public function updatePoint()
	{
		header('Content-type: application/json');
		$pelanggan = $this->input->post('id');
		$tanggal = $this->input->post('tanggal');
		$point = $this->input->post('point');
		$toko = $this->db->get('toko')->row();
		$search = $this->pelanggan_model->cariPoint($pelanggan);


		$insert = array(
			'tanggal' => $tanggal,
			'id_pelanggan' => $pelanggan,
			'tukar_point' => $point,
			'jumlah_uangkeluar' => ($point / $toko->minPoint) * $toko->uang
		);

		$data = array(
			'point' => $search->point - $point,
		);

		if ($this->pelanggan_model->updatePoint($pelanggan, $data) && $this->db->insert('tukar_point', $insert)) {
			echo ($point / $toko->minPoint) * $toko->uang;
		}
	}

	public function updatePointall()
	{
		header('Content-type: application/json');
		$pelanggan = $this->input->post('id');
		$tanggal = $this->input->post('tanggal');
		$toko = $this->db->get('toko')->row();
		$search = $this->pelanggan_model->cariPoint($pelanggan);

		$point = $search->point;

		$insert = array(
			'tanggal' => $tanggal,
			'id_pelanggan' => $pelanggan,
			'tukar_point' => $point,
			'jumlah_uangkeluar' => ($point / $toko->minPoint) * $toko->uang
		);

		$data = array(
			'point' => $search->point - $point,
		);

		if ($this->pelanggan_model->updatePoint($pelanggan, $data) && $this->db->insert('tukar_point', $insert)) {
			echo ($point / $toko->minPoint) * $toko->uang;
		}
	}
}
