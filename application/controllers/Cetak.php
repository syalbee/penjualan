<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') !== 'login') {
            redirect('login');
        }
        $this->load->model('transaksi_model');
        $this->load->model('pelanggan_model');
    }

    public function struk($id)
    {

        $this->load->library('escpos');
        $connector = new Escpos\PrintConnectors\WindowsPrintConnector("RP58");
        $printer = new Escpos\Printer($connector);
        $transaksi = $this->_getTransaksi($id);

        $printer->initialize();
        $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
        $printer->setFont(Escpos\Printer::FONT_A);
        $printer->text($this->session->userdata('toko')->nama . "\n");
        $printer->text($this->session->userdata('toko')->alamat . "\n");
        $printer->text("-------------------------------");

        $printer->initialize();
        $printer->setJustification(Escpos\Printer::JUSTIFY_LEFT);
        $printer->text("No Nota : " . $transaksi['nota'] . "\n");
        $printer->text("Tanggal : " . $transaksi['tanggal'] . "\n");
        $printer->text("Kasir   : " . $transaksi['kasir'] . "\n");
        $printer->text("-------------------------------");
        $printer->text("\n");

        foreach ($transaksi['produk'] as $key) {

            $printer->initialize();
            $printer->setFont(Escpos\Printer::FONT_A);
            $printer->text($key->nama . "  \n");

            $printer->initialize();
            $printer->setFont(Escpos\Printer::FONT_C);
            $printer->text($key->total . " * ");
            $printer->text($key->harga . " = ");

            $printer->text($key->total * $key->harga . "\n");
            $printer->initialize();
            $printer->setFont(Escpos\Printer::FONT_A);
        }

        $printer->text("-------------------------------");
        $printer->text("\n");

        if ($transaksi['pelanggan'] !== '0') {

            $this->db->select('nama, point');
            $this->db->where('id', $transaksi['pelanggan']);
            $pelanggan = $this->db->get('pelanggan')->row();

            $printer->text("Nama    : " . $pelanggan->nama . "\n");
            $printer->text("Point   : " . $pelanggan->point . "\n");
            $printer->text("--------------------------------");
        }

        $printer->text("Total   : " . $transaksi['total'] . "\n");
        $printer->text("Tunai   : " . $transaksi['bayar'] . "\n");
        $printer->text("Kembali : " . $transaksi['kembalian'] . "\n");
        $printer->text("\n");

        $printer->initialize();
        $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
        $printer->text("TERIMA KASIH \n");

        $printer->feed(2); // mencetak 2 baris kosong, agar kertas terangkat ke atas
        $printer->close();

        redirect('transaksi');
    }

    private function _getTransaksi($id)
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

        $data = array(
            'nota' => $produk->nota,
            'tanggal' => $produk->tanggal,
            'produk' => $dataProduk,
            'total' => $produk->total_bayar,
            'bayar' => $produk->jumlah_uang,
            'kembalian' => $produk->jumlah_uang - $produk->total_bayar,
            'kasir' => $produk->kasir,
            'pelanggan' => $produk->pelanggan
        );

        return $data;
    }
}
