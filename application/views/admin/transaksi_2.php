<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaksi</title>
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
                            <h1 class="m-0 text-dark">TRANSAKSI</h1>
                            <br>
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
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Barcode</label>
                                        <div class="form-inline">
                                            <select id="barcode" name="barcode" class="form-control form-control-sm select2 col-sm-12" focus>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Jumlah</label>
                                        <input type="number" class="form-control col-sm-12" placeholder="Jumlah" id="jumlah" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <button id="btn_tambah" class="btn btn-primary">TAMBAH</button>
                                        <button id="btn_bayar" class="btn btn-success">BAYAR</button>
                                        <button id="btn_batal" class="btn btn-danger">BATAL</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <span id="total_bayar" style="font-size: 64px; line-height: 1" class="text-danger">Rp. 0</span>
                            </div>
                            <div class="row mt-3">
                                <span id="no_nota" style="font-size: 18px; line-height: 1">NO NOTA : </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table w-100 table-bordered table-hover table-sm" id="tb_transaksi">

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <div class="modal fade" id="modal_bayar">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bayar</h5>
                        <button class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="text" class="form-control" name="tanggal" id="tanggal" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Uang</label>
                                <input placeholder="Jumlah Uang" type="text" class="form-control" name="jumlah_uang" id="jumlah_uang" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Pelanggan</label>
                                <select name="pelanggan" id="pelanggan" class="form-control select2"></select>
                            </div>
                            <div class="form-group">
                                <b>Total Bayar : </b> <b id="id_modal_bayar"></b>
                            </div>
                            <div class="form-group">
                                <b>Kembalian :</b> <span class="kembalian" id="kemblian"></span>
                            </div>
                            <button id="add" name="btn_transaksi" class="btn btn-success" type="button" disabled>Bayar</button>
                            <button id="cetak" name="btn_cetak" class="btn btn-success" type="button" disabled>Bayar Dan Cetak</button>
                            <button class="btn btn-danger" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                var bantu_harga = 0;
                var no_nota = nota();
                var status_cetak = false;

                $('#no_nota').html('NO NOTA : ' + no_nota);

                $("#btn_tambah").on('click', function() {
                    var jumlah = $('#jumlah').val();
                    if (jumlah == '' || jumlah == null) {
                        Swal.fire(
                            'Oops...',
                            'Harap isi jumlah produk',
                            'error'
                        )
                        return false;
                    }

                    if ($('#barcode').val() == '' || $('#barcode').val() == null) {
                        Swal.fire(
                            'Oops...',
                            'Harap pilih produk',
                            'error'
                        )
                        return false;
                    }
                    get_product();
                });

                $("#btn_bayar").on('click', function() {
                    load_harga();
                    if (bantu_harga == 0) {
                        Swal.fire(
                            'Oops...',
                            'Harap pilih produk',
                            'error'
                        );
                    } else {
                        $('#modal_bayar').modal('show');
                        $('#modal_bayar input[name=jumlah_uang]').focus();
                    }

                });

                $("#add").on('click', function() {
                    bayar();
                });

                $("#btn_batal").on('click', function() {
                    $.ajax({
                        url: "<?= site_url('transaksi/batal_transaksi') ?>",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            id: "",
                        },
                        success: (a) => {
                            if (a.code == 200) {
                                window.location.reload()
                            }
                        },
                        error: (a) => {
                            console.log(a);
                        },
                    });
                });

                $('#jumlah').on('keypress', function(e) {
                    if (e.which == 13) {
                        if (this.value == '' || this.value == null) {
                            Swal.fire(
                                'Oops...',
                                'Harap isi jumlah produk',
                                'error'
                            )
                            return false;
                        }

                        if ($('#barcode').val() == '' || $('#barcode').val() == null) {
                            Swal.fire(
                                'Oops...',
                                'Harap pilih produk',
                                'error'
                            )
                            return false;
                        }

                        get_product();
                    }
                });


                function get_product() {
                    $.ajax({
                        url: "<?= site_url('produk/get_produk') ?>",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            id: $("#barcode").val()
                        },
                        success: (data) => {
                            var harga = 0;
                            if (parseInt($('#jumlah').val()) > parseInt(data.jml_grosir)) {
                                harga = parseInt(data.harga_grosir);
                            } else {
                                harga = parseInt(data.harga_biasa);
                            }
                            var data_produk = {
                                'id_product': data.id,
                                'nama_product': data.nama,
                                'qty': $('#jumlah').val(),
                                'harga': harga,
                                'status_harga': data.jml_grosir,
                            };
                            add_to_cart(data_produk)
                        },
                        error: (a) => {
                            console.log(a);
                        },
                    });
                }

                function add_to_cart(data_produk) {
                    $.ajax({
                        url: "<?= site_url('transaksi/insert_to_chart') ?>",
                        type: "POST",
                        dataType: "JSON",
                        data: data_produk,
                        success: (a) => {
                            if (a.code == 200) {
                                load_harga();
                                table_data.ajax.reload();
                                $('#barcode').val(null).trigger('change');
                                $('#jumlah').val('');
                                // $('#barcode').select2('focus');
                                $('#id').prev('.select2-container').find('.select2-input').focus();
                            }

                        },
                        error: (a) => {
                            console.log(a);
                        },
                    });
                }

                $("[name='barcode']").select2({
                    ajax: {
                        url: "<?= site_url('produk/get_barcode') ?>",
                        type: "POST",
                        dataType: 'JSON',
                        delay: 250,
                        data: function(params) {
                            return {
                                barcode: params.term, // search term
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
                    placeholder: 'Pilih Product',
                });

                $("[name='pelanggan']").select2({
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

                var table_data = $('#tb_transaksi').DataTable({
                    ajax: {
                        url: "<?= site_url('transaksi/get_data_cart') ?>",
                        type: "POST",
                        data: function(d) {
                            d._token = "1"; // cuman buat dummy aja
                        },
                        beforeSend: function() {
                            console.log("ada");
                        },
                        complete: function(data) {
                            console.log(data);
                        }
                    },
                    dom: 'tir',
                    pageLength: 100,
                    ordering: false,
                    columns: [{
                            title: "No",
                            data: "rowid",
                            className: 'no-export',
                            ordering: false
                        },
                        {
                            title: "Nama",
                            data: "name"
                        },
                        {
                            title: "Harga",
                            data: "price",
                            render: function(data, type, row) {
                                return formatRupiah(data);
                            },
                        },
                        {
                            title: "Qty",
                            data: "qty"
                        },
                        {
                            title: "Total",
                            data: "subtotal",
                            render: function(data, type, row) {
                                return formatRupiah(data);
                            },
                        },
                        {
                            title: "Action",
                            data: "rowid",
                            render: function(data, type, row) {
                                return `<button class="btn btn-danger btn-sm btn-delete" type="button"><i class="fas fa-trash"></i></button>`;
                            },
                            className: 'no-export',
                            orderable: false,
                        }
                    ]
                });

                table_data.on('order.dt search.dt', function() {
                    table_data.column(0, {
                        search: 'applied',
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();

                $('#tb_transaksi tbody').on('click', 'button.btn-delete', function() {
                    var data = table_data.row($(this).parents('tr')).data();
                    $.ajax({
                        url: "<?= site_url('transaksi/delete_cart') ?>",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            rowid: data.rowid,
                        },
                        success: (a) => {
                            if (a.code == 200) {
                                load_harga();
                                table_data.ajax.reload();
                            }

                        },
                        error: (a) => {
                            console.log(a);
                        },
                    });
                });

                function load_harga() {
                    $.ajax({
                        url: "<?= site_url('transaksi/get_subtotal') ?>",
                        type: "POST",
                        dataType: "JSON",
                        data: {

                        },
                        success: (a) => {
                            if (a.code == 200) {
                                $('#total_bayar').html("Rp. " + formatRupiah(a.data));
                                $('#id_modal_bayar').html("Rp. " + formatRupiah(a.data));
                                bantu_harga = parseInt(a.data);
                            } else {
                                $('#total_bayar').html("Rp. 0");
                            }
                        },
                        error: (a) => {
                            console.log(a);
                        },
                    });
                }


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
                    kembalian();
                });


                function checkUang() {
                    let jumlah_uang = parseInt($('[name="jumlah_uang"').val().replaceAll('.', ''));
                    let = total_bayar = bantu_harga;
                    if (jumlah_uang !== "" && jumlah_uang >= total_bayar) {
                        $("#add").removeAttr("disabled");
                        $("#cetak").removeAttr("disabled");
                    } else {
                        $("#add").attr("disabled", "disabled");
                        $("#cetak").attr("disabled", "disabled");
                    }
                }

                function kembalian() {
                    let total = bantu_harga
                    let jumlah_uang = parseInt($('[name="jumlah_uang"').val().replaceAll('.', ''));
                    bantuKembali = jumlah_uang - total;
                    $(".kembalian").html(formatRupiah(jumlah_uang - total));
                    checkUang();
                }

                load_harga();

                function bayar() {
                    if ($('#tanggal').val() == '' || $('#jumlah_uang').val() == '') {
                        Swal.fire(
                            'Oops...',
                            'Harap isi data dengan benar',
                            'error'
                        )
                        return false;
                    }
                    $.ajax({
                        url: "<?= site_url('transaksi/bayar_transaksi') ?>",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            tanggal: $('#tanggal').val(),
                            jumlah_uang: parseInt($('#modal_bayar input[name=jumlah_uang]').val().replaceAll('.', '')),
                            pelanggan: $('#pelanggan').val(),
                            nota: no_nota,
                            total_bayar: bantu_harga,
                        },
                        success: (a) => {
                            if (a.code == 200) {
                                if (status_cetak != false) {
                                    print(a.id_transaksi);
                                }
                                Swal.fire("<h3>Kembalian</h3>", formatRupiah(parseInt($('[name="jumlah_uang"').val().replaceAll('.', '')) - bantu_harga), "success").then(
                                    () => window.location.reload()
                                );
                            }

                        },
                        error: (a) => {
                            console.log(a);
                        },
                    });
                }

                function nota() {
                    let jumlah = 9;
                    let bantuTanggal = moment().format("DMMYmm");
                    let hasil = "",
                        char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                        total = char.length;
                    for (var r = 0; r < jumlah; r++)
                        hasil += char.charAt(Math.floor(Math.random() * total));
                    return bantuTanggal + hasil;
                }

                $("#tanggal").datetimepicker({
                    format: "dd-mm-yyyy h:ii:ss",
                });

                $("#cetak").on('click', function() {
                    status_cetak = true;
                    bayar();
                });

                function print(id) {
                    status_cetak = false;
                    $.ajax({
                        url: '<?php echo site_url('cetak/struk/') ?>' + id,
                        type: "post",
                        success: () => {
                            window.location.reload();
                        },
                        error: (a) => {
                            console.log(a);
                        },
                    });
                }
            });
        </script>
</body>

</html>