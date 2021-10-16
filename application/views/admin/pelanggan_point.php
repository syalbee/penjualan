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
                                            <input type="text" class="form-control" id="tukarpoint" placeholder="Masukan ID Member" required>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success" type="button" onclick="cekPoint()">Cek</button>
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


    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pelanggan</h5>
                    <button class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="cekPoint">
                        <div class="form-group">
                            <b>Mininimal point :</b> <span class="minpoint"></span><br>
                            <b>Setiap penukaran mendapatkan :</b> <span class="minuang"></span><br>
                            <hr>
                            <b>Nama :</b> <span class="npoint"></span> <br>
                            <b>Jumlah point :</b> <span class="jpoint"></span> <br>
                            <b>Tanggal :</b> <span class="tpoint"></span>

                        </div>

                        <div class="form-group">
                            <label>Point yang ingin ditukar</label>
                            <input type="text" class="form-control" name="jumlahpoint" id="jumlahpoint" required>
                        </div>

                        <button id="add" class="btn btn-success" type="button" onclick="setPoint()">Tukar</button>
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ./wrapper -->
    <?php $this->load->view('includes/footer'); ?>
    <?php $this->load->view('partials/footer'); ?>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/moment/moment.min.js') ?>"></script>

    <script>
        // console.log(moment().format("D-M-Y H:mm:ss"));
        function cekPoint() {

            $.ajax({
                url: '<?php echo site_url('pelanggan/cekdatapoint') ?>',
                type: "post",
                dataType: "json",
                data: {
                    id: $("#tukarpoint").val()
                },
                success: (res) => {
                    console.log(res);
                    $('#modal').modal('show');

                    $(".npoint").html(res.nama);
                    $(".jpoint").html(res.point);
                    $(".minpoint").html(res.minpoint);
                    $(".minuang").html(formatRupiah(res.uang));
                    $(".tpoint").html(moment().format("D-MM-Y"));
                },
            });
        }

        function setPoint() {
            $.ajax({
                url: '<?php echo site_url('pelanggan/updatepoint') ?>',
                type: "post",
                dataType: "json",
                data: {
                    id: $("#tukarpoint").val(),
                    tanggal: moment().format("D-M-Y H:mm:ss"),
                    point: $("#jumlahpoint").val()
                },
                success: (res) => {
                    Swal.fire("<h1>Jumlah Uang</h1>", formatRupiah(parseInt(res)), "success").then(() =>
                        window.location.reload()
                    );
                },
            });
        }

        function formatRupiah(bilangan) {
            var reverse = bilangan.toString().split("").reverse().join(""),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join(".").split("").reverse().join("");

            if (bilangan < 0) {
                return "RP." + bilangan;
            } else {
                return "RP." + ribuan;
            }
        }
    </script>
</body>

</html>