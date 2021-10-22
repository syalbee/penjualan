<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index()
	{
		if ($this->session->userdata('status') !== 'login') {
			redirect('login');
		} else {
			if ($this->session->userdata('role') === 'admin') {
				$this->load->view('admin/dashboard');
			} else {
				$this->load->view('admin/transaksi');
			}
		}
	}
}
