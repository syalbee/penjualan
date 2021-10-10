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
	}

	public function index()
	{
		if ($this->session->userdata('status') !== 'login') {
			redirect('login');
		}
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
					'action' => '<a class="btn btn-sm btn-success" href="' . site_url('cetak/struk/') . $transaksi->id . '">Print</a> <button class="btn btn-sm btn-warning" onclick="detail(' . $transaksi->id . ')">Detail</button>'
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
					'action' => '<a class="btn btn-sm btn-success" href="' . site_url('cetak/struk/') . $transaksi->id . '">Print</a> <button class="btn btn-sm btn-warning" onclick="detail(' . $transaksi->id . ')">Detail</button>'
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
					'action' => '<a class="btn btn-sm btn-success" href="' . site_url('cetak/struk/') . $transaksi->id . '">Print</a> <button class="btn btn-sm btn-warning" onclick="detail(' . $transaksi->id . ')">Detail</button>'
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
            $false = $value->sts = $stsHarga[$key];
            if ($false === "1") {
                $value->harga = $value->harga_grosir;
            } else {
                $value->harga = $value->harga_biasa;
            }

            $value->total = $qty[$key];
        }

		if ($produk->pelanggan !== '0') {

            $this->db->select('nama, point');
            $this->db->where('id', $produk->pelanggan);
            $pelanggan = $this->db->get('pelanggan')->row();
        } else{
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
}
