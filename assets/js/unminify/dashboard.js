// console.log(stok_hariUrl);
function getDays() {
	let now = new Date(),
		bulan = now.getMonth() + 1,
		tahun = now.getFullYear(),
		hari = new Date(tahun, bulan, 0).getDate(),
		totalHari = [];
	for (var o = 0; o <= hari; o++) {
		totalHari.push(o);
	}
	return totalHari;
}

$.ajax({
	url: transaksi_hariUrl,
	type: "get",
	dataType: "json",
	success: (res) => {
		console.log(res);
		$("#transaksi_hari").html(res.total);
	},
});

$.ajax({
	url: transaksi_terakhirUrl,
	type: "get",
	dataType: "json",
	success: (res) => {
		// console.log(res.pengeluaran);
		$("#transaksi_terakhir").html("Rp. " + formatRupiah(res.pengeluaran));
	},
});

function formatRupiah(angka, prefix) {
	var number_string = angka.toString().replaceAll(".", ""),
		split = number_string.split(","),
		sisa = split[0].length % 3,
		rupiah = split[0].substr(0, sisa),
		ribuan = split[0].substr(sisa).match(/\d{3}/gi);

	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if (ribuan) {
		separator = sisa ? "." : "";
		rupiah += separator + ribuan.join(".");
	}

	rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
	return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}
// $.ajax( {
//     url:stok_hariUrl,
//     type:"get",
//     dataType:"json",
//     success:res=> {
//         console.log(res);
//         $("#stok_hari").html(res.)
//     }
// });
