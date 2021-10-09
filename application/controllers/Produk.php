<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('login');
		}
		$this->load->model('produk_model');
	}

	public function index()
	{
		$this->load->view('admin/produk');
	}

	public function read()
	{
		header('Content-type: application/json');
		if ($this->produk_model->read()->num_rows() > 0) {
			foreach ($this->produk_model->read()->result() as $produk) {
				$data[] = array(
					'id' => $produk->id,
					'barcode' => $produk->barcode,
					'nama' => $produk->nama,
					'harga_asli' => $produk->harga_asli,
					'harga_grosir' => $produk->harga_grosir,
					'harga_biasa' => $produk->harga_biasa,
					'jml_grosir' => $produk->jml_grosir,
					'action' => '<button class="btn btn-sm btn-warning" onclick="edit('.$produk->id.')"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" onclick="remove('.$produk->id.')"><i class="fas fa-trash-alt"></i></button>'
				);
			}
		} else {
			$data = array();
		}
		$produk = array(
			'data' => $data
		);
		echo json_encode($produk);
	}

	public function add()
	{
		$data = array(
			'barcode' => $this->input->post('barcode'),
			'nama' => $this->input->post('nama_produk'),
			'harga_asli' => $this->input->post('hrgAsli'),
			'harga_grosir' => $this->input->post('hrgGrosir'),
			'harga_biasa' => $this->input->post('hrgBiasa'),
			'jml_grosir' => $this->input->post('jmlGrosir')
		);
		if ($this->produk_model->create($data)) {
			echo json_encode($data);
		}
	}

	public function delete()
	{
		$id = $this->input->post('id');
		if ($this->produk_model->delete($id)) {
			echo json_encode('sukses');
		}
	}

	public function edit()
	{
		$id = $this->input->post('id');
		$data = array(
			'barcode' => $this->input->post('barcode'),
			'nama' => $this->input->post('nama_produk'),
			'harga_asli' => $this->input->post('hrgAsli'),
			'harga_grosir' => $this->input->post('hrgGrosir'),
			'harga_biasa' => $this->input->post('hrgBiasa'),
			'jml_grosir' => $this->input->post('jmlGrosir')
		);

		if ($this->produk_model->update($id,$data)) {
			echo json_encode('sukses');
		}
	}

	public function get_produk()
	{
		header('Content-type: application/json');
		$id = $this->input->post('id');
		$kategori = $this->produk_model->getProduk($id);
		if ($kategori->row()) {
			echo json_encode($kategori->row());
		}

	}

	public function get_barcode()
	{
		header('Content-type: application/json');
		$barcode = $this->input->post('barcode');
		$search = $this->produk_model->getBarcode($barcode);
		foreach ($search as $barcode) {
			$data[] = array(
				'id' => $barcode->id,
				'text' => $barcode->barcode
			);
		}
		echo json_encode($data);
	}

	public function get_nama()
	{
		header('Content-type: application/json');
		$id = $this->input->post('id');
		echo json_encode($this->produk_model->getNama($id));
	}

	public function get_harga()
	{
		header('Content-type: application/json');
		$id = $this->input->post('id');
		echo json_encode($this->produk_model->getHarga($id));
	}

	public function produk_terlaris()
	{
		header('Content-type: application/json');
		$produk = $this->produk_model->produkTerlaris();
		foreach ($produk as $key) {
			$label[] = $key->nama_produk;
			$data[] = $key->terjual;
		}
		$result = array(
			'label' => $label,
			'data' => $data,
		);
		echo json_encode($result);
	}

	public function data_stok()
	{
		header('Content-type: application/json');
		$produk = $this->produk_model->dataStok();
		echo json_encode($produk);
	}

}

