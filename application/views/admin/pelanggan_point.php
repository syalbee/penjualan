<!DOCTYPE html>
<html>

<head>
    <title>Tukar Point</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
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
                            <h1 class="m-0 text-dark">Penukaran Point</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>


            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <form id="point">
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="tukarpoint">ID Member</label>
                                            <input type="text" class="form-control" id="tukarpoint" placeholder="Masukan ID Member">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success" type="submit" onclick="cekpoint()">Cek</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
    <?php $this->load->view('includes/footer'); ?>
    <?php $this->load->view('partials/footer'); ?>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>

    <script>
        $('#point').validate({
            errorElement: 'span',
            errorPlacement: (error, element) => {
                error.addClass('invalid-feedback')
                element.closest('.form-group').append(error)
            },
            submitHandler: () => {
                $.ajax({
                    url: '<?php echo site_url('pengaturan/set_toko') ?>',
                    type: 'post',
                    dataType: 'json',
                    data: $('#toko').serialize(),
                    success: res => {
                        Swal.fire('Sukses', 'Sukses Mengedit', 'success').then(() => window.location.reload())
                    }
                })
            }
        })

        function cekpoint(){
            console.log("hahaha");
        }   
    </script>
</body>

</html>