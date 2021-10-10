<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends CI_Model {

	private $table = 'pelanggan';

	public function create($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function read()
	{
		return $this->db->get($this->table);
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}

	public function search($search="")
	{
		$this->db->like('memberid', $search);
		return $this->db->get($this->table)->result();
	}

	public function getPelanggan($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->table);
	}

	public function maxId()
	{
		return $this->db->query("SELECT memberid FROM bantu_pelanggan WHERE id = '1' ")->result_array();
	}

	public function getPoint($id)
	{
		$this->db->select('point');
		$this->db->where('id', $id);
		return $this->db->get($this->table)->row();
	}

	public function setPoint($id, $data)
	{
		$this->db->set('point', $data);
		$this->db->where('id', $id);
		return $this->db->update($this->table);
	}

	public function idTambah($data)
	{
		$this->db->set('memberid', $data);
		$this->db->where('id', 1);
		return $this->db->update('bantu_pelanggan');
		// return $this->db->insert('bantu_pelanggan', $data);
	}
}