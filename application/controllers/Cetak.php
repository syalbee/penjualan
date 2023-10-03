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
        $this->load->library('escpos');
        date_default_timezone_set('Asia/Jakarta');
    }

    function format_rupiah($angka)
    {
        $hasil = 'Rp ' . number_format($angka, 0, ",", ".");
        return $hasil;
    }

    function format_rupiah_2($angka)
    {
        $hasil = number_format($angka, 0, ",", ".");
        return $hasil;
    }

    public function struk($id)
    {
        $connector = new Escpos\PrintConnectors\WindowsPrintConnector('thermalprint');
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
            if ($key != null) {
                $printer->initialize();
                $printer->setFont(Escpos\Printer::FONT_A);
                $printer->text($key->nama_product . "  \n");

                $printer->initialize();
                $printer->setFont(Escpos\Printer::FONT_C);
                $printer->text($key->qty . " * ");
                $printer->text($this->format_rupiah_2($key->harga) . " = ");

                $printer->text($this->format_rupiah_2($key->qty * $key->harga) . "\n");
                $printer->initialize();
                $printer->setFont(Escpos\Printer::FONT_A);
            }
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

        $printer->text("Total   : " .  $this->format_rupiah($transaksi['total']) . "\n");
        $printer->text("Tunai   : " .  $this->format_rupiah($transaksi['bayar']) . "\n");
        $printer->text("Kembali : " .  $this->format_rupiah($transaksi['kembalian']) . "\n");
        $printer->text("\n");

        $printer->initialize();
        $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
        $printer->text("TERIMA KASIH \n");

        $printer->feed(2); // mencetak 2 baris kosong, agar kertas terangkat ke atas
        $printer->close();
    }

    public function test()
    {
        redirect('dashboard');
    }

    // private function _getTransaksi($id)
    // {
    //     $produk = $this->transaksi_model->getAll($id);

    //     $tanggal = new DateTime($produk->tanggal);
    //     $barcode = explode(',', $produk->barcode);
    //     $qty = explode(',', $produk->qty);
    //     $stsHarga = explode(',', $produk->status_harga);
    //     $produk->tanggal = $tanggal->format('d-m-Y H:i:s');
    //     $dataProduk = $this->transaksi_model->getName($barcode);


    //     foreach ($dataProduk as $key => $value) {
    //         if ($value != null) {
    //             $false = $value->sts = $stsHarga[$key];
    //             if ($false === "1") {
    //                 $value->harga = $value->harga_grosir;
    //             } else {
    //                 $value->harga = $value->harga_biasa;
    //             }
    //             $value->total = $qty[$key];
    //         }
    //     }

    //     $data = array(
    //         'nota' => $produk->nota,
    //         'tanggal' => $produk->tanggal,
    //         'produk' => $dataProduk,
    //         'total' => $produk->total_bayar,
    //         'bayar' => $produk->jumlah_uang,
    //         'kembalian' => $produk->jumlah_uang - $produk->total_bayar,
    //         'kasir' => $produk->kasir,
    //         'pelanggan' => $produk->pelanggan
    //     );

    //     return $data;
    // }

    private function _getTransaksi($id)
    {
        $transaksi = $this->transaksi_model->get_struk($id)->result()[0];
        $produk = $this->transaksi_model->detail_produk($id)->result();

        $data = array(
            'nota' => $transaksi->nota,
            'tanggal' => $transaksi->tanggal,
            'total' => $transaksi->total,
            'bayar' => $transaksi->jumlah_uang,
            'kembalian' => $transaksi->jumlah_uang - $transaksi->total,
            'kasir' => $transaksi->nama_pengguna,
            'pelanggan' => $transaksi->id_pelanggan,
            'produk' => $produk,
        );
        return $data;
    }
}
