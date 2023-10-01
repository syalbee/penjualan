<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/select2/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') ?>">
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
                            <h1 class="m-0 text-dark">Laporan Penjualan</h1>
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
                            <div class="row">
                                <!-- <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="select_paging">Row in Page</label>
                                        <select name="select_paging" id="select_paging" class="form-control form-control-sm">
                                            <option value="10">10 Rows</option>
                                            <option value="15">15 Rows</option>
                                            <option value="20">20 Rows</option>
                                            <option value="50">50 Rows</option>
                                            <option value="150">150 Rows</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="nota">No Nota</label>
                                        <input type="text" name="nota" id="nota" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="id_pelanggan">Pelanggan</label>
                                        <select name="id_pelanggan" id="id_pelanggan" class="form-control form-control-sm">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="id_petugas">Kasir</label>
                                        <select name="id_petugas" id="id_petugas" class="form-control form-control-sm">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="date1">Tanggal Awal</label>
                                        <input type="date" name="date1" id="date1" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="type_order">Tanggal Akhir</label>
                                        <input type="date" name="date2" id="date2" class="form-control form-control-sm">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label for="btn_refresh">Refresh Data</label>
                                    <button name="btn_refresh" id="btn_refresh" type="button" class="btn btn-sm btn-primary btn-block">
                                        <i class="fa fa-refresh"></i> Refresh
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive mt-2">
                                    <table class="table w-100 table-bordered table-sm table-hover" id="tb_laporan_penjualan">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Nota</th>
                                                <th>Tanggal </th>
                                                <th>Total Bayar</th>
                                                <th>Total Bayar Asli</th>
                                                <th>Jumlah Uang</th>
                                                <th>Pelanggan</th>
                                                <th>Petugas</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- <div class="col-md-12">
                                    <div class="pull-right mt-3">
                                        <div class="form-group form-inline">
                                            <div class="form-group mx-sm-1">
                                                <button class="btn btn-sm btn-primary m-1" name="btn_prev">
                                                    <i class="fa fa-arrow-left"></i> Prev
                                                </button>
                                            </div>
                                            <div class="form-group mx-sm-1">
                                                <input class="form-control form-control-sm m-1" type="number" name="current_page" id="current_page" value="1">
                                            </div>
                                            <div class="form-group mx-sm-1">
                                                <span name="total_page">of 10</span>

                                                <button class="btn btn-sm btn-primary m-1" name="btn_next">
                                                    <i class="fa fa-arrow-right"></i> Next
                                                </button>

                                                <button class="btn btn-sm btn-primary m-1" name="btn_last">
                                                    <i class="fa fa-forward"></i> Last
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>

    <div class="modal" id="modal_detail">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive mt-2">
                        <table id="table_detail" class="table w-100 table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal_kembalian">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Kembalian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="total_transaksi">Total transaksi : </h5>
                    <div class="form-group">
                        <input placeholder="Jumlah Uang" type="text" class="form-control" name="jumlah_uang" id="jumlah_uang" autocomplete="off" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btn_bayar_kembali" class="btn btn-success">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ./wrapper -->
    <?php $this->load->view('includes/footer'); ?>
    <?php $this->load->view('partials/footer'); ?>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/select2/js/select2.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/adminlte/plugins/moment/moment.min.js') ?>"></script>
    <script>
        $(document).ready(function() {

            var id_detail_transaksi = '';
            var id_kembalian = '';
            var total_bayar = 0;

            var table = $('#tb_laporan_penjualan').DataTable({
                ajax: {
                    url: "<?= site_url('laporan/laporan') ?>",
                    type: 'POST',
                    data: function(d) {
                        d.nota = $('#nota').val();
                        d.id_pelanggan = $('#id_pelanggan').val();
                        d.id_petugas = $('#id_petugas').val();
                        d.date1 = $('#date1').val();
                        d.date2 = $('#date2').val();
                    }
                },
                columns: [{
                        data: 'id',
                        orderable: false,
                    },
                    {
                        data: 'nota',
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'total_bayar',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'total',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'jumlah_uang',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'nama_pelanggan'
                    },
                    {
                        data: 'nama_pengguna'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            var btn = `
                            <button class="btn btn-primary btn-print btn-sm"><i class="fas fa-print"></i></button> &nbsp;
                            <button class="btn btn-success btn-detail btn-sm"><i class="fas fa-list"></i></button> &nbsp;
                            <button class="btn btn-warning btn-kembalian btn-sm"><i class="fas fa-money-bill-wave"></i></button>`;
                            return btn;
                        },
                    },
                ],
                dom: 'blrtip',
                lengthMenu: [
                    [10, 25, 50, 100],
                    ['10 rows', '25 rows', '50 rows', '100 rows']
                ],
                buttons: [
                    'pageLength',
                    'excel',
                    {
                        text: 'Refresh',
                        action: function(e, dt, node, config) {
                            table.ajax.reload();
                        }
                    }
                ],
            });

            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            var table_detail = $('#table_detail').DataTable({
                ajax: {
                    url: "<?= site_url('laporan/detail_laporan') ?>",
                    type: 'POST',
                    data: function(d) {
                        d.id = id_detail_transaksi;
                    }
                },
                columns: [{
                        data: 'id',
                        orderable: false,
                    },
                    {
                        data: 'nama_product',
                    },
                    {
                        data: 'qty'
                    },
                    {
                        data: 'harga',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'harga',
                        render: function(data, type, row) {
                            var total = data * row['qty'];
                            return formatRupiah(total);
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            var btn_delete = '<button class="btn btn-danger btn-delete btn-sm"><i class="fas fa-trash"></i></button>';
                            return btn_delete;
                        },
                    },
                ],
                dom: 'blrtip',
                lengthMenu: [
                    [10, 25, 50, 100],
                    ['10 rows', '25 rows', '50 rows', '100 rows']
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData['delete_at'] != null) {
                        $('td', nRow).css('background-color', '#ea9999');
                    }
                }
            });

            table_detail.on('order.dt search.dt', function() {
                table_detail.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            $("#btn_refresh").on('click', function() {
                table.ajax.reload();
            });

            $('#tb_laporan_penjualan tbody').on('click', 'button.btn-detail', function() {
                var data = table.row($(this).parents('tr')).data();
                id_detail_transaksi = data.id;
                $('#modal_detail').modal('show');
                table_detail.ajax.reload();

            });

            $('#tb_laporan_penjualan tbody').on('click', 'button.btn-print', function() {
                var data = table.row($(this).parents('tr')).data();
                $.ajax({
                    url: '<?php echo site_url('cetak/struk/') ?>' + data.id,
                    type: "post",
                    success: (a) => {
                        console.log(a);
                    },
                    error: (a) => {
                        console.log(a);
                    },
                });
            });

            $('#tb_laporan_penjualan tbody').on('click', 'button.btn-kembalian', function() {
                var data = table.row($(this).parents('tr')).data();
                id_kembalian = data.id;
                total_bayar = data.total;
                $('#total_transaksi').html('Total transaksi : Rp. ' + formatRupiah(total_bayar));
                $('#modal_kembalian').modal('show');
            });

            $("#btn_bayar_kembali").on('click', function() {
                if ($('#jumlah_uang').val() == '') {
                    Swal.fire(
                        'Oops...',
                        'Harap isi jumlah uang',
                        'error'
                    )
                    return false;
                }

                if (parseInt($('#jumlah_uang').val().replaceAll('.', '')) < total_bayar) {
                    Swal.fire(
                        'Oops...',
                        'Jumlah uang kurang dari total transaksi',
                        'error'
                    )
                    return false;
                }
                Swal.fire({
                    title: 'Apakah anda yakin mengupdate transaksi ini ?',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                }).then((result) => {
                    if (result.value == true) {
                        $.ajax({
                            url: "<?= site_url('transaksi/update_kembalian') ?>",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                id: id_kembalian,
                                kembalian: $('#jumlah_uang').val().replaceAll('.', ''),
                            },
                            success: (a) => {
                                if (a.code == 200) {
                                    Swal.fire(
                                        'Sukses',
                                        a.message,
                                        'success'
                                    )
                                    table.ajax.reload();
                                }

                            },
                            error: (a) => {
                                console.log(a);
                            },
                        });
                    }
                });
            });

            $('#table_detail tbody').on('click', 'button.btn-delete', function() {
                var data = table_detail.row($(this).parents('tr')).data();
                Swal.fire({
                    title: 'Apakah anda yakin menghapus produk ini ?',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                }).then((result) => {
                    if (result.value == true) {
                        $.ajax({
                            url: "<?= site_url('transaksi/hapus_produk') ?>",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                id: data.id,
                            },
                            success: (a) => {
                                if (a.code == 200) {
                                    Swal.fire(
                                        'Sukses',
                                        a.message,
                                        'success'
                                    )
                                    table_detail.ajax.reload();
                                    table.ajax.reload();
                                }

                            },
                            error: (a) => {
                                console.log(a);
                            },
                        });
                    }
                })

                console.log(data);
            });

            $("[name='id_pelanggan']").select2({
                ajax: {
                    url: "<?= site_url('pelanggan/search') ?>",
                    type: "POST",
                    dataType: 'JSON',
                    delay: 250,
                    data: function(params) {
                        return {
                            nama: params.term, // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                },
                allowClear: true,
                placeholder: 'Pilih Pelanggan',
            });

            $("[name='id_petugas']").select2({
                ajax: {
                    url: "<?= site_url('pengguna/search') ?>",
                    type: "POST",
                    dataType: 'JSON',
                    delay: 250,
                    data: function(params) {
                        return {
                            nama: params.term, // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                },
                allowClear: true,
                placeholder: 'Pilih Petugas',
            });

            function formatRupiah(angka, prefix) {
                var number_string = angka.toString().replaceAll('.', ''),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }

            $("#jumlah_uang").keyup(function() {
                let angka = $(this).val();
                $(this).val(formatRupiah(angka));
            });
        });
    </script>
</body>

</html>