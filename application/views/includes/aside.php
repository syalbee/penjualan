<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo site_url('') ?>" class="brand-link text-center">
    <span class="brand-text font-weight-light"><?= $this->session->userdata('toko')->nama; ?></span>
  </a>
  <?php $uri = $this->uri->segment(1);
  $role = $this->session->userdata('role');
  ?>


  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <?php if ($role === 'kasir') : ?>
          <li class="nav-item">
            <a href="<?php echo site_url('transaksi') ?>" class="nav-link <?php echo $uri == 'transaksi' ? 'active' : 'no' ?>">
              <i class="fas fa-shopping-cart nav-icon"></i>
              <p>Transaksi</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo site_url('pelanggan/indexpoint') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'indexpoint' ? 'active' : 'no' ?>">
              <i class="fas fa-money-bill nav-icon"></i>
              <p>Penukaran Point</p>
            </a>
          </li>
        <?php endif ?>

        <?php if ($role === 'admin') : ?>
          <li class="nav-item">
            <a href="<?php echo site_url('dashboard') ?>" class="nav-link <?php echo $uri == 'dashboard' || $uri == '' ? 'active' : 'no' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo site_url('pelanggan') ?>" class="nav-link <?php echo $uri == 'pelanggan' ? 'active' : 'no' ?>">
              <i class="nav-icon fas fa-address-book"></i>
              <p>
                Pelanggan
              </p>
              <i class="right fas fa-angle-right"></i>
            </a>

            <ul class="nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('pelanggan') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'indexpoint' ? 'no' : 'active' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Pelanggan</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo site_url('pelanggan/indexpoint') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'indexpoint' ? 'active' : 'no' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penukaran Point</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?php echo site_url('produk') ?>" class="nav-link <?php echo $uri == 'produk' ? 'active' : 'no' ?>">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Produk
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo site_url('transaksi') ?>" class="nav-link <?php echo $uri == 'transaksi' ? 'active' : 'no' ?>">
              <i class="fas fa-money-bill nav-icon"></i>
              <p>Transaksi</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo site_url('laporan/laporan_harian') ?>" class="nav-link <?php echo $uri == 'laporan'  ? 'active' : 'no' ?>">
              <i class="fas fa-book nav-icon"></i>
              <p>Laporan</p>
              <i class="right fas fa-angle-right"></i>
            </a>

            <ul class="nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('laporan/laporan_penjualan') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'laporan_penjualan' ? 'active' : 'no' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Penjualan</p>
                </a>
              </li>

              <!-- <li class="nav-item">
                <a href="<?php echo site_url('laporan/laporan_bulanan') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'laporan_bulanan' ? 'active' : 'no' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Bulanan</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo site_url('laporan/laporan_tahunan') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'laporan_tahunan' ? 'active' : 'no' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Tahunan</p>
                </a>
              </li> -->

              <li class="nav-item">
                <a href="<?php echo site_url('laporan/laporan_penukaran') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'laporan_penukaran' ? 'active' : 'no' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Penukaran Point</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?php echo site_url('pengaturan') ?>" class="nav-link <?php echo $uri == 'pengaturan' ? 'active' : 'no' ?>">
              <i class="fas fa-cog nav-icon"></i>
              <p>Pengaturan</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo site_url('pengguna') ?>" class="nav-link <?php echo $uri == 'pengguna' ? 'active' : 'no' ?>">
              <i class="fas fa-user nav-icon"></i>
              <p>Pengguna</p>
            </a>
          </li>
        <?php endif ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>