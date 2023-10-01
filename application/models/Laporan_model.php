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

	public function readPenukaran()
	{
		return $this->db->get('tukar_point');
	}

	public function sumHari()
	{
		$query = "SELECT SUM(total_bayar) AS pengeluaran, SUM(jumlah_uang) AS pemasukan 
                  FROM transaksi_2 WHERE SUBSTR(tanggal, 1,10 )= DATE(NOW())";

		return $this->db->query($query);
	}

	public function sumBulan()
	{
		$query = "SELECT SUM(total_bayar) AS pengeluaran, SUM(jumlah_uang) AS pemasukan 
                  FROM transaksi_2 WHERE MONTH(tanggal)=MONTH(NOW()) ";

		return $this->db->query($query);
	}

	public function sumTahun()
	{
		$query = "SELECT SUM(total_bayar) AS pengeluaran, SUM(jumlah_uang) AS pemasukan 
                  FROM transaksi_2 WHERE YEAR(tanggal)=YEAR(NOW()) ";

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

	public function laporan($where = array(), $start_date, $end_date)
	{
		$this->db->select('tk.*, pg.nama as nama_pelanggan, pn.nama as nama_pengguna, SUM(dt.qty * dt.harga) as total');
		$this->db->from('transaksi_2 tk');
		$this->db->join('detail_transaksi dt', 'dt.id_transaksi=tk.id');
		$this->db->join('pelanggan pg', 'tk.id_pelanggan=pg.id');
		$this->db->join('pengguna pn', 'tk.id_user_submit=pn.id');
		$this->db->group_by('tk.id');
		$this->db->order_by('tk.tanggal desc');
		$this->db->where($where);
		$this->db->where('dt.delete_at IS NULL', NULL);
		if (!empty($start_date) && !empty($end_date)) {
			$this->db->where("DATE_FORMAT(tk.tanggal,'%Y-%m-%d') >=", $start_date);
			$this->db->where("DATE_FORMAT(tk.tanggal,'%Y-%m-%d') <=", $end_date);
		}

		// $this->db->limit($limit, $start);
		// echo $this->db->get_compiled_select();
		// die();
		return $this->db->get();
	}

	public function detail_laporan($where = array())
	{
		$this->db->select('tk.*, dt.*, pd.nama as nama_product');

		$this->db->from('transaksi_2 tk');
		$this->db->join('detail_transaksi dt', 'dt.id_transaksi=tk.id');
		$this->db->join('produk pd', 'dt.id_product=pd.id');


		$this->db->where($where);

		// echo $this->db->get_compiled_select();
		// die();
		return $this->db->get();
	}
}
