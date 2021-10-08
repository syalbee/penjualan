<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function index()
	{
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('login');
		} else {
            if ($this->session->userdata('role') === 'admin'){
                $this->load->view('template/header');
                $this->load->view('template/sidebar');
                $this->load->view('admin/dashboard');
                $this->load->view('template/footer');
            } else {
                $this->load->view('template/header');
                $this->load->view('template/sidebar');
                $this->load->view('kasir/dashboard');
                $this->load->view('template/footer');
            }
		}
	}
}
