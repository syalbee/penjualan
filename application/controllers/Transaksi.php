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
        $this->load->library('cart');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $this->load->view('admin/transaksi_2');
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
        $pointKelipatan = round($totalBelanja / $minUang);

        if ($totalBelanja >= $minUang) {
            $hasilPoint = $toko->point * $pointKelipatan;
            $this->pelanggan_model->setPoint($id, $hasilPoint + $point);
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

    // New kodingan

    public function insert_to_chart()
    {

        $data = array(
            'id'      => $this->input->post('id_product'),
            'qty'     => $this->input->post('qty'),
            'price'   => $this->input->post('harga'),
            'name'    => $this->input->post('nama_product'),
            'options' => array('status_harga' => $this->input->post('status_harga'),  'tanggal' => date('Y-m-d'))
        );

        if ($this->cart->insert($data)) {
            $jumlah_harga = 0;

            foreach ($this->cart->contents() as $data) {
                $jumlah_harga += $data['subtotal'];
            }

            $hasil = array(
                'code' => 200,
                'message' => "Berhasil insert data",
                'data' => $jumlah_harga,
            );
            echo json_encode($hasil);
        }
    }

    public function get_data_cart()
    {
        $data = $this->cart->contents();
        $final = array();
        $produk = array();
        $produk_data = array();

        foreach ($data as $val) {
            $produk['rowid'] = $val['rowid'];
            $produk['name'] = $val['name'];
            $produk['price'] = $val['price'];
            $produk['qty'] = $val['qty'];
            $produk['subtotal'] = $val['subtotal'];
            $produk['id_product'] = $val['id'];

            array_push($produk_data, $produk);
        }

        if (!empty($this->cart->contents())) {
            $final['draw'] = 1;
            $final['recordsTotal'] = sizeof($data);
            $final['recordsFiltered'] = sizeof($data);
            $final['data'] = $produk_data;
        } else {
            $final['draw'] = 1;
            $final['recordsTotal'] = 1;
            $final['recordsFiltered'] = 1;
            $final['data'] = [];
        }

        echo json_encode($final, true);
    }

    public function delete_cart()
    {
        $data = array(
            'rowid' => $this->input->post('rowid'),
            'qty'   => 0
        );

        if ($this->cart->update($data)) {
            $hasil = array(
                'code' => 200,
                'message' => "Berhasil hapus data",
                'data' => [],
            );
            echo json_encode($hasil);
        }
    }

    public function batal_transaksi()
    {
        $this->cart->destroy();
        $hasil = array(
            'code' => 200,
            'message' => "Berhasil hapus data",
            'data' => [],
        );
        echo json_encode($hasil);
    }

    public function get_subtotal()
    {
        $jumlah_harga = 0;
        foreach ($this->cart->contents() as $data) {
            $jumlah_harga += $data['subtotal'];
        }

        $hasil = array(
            'code' => 200,
            'message' => "Berhasil get data",
            'data' => $jumlah_harga,
        );

        echo json_encode($hasil);
    }

    public function bayar_transaksi()
    {
        $id_pelanggan = '';
        $tanggal = new DateTime($this->input->post('tanggal'));

        if (!empty($this->input->post('pelanggan'))) {
            $id_pelanggan = $this->input->post('pelanggan');
            $this->setPoint($this->input->post('pelanggan'), $this->input->post('total_bayar'));
        } else {
            $id_pelanggan = '0';
        }

        $data_transaksi = array(
            'total_bayar' => $this->input->post('total_bayar'),
            'jumlah_uang' => $this->input->post('jumlah_uang'),
            'id_pelanggan' => $id_pelanggan,
            'nota' => $this->input->post('nota'),
            'id_user_submit' => $this->session->userdata('id'),
            'tanggal' => $tanggal->format('Y-m-d H:i:s'),
        );

        $id_transaksi = $this->transaksi_model->bayar($data_transaksi);

        $data_produk = array();
        if (!empty($id_transaksi)) {
            foreach ($this->cart->contents() as $data) {
                $data_produk['id_product'] = $data['id'];
                $data_produk['id_transaksi'] = $id_transaksi;
                $data_produk['qty'] = $data['qty'];
                $data_produk['harga'] = $data['price'];
                $data_produk['status_harga'] = $data['options']['status_harga'];
                $data_produk['tanggal'] = $data['options']['tanggal'];
                $this->transaksi_model->insert_produk($data_produk);
            }
        }
        $this->cart->destroy();
        $hasil = array(
            'code' => 200,
            'message' => "Berhasil bayar",
            'id_transaksi' => $id_transaksi,
        );

        echo json_encode($hasil);
    }


    public function hapus_produk()
    {
        if ($this->transaksi_model->delete_detail($this->input->post('id'))) {
            $hasil = array(
                'code' => 200,
                'message' => "Berhasil hapus produk",
                'data' => [],
            );
        } else {
            $hasil = array(
                'code' => 200,
                'message' => "Gagal hapus produk",
                'data' => [],
            );
        }

        echo json_encode($hasil);
    }

    public function update_kembalian()
    {
        if ($this->transaksi_model->update_pembayaran($this->input->post('id'), $this->input->post('kembalian'))) {
            $hasil = array(
                'code' => 200,
                'message' => "Berhasil update transaksi",
                'data' => [],
            );
        } else {
            $hasil = array(
                'code' => 200,
                'message' => "Gagal update transaksi",
                'data' => [],
            );
        }

        echo json_encode($hasil);
    }
}
