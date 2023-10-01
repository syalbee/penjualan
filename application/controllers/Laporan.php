<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login') {
			redirect('login');
		}

		$this->load->model('laporan_model');
		$this->load->model('transaksi_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		if ($this->session->userdata('status') !== 'login') {
			redirect('login');
		}
	}

	public function laporan_penjualan()
	{
		$this->load->view('admin/laporan_penjualan');
	}

	public function laporan_harian()
	{
		$data = $this->laporan_model->sumHari()->row();
		$this->load->view('admin/laporan_harian', $data);
	}

	public function laporan_bulanan()
	{
		$data = $this->laporan_model->sumBulan()->row();
		$this->load->view('admin/laporan_bulanan', $data);
	}

	public function laporan_tahunan()
	{
		$data = $this->laporan_model->sumTahun()->row();
		$this->load->view('admin/laporan_tahunan', $data);
	}

	public function laporan_penukaran()
	{

		$this->load->view('admin/laporan_penukaran');
	}

	public function hari()
	{
		if ($this->laporan_model->readHari()->num_rows() > 0) {
			foreach ($this->laporan_model->readHari()->result() as $transaksi) {
				$tanggal = new DateTime($transaksi->tanggal);
				$data[] = array(
					'nota' => $transaksi->nota,
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'total_bayar' => $transaksi->total_bayar,
					'jumlah_uang' => $transaksi->jumlah_uang,
					'id' => $transaksi->id,
					'action' => '<button class="btn btn-sm btn-success" onclick="cetak(' . $transaksi->id . ')">cetak</button> <button class="btn btn-sm btn-warning" onclick="detail(' . $transaksi->id . ')">Detail</button>'
				);
			}
		} else {
			$data = array();
		}

		$transaksi = array(
			'data' => $data,
		);
		echo json_encode($transaksi);
	}

	public function bulan()
	{
		if ($this->laporan_model->readBulan()->num_rows() > 0) {
			foreach ($this->laporan_model->readBulan()->result() as $transaksi) {
				$tanggal = new DateTime($transaksi->tanggal);
				$data[] = array(
					'nota' => $transaksi->nota,
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'total_bayar' => $transaksi->total_bayar,
					'jumlah_uang' => $transaksi->jumlah_uang,
					'id' => $transaksi->id,
					'action' => '<button class="btn btn-sm btn-success" onclick="cetak(' . $transaksi->id . ')">cetak</button> <button class="btn btn-sm btn-warning" onclick="detail(' . $transaksi->id . ')">Detail</button>'
				);
			}
		} else {
			$data = array();
		}

		$transaksi = array(
			'data' => $data,
		);
		echo json_encode($transaksi);
	}

	public function tahun()
	{
		if ($this->laporan_model->readTahun()->num_rows() > 0) {
			foreach ($this->laporan_model->readTahun()->result() as $transaksi) {
				$tanggal = new DateTime($transaksi->tanggal);
				$data[] = array(
					'nota' => $transaksi->nota,
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'total_bayar' => $transaksi->total_bayar,
					'jumlah_uang' => $transaksi->jumlah_uang,
					'id' => $transaksi->id,
					'action' => '<button class="btn btn-sm btn-success" onclick="cetak(' . $transaksi->id . ')">cetak</button> <button class="btn btn-sm btn-warning" onclick="detail(' . $transaksi->id . ')">Detail</button>'
				);
			}
		} else {
			$data = array();
		}

		$transaksi = array(
			'data' => $data,
		);
		echo json_encode($transaksi);
	}

	public function penukaran()
	{
		if ($this->laporan_model->readPenukaran()->num_rows() > 0) {
			foreach ($this->laporan_model->readPenukaran()->result() as $penukaran) {
				$tanggal = new DateTime($penukaran->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'id_pelanggan' => $penukaran->id_pelanggan,
					'tukar_point' => $penukaran->tukar_point,
					'jumlah_uangkeluar' => $penukaran->jumlah_uangkeluar,
				);
			}
		} else {
			$data = array();
		}

		$penukaran = array(
			'data' => $data,
		);

		echo json_encode($penukaran);
	}


	public function detail($id)
	{
		$produk = $this->transaksi_model->getAll($id);

		$tanggal = new DateTime($produk->tanggal);
		$barcode = explode(',', $produk->barcode);
		$qty = explode(',', $produk->qty);
		$stsHarga = explode(',', $produk->status_harga);
		$produk->tanggal = $tanggal->format('d-m-Y H:i:s');
		$dataProduk = $this->transaksi_model->getName($barcode);


		foreach ($dataProduk as $key => $value) {
			if ($value != null) {
				$false = $value->sts = $stsHarga[$key];
				if ($false === "1") {
					$value->harga = $value->harga_grosir;
				} else {
					$value->harga = $value->harga_biasa;
				}

				$value->total = $qty[$key];
			}
		}

		if ($produk->pelanggan !== '0') {

			$this->db->select('nama, point');
			$this->db->where('id', $produk->pelanggan);
			$pelanggan = $this->db->get('pelanggan')->row();
		} else {
			$pelanggan = null;
		}

		$data = array(
			'nota' => $produk->nota,
			'tanggal' => $produk->tanggal,
			'produk' => $dataProduk,
			'total' => $produk->total_bayar,
			'bayar' => $produk->jumlah_uang,
			'kembalian' => $produk->jumlah_uang - $produk->total_bayar,
			'kasir' => $produk->kasir,
			'pelanggan' => $pelanggan
		);

		$transaksi = array(
			'data' => $data,
		);
		echo json_encode($transaksi);
	}

	public function transaksi_hari()
	{
		header('Content-type: application/json');
		$total = $this->laporan_model->sumHari()->row();
		echo json_encode($total);
	}


	public function laporan()
	{
		header('Content-type: application/json');
		$where = array();

		if (!empty($this->input->post('nota'))) {
			$where['tk.nota'] = $this->input->post('nota');
		}

		if (!empty($this->input->post('id_pelanggan'))) {
			$where['tk.id_pelanggan'] = $this->input->post('id_pelanggan');
		}
		if (!empty($this->input->post('id_petugas'))) {
			$where['tk.id_user_submit'] = $this->input->post('id_petugas');
		}

		$data = $this->laporan_model->laporan($where, $this->input->post('date1'), $this->input->post('date2'));

		if ($data->num_rows() > 0) {
			$data = $data->result_array();
			$final['draw'] = 1;
			$final['recordsTotal'] = sizeof($data);
			$final['recordsFiltered'] = sizeof($data);
			$final['data'] = $data;
		} else {
			$final['draw'] = 1;
			$final['recordsTotal'] = 1;
			$final['recordsFiltered'] = 1;
			$final['data'] = [];
		}

		echo json_encode($final, true);
	}

	public function detail_laporan()
	{
		header('Content-type: application/json');
		$where = array();


		if (!empty($this->input->post('id'))) {
			$where['tk.id'] = $this->input->post('id');
			$data = $this->laporan_model->detail_laporan($where);
		} else {
			$where['tk.id'] = 'kosong';
			$data = $this->laporan_model->detail_laporan($where);
		}

		if ($data->num_rows() > 0) {
			$data = $data->result_array();
			$final['draw'] = 1;
			$final['recordsTotal'] = sizeof($data);
			$final['recordsFiltered'] = sizeof($data);
			$final['data'] = $data;
		} else {
			$final['draw'] = 1;
			$final['recordsTotal'] = 1;
			$final['recordsFiltered'] = 1;
			$final['data'] = [];
		}

		echo json_encode($final, true);
	}
}
