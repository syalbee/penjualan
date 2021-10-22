<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <?php $this->load->view('partials/head'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php $this->load->view('includes/nav'); ?>

  <?php $this->load->view('includes/aside'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-sm-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="transaksi_hari">0</h3>
                <p>Transaksi Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="<?php echo site_url('laporan/laporan_harian') ?>" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3 id="transaksi_terakhir">0</h3>
                <p>Pendapatan Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill"></i>
              </div>
              <a href="<?php echo site_url('laporan/laporan_harian') ?>" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <!-- <div class="col-lg-4 col-sm-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 id="stok_hari">0</h3>
                <p>Pengeluaran Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill"></i>
              </div>
              <a href="" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div> -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?php $this->load->view('includes/footer'); ?>

<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
<script>
  var transaksi_hariUrl = '<?php echo site_url('transaksi/transaksi_hari') ?>';
  var transaksi_terakhirUrl = '<?php echo site_url('laporan/transaksi_hari') ?>';
  var stok_hariUrl = '<?php echo site_url('laporan/transaksi_hari') ?>';

  var produk_terlarisUrl = '<?php echo site_url('produk/produk_terlaris') ?>';
  var data_stokUrl = '<?php echo site_url('produk/data_stok') ?>';
  var penjualan_bulanUrl = '<?php echo site_url('transaksi/penjualan_bulan') ?>';
</script>
<script src="<?php echo base_url('assets/js/unminify/dashboard.js') ?>"></script>
</body>
</html>
