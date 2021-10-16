
let isCetak = false,
	produk = [],
	transaksi = $("#transaksi").DataTable({
		responsive: true,
		lengthChange: false,
		searching: false,
		scrollX: true,
	});

let bantuHarga = 0;
let bantuKembali = 0;
var inputJumlah = document.getElementById("jumlah");
inputJumlah.addEventListener("keyup", function (event) {
	if (event.keyCode === 13) {
		event.preventDefault();
		document.getElementById("tambah").click();
	}
});

function reloadTable() {
	transaksi.ajax.reload();
}

function nota(jumlah) {
	let bantuTanggal = moment().format("DMMYmm");
	let hasil = "",
		char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
		total = char.length;
	for (var r = 0; r < jumlah; r++)
		hasil += char.charAt(Math.floor(Math.random() * total));
	return bantuTanggal + hasil;
}

function getNama() {
	$.ajax({
		url: produkGetNamaUrl,
		type: "post",
		dataType: "json",
		data: {
			id: $("#barcode").val(),
		},
		success: (res) => {
			console.log(res.nama);
			$("#nama_produk").html(res.nama);
			inputJumlah.focus();
			checkEmpty();
		},
		error: (err) => {
			console.log(err);
		},
	});
}

function getHarga() {
	$.ajax({
		url: produkGetharga,
		type: "post",
		dataType: "json",
		data: {
			id: $("#barcode").val(),
		},
		success: (res) => {
			let barcode = $("#barcode").val(),
				nama_produk = res.nama,
				jumlah = parseInt($("#jumlah").val()),
				harga = 0,
				sts = 0,
				total = bantuHarga;

			if (jumlah >= res.jml_grosir) {
				harga = parseInt(res.harga_grosir);
				sts = 1;
			} else {
				harga = parseInt(res.harga_biasa);
				sts = 0;
			}

			let subTotal = jumlah * harga;

			produk.push({
				id: barcode,
				terjual: jumlah,
				harga: sts,
			});

			transaksi.row
				.add([
					nama_produk,
					harga,
					jumlah,
					subTotal,
					`<button name="${barcode}" class="btn btn-sm btn-danger" onclick="remove('${barcode}')">Hapus</btn>`,
				])
				.draw();
			bantuHarga = total + subTotal;
			$('#barcode').click();
			console.log("click button barcode");
			$("#total").html(formatRupiah(bantuHarga));
			$("#jumlah").val("");
			$("#tambah").attr("disabled", "disabled");
			$("#bayar").removeAttr("disabled");
		},
	});
}

function bayarCetak() {
	isCetak = true;
	console.log("id pelanggan = " + $("#pelanggan").val());
}

function bayar() {
	isCetak = false;
}

function checkEmpty() {
	console.log(produk);
	let barcode = $("#barcode").val(),
		jumlah = $("#jumlah").val();
	if (barcode !== "" && jumlah !== "" && parseInt(jumlah) >= 1) {
		$("#tambah").removeAttr("disabled");
	} else {
		$("#tambah").attr("disabled", "disabled");
	}
}

function checkUang() {
	let jumlah_uang = $('[name="jumlah_uang"').val(),
		total_bayar = bantuHarga;
	console.log(total_bayar);
	console.log(jumlah_uang);
	if (jumlah_uang !== "" && jumlah_uang >= total_bayar) {
		$("#add").removeAttr("disabled");
		$("#cetak").removeAttr("disabled");
	} else {
		$("#add").attr("disabled", "disabled");
		$("#cetak").attr("disabled", "disabled");
	}
}

function remove(nama) {
	let data = transaksi.row($("[name=" + nama + "]").closest("tr")).data(),
		harga = data[1],
		qty = data[2],
		total = bantuHarga;
	akhir = total - qty * harga;
	bantuHarga = akhir;
	$("#total").html(formatRupiah(akhir));
	transaksi
		.row($("[name=" + nama + "]").closest("tr"))
		.remove()
		.draw();
	$("#tambah").attr("disabled", "disabled");
	if (akhir < 1) {
		$("#bayar").attr("disabled", "disabled");
	}
}

function add() {
	$.ajax({
		url: addUrl,
		type: "post",
		dataType: "json",
		data: {
			produk: JSON.stringify(produk),
			tanggal: $("#tanggal").val(),
			total_bayar: bantuHarga,
			jumlah_uang: $('[name="jumlah_uang"]').val(),
			pelanggan: $("#pelanggan").val(),
			nota: $("#nota").html(),
		},
		success: (res) => {
			bantuKembali = "<h1>" + formatRupiah(bantuKembali) + "</h1>";
			if (isCetak) {
				Swal.fire("<h1>Kembalian</h1>", bantuKembali, "success").then(() =>
					print(cetakUrl, res)
				);
			} else {
				Swal.fire("Kemba<h1>Kembalian</h1>lian", bantuKembali, "success").then(
					() => window.location.reload()
				);
			}
		},
		error: (err) => {
			console.log(err);
		},
	});
}

function print(cetakUrl, id) {
	$.ajax({
		url: cetakUrl + id,
		type: "post",
		success: () => {
			window.location.reload();
		},
		error: (a) => {
			console.log(a);
		},
	});
}

function kembalian() {
	let total = bantuHarga,
		jumlah_uang = $('[name="jumlah_uang"').val();
	bantuKembali = jumlah_uang - total;
	$(".kembalian").html(formatRupiah(jumlah_uang - total));
	checkUang();
}

$("#barcode").select2({
	placeholder: "Barcode",
	ajax: {
		url: getBarcodeUrl,
		type: "post",
		dataType: "json",
		data: (params) => ({
			barcode: params.term,
		}),
		processResults: (res) => ({
			results: res,
		}),
		cache: true,
	},
});

$("#pelanggan").select2({
	placeholder: "Pelanggan",
	ajax: {
		url: pelangganSearchUrl,
		type: "post",
		dataType: "json",
		data: (params) => ({
			pelanggan: params.term,
		}),
		processResults: (res) => ({
			results: res,
		}),
		cache: true,
	},
});
$("#tanggal").datetimepicker({
	format: "dd-mm-yyyy h:ii:ss",
});
$(".modal").on("hidden.bs.modal", () => {
	$("#form")[0].reset();
	$("#form").validate().resetForm();
});
$(".modal").on("show.bs.modal", () => {
	let now = moment().format("D-MM-Y H:mm:ss"),
		total = bantuHarga,
		jumlah_uang = $('[name="jumlah_uang"').val();
	$("#tanggal").val(now),
		$(".total_bayar").html(formatRupiah(total)),
		$(".kembalian").html(Math.max(jumlah_uang - total, 0));
});
$("#form").validate({
	errorElement: "span",
	errorPlacement: (err, el) => {
		err.addClass("invalid-feedback"), el.closest(".form-group").append(err);
	},
	submitHandler: () => {
		add();
	},
});
$("#nota").html(nota(5));

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
