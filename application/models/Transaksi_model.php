<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{

	private $table = 'transaksi';

	public function removeStok($id, $stok)
	{
		$this->db->where('id', $id);
		$this->db->set('stok', $stok);
		return $this->db->update('produk');
	}

	public function addTerjual($id, $jumlah)
	{
		$this->db->where('id', $id);
		$this->db->set('terjual', $jumlah);
		return $this->db->update('produk');;
	}

	public function create($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function read()
	{
		$this->db->select('transaksi.id, transaksi.tanggal, transaksi.barcode, transaksi.qty, transaksi.total_bayar, transaksi.jumlah_uang, transaksi.diskon, pelanggan.nama as pelanggan');
		$this->db->from($this->table);
		$this->db->join('pelanggan', 'transaksi.pelanggan = pelanggan.id', 'left outer');
		return $this->db->get();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}

	public function getProduk($barcode, $qty)
	{
		$total = explode(',', $qty);
		foreach ($barcode as $key => $value) {
			$this->db->select('nama_produk');
			$this->db->where('id', $value);
			$data[] = '<tr><td>' . $this->db->get('produk')->row()->nama_produk . ' (' . $total[$key] . ')</td></tr>';
		}
		return join($data);
	}


	public function penjualanBulan($date)
	{
		$qty = $this->db->query("SELECT qty FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$date'")->result();
		$d = [];
		$data = [];
		foreach ($qty as $key) {
			$d[] = explode(',', $key->qty);
		}
		foreach ($d as $key) {
			$data[] = array_sum($key);
		}
		return $data;
	}

	public function transaksiHari($hari)
	{
		return $this->db->query("SELECT COUNT(*) AS total FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$hari'")->row();
	}

	public function transaksiTerakhir($hari)
	{
		return $this->db->query("SELECT transaksi.qty FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$hari' LIMIT 1")->row();
	}

	public function getAll($id)
	{
		$this->db->select('transaksi.nota, transaksi.pelanggan, transaksi.status_harga, transaksi.tanggal, transaksi.barcode, transaksi.qty, transaksi.total_bayar, transaksi.jumlah_uang, pengguna.nama as kasir');
		$this->db->from('transaksi');
		$this->db->join('pengguna', 'transaksi.kasir = pengguna.id');
		$this->db->where('transaksi.id', $id);
		return $this->db->get()->row();
	}

	public function getName($barcode)
	{
		foreach ($barcode as $b) {
			$this->db->select('nama, harga_biasa, harga_grosir');
			$this->db->where('id', $b);
			$this->db->where('delete_at IS NULL', NULL, FALSE);
			$data[] = $this->db->get('produk')->row();
		}
		return $data;
	}

	public function bayar($data)
	{
		$this->db->insert('transaksi_2', $data);
		$insertId = $this->db->insert_id();

		return  $insertId;
	}

	public function insert_produk($data)
	{
		return $this->db->insert('detail_transaksi', $data);
	}

	public function update_pembayaran($id, $uang)
	{
		$this->db->where('id', $id);
		$this->db->set('jumlah_uang', $uang);
		return $this->db->update('transaksi_2');;
	}

	public function delete_detail($id)
	{
		$this->db->where('id', $id);
		$this->db->set('delete_at', date('Y-m-d'));
		return $this->db->update('detail_transaksi');;
	}


	public function get_struk($id = '')
	{
		$this->db->select('tk.*, pg.nama as nama_pelanggan,  pg.id as id_pelanggan, pn.nama as nama_pengguna, SUM(dt.qty * dt.harga) as total');
		$this->db->from('transaksi_2 tk');
		$this->db->join('detail_transaksi dt', 'dt.id_transaksi=tk.id');
		$this->db->join('pelanggan pg', 'tk.id_pelanggan=pg.id');
		$this->db->join('pengguna pn', 'tk.id_user_submit=pn.id');
		$this->db->group_by('tk.id');
		$this->db->order_by('tk.tanggal desc');
		$this->db->where('tk.id', $id);
		$this->db->where('dt.delete_at IS NULL', NULL);

		// $this->db->limit($limit, $start);
		// echo $this->db->get_compiled_select();
		// die();
		return $this->db->get();
	}

	public function detail_produk($id = '')
	{
		$this->db->select('dt.*, pd.nama as nama_product');

		$this->db->from('detail_transaksi dt');
		$this->db->join('produk pd', 'dt.id_product=pd.id');
		$this->db->where('dt.delete_at IS NULL', NULL);
		$this->db->where('dt.id_transaksi', $id);

		// echo $this->db->get_compiled_select();
		// die();
		return $this->db->get();
	}
}

/* End of file Transaksi_model.php */
/* Location: ./application/models/Transaksi_model.php */