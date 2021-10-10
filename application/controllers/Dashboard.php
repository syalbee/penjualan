<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function index()
	{
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('login');
		} else {
                $this->load->view('admin/dashboard');
		}
	}
}
