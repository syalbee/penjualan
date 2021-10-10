<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo site_url('') ?>" class="brand-link text-center">
    <span class="brand-text font-weight-light"><?= $this->session->userdata('toko')->nama; ?></span>
  </a>
  <?php $uri = $this->uri->segment(1);
  $role = $this->session->userdata('role'); ?>


  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="<?php echo site_url('transaksi') ?>" class="nav-link <?php echo $uri == 'transaksi' ? 'active' : 'no' ?>">
            <i class="fas fa-money-bill nav-icon"></i>
            <p>Transaksi</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo site_url('pengaturan') ?>" class="nav-link <?php echo $uri == 'pengaturan' ? 'active' : 'no' ?>">
            <i class="fas fa-cog nav-icon"></i>
            <p>Penukaran Point</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>