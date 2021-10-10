<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') !== 'login') {
            redirect('login');
        }
        $this->load->model('transaksi_model');
        $this->load->model('pelanggan_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $this->load->view('admin/transaksi');
    }

    public function read()
    {
        // header('Content-type: application/json');
        if ($this->transaksi_model->read()->num_rows() > 0) {
            foreach ($this->transaksi_model->read()->result() as $transaksi) {
                $barcode = explode(',', $transaksi->barcode);
                $tanggal = new DateTime($transaksi->tanggal);
                $data[] = array(
                    'tanggal' => $tanggal->format('d-m-Y H:i:s'),
                    'nama_produk' => '<table>' . $this->transaksi_model->getProduk($barcode, $transaksi->qty) . '</table>',
                    'total_bayar' => $transaksi->total_bayar,
                    'jumlah_uang' => $transaksi->jumlah_uang,
                    'diskon' => $transaksi->diskon,
                    'pelanggan' => $transaksi->pelanggan,
                    'action' => '<a class="btn btn-sm btn-success" href="' . site_url('transaksi/cetak/') . $transaksi->id . '">Print</a> <button class="btn btn-sm btn-danger" onclick="remove(' . $transaksi->id . ')">Delete</button>'
                );
            }
        } else {
            $data = array();
        }
        $transaksi = array(
            'data' => $data
        );
        echo json_encode($transaksi);
    }

    public function add()
    {
        $produk = json_decode($this->input->post('produk'));
        $tanggal = new DateTime($this->input->post('tanggal'));
        $barcode = array();
        $qty = array();
        $statusHarga = array();

        if (!empty($this->input->post('pelanggan'))) {
            $this->setPoint($this->input->post('pelanggan'), $this->input->post('total_bayar'));
        }

        foreach ($produk as $produk) {
            array_push($barcode, $produk->id);
            array_push($qty, $produk->terjual);
            array_push($statusHarga, $produk->harga);
        }

        $data = array(
            'tanggal' => $tanggal->format('Y-m-d H:i:s'),
            'barcode' => implode(',', $barcode),
            'qty' => implode(',', $qty),
            'status_harga' => implode(',', $statusHarga),
            'total_bayar' => $this->input->post('total_bayar'),
            'jumlah_uang' => $this->input->post('jumlah_uang'),
            'pelanggan' => $this->input->post('pelanggan'),
            'nota' => $this->input->post('nota'),
            'kasir' => $this->session->userdata('id')
        );

        if ($this->transaksi_model->create($data)) {
            echo json_encode($this->db->insert_id());
        }

        $data = $this->input->post('form');
    }



    public function setPoint($id, $totalBelanja)
    {
        $pelanggan = $this->pelanggan_model->getPoint($id);
        $toko =  $this->db->get('toko')->row();

        $point = $pelanggan->point;
        $minUang = $toko->jumUang;

        if ($totalBelanja >= $minUang) {
            $hasilPoint = $point + $toko->point;
            $this->pelanggan_model->setPoint($id, $hasilPoint);
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');
        if ($this->transaksi_model->delete($id)) {
            echo json_encode('sukses');
        }
    }


    public function penjualan_bulan()
    {
        header('Content-type: application/json');
        $day = $this->input->post('day');
        foreach ($day as $key => $value) {
            $now = date($day[$value] . ' m Y');
            if ($qty = $this->transaksi_model->penjualanBulan($now) !== []) {
                $data[] = array_sum($this->transaksi_model->penjualanBulan($now));
            } else {
                $data[] = 0;
            }
        }
        echo json_encode($data);
    }

    public function transaksi_hari()
    {
        header('Content-type: application/json');
        $now = date('d m Y');
        $total = $this->transaksi_model->transaksiHari($now);
        echo json_encode($total);
    }

    public function transaksi_terakhir($value = '')
    {
        header('Content-type: application/json');
        $now = date('d m Y');
        foreach ($this->transaksi_model->transaksiTerakhir($now) as $key) {
            $total = explode(',', $key);
        }
        echo json_encode($total);
    }
}
