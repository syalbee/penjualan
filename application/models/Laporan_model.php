<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

	private $table = 'transaksi';

	public function readHari()
	{

		$query = "SELECT nota, tanggal, total_bayar, jumlah_uang, id
        FROM transaksi WHERE SUBSTR(tanggal, 1,10 )= DATE(NOW())";

		return $this->db->query($query);
	}

	public function readBulan()
	{

		$query = "SELECT nota, tanggal, total_bayar, jumlah_uang, id
        FROM transaksi  WHERE MONTH(tanggal)=MONTH(NOW())";

		return $this->db->query($query);
	}

	public function readTahun()
	{

		$query = "SELECT nota, tanggal, total_bayar, jumlah_uang, id
        FROM transaksi WHERE YEAR(tanggal)=YEAR(NOW())";

		return $this->db->query($query);
	}

	public function sumHari()
	{
		$query = "SELECT SUM(total_bayar) AS pengeluaran, SUM(jumlah_uang) AS pemasukan 
                  FROM transaksi WHERE SUBSTR(tanggal, 1,10 )= DATE(NOW())";

		return $this->db->query($query);
	}

	public function sumBulan()
	{
		$query = "SELECT SUM(total_bayar) AS pengeluaran, SUM(jumlah_uang) AS pemasukan 
                  FROM transaksi WHERE MONTH(tanggal)=MONTH(NOW()) ";

		return $this->db->query($query);
	}

	public function sumTahun()
	{
		$query = "SELECT SUM(total_bayar) AS pengeluaran, SUM(jumlah_uang) AS pemasukan 
                  FROM transaksi WHERE YEAR(tanggal)=YEAR(NOW()) ";

		return $this->db->query($query);
	}

	public function getName($barcode)
	{
		foreach ($barcode as $b) {
			$this->db->select('nama, harga_biasa, harga_grosir');
			$this->db->where('id', $b);
			$data[] = $this->db->get('produk')->row();
		}
		return $data;
	}
}

