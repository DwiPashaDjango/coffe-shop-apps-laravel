$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#table-kasir").DataTable({
        ajax: "/d/transaksi",
        serverSide: true,
        aaSorting: [[0, "desc"]],
        bPaginate: false,
        info: false,
        searching: false,
        columns: [
            { data: "action" },
            { data: "kode" },
            { data: "nm_pembeli" },
            { data: "barang.nm_barang" },
            { data: "qty" },
            { data: "total" },
        ],
        columnDefs: [{ width: "5%", targets: 0 }],
        footerCallback: function (row, data) {
            var api = this.api();

            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };

            grand = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            const formatRupiah = (grand) => {
                return new Intl.NumberFormat("id-ID", {
                    // style: "currency",
                    // currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(grand);
            };

            $(api.column(5).footer()).html(formatRupiah(grand));
        },
    });

    $(document).on("click", ".pesan", function (e) {
        e.preventDefault();
        let nm_pembeli = $("#nm_pembeli").val();
        let barang_id = $("#barang_id").val();
        if (barang_id == "-- Pilih --") {
            $("#err").append(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">Pilih salah satu menu !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            );
        } else {
            $.ajax({
                url: "/d/transaksi",
                type: "POST",
                data: {
                    nm_pembeli: nm_pembeli,
                    barang_id: barang_id,
                },
                dataType: "json",
                success: function (res) {
                    if (res.errors) {
                        $.each(res.errors, function (key, val) {
                            console.log(res.errors);
                            $("#err").append(
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                    val[0] +
                                    '!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                            );
                        });
                    } else {
                        $("#nm_pembeli").val("");
                        $("#barang_id").val("-- Pilih --");
                        table.draw();
                    }
                },
                error: function (err) {
                    console.log(err);
                },
            });
        }
    });

    $(document).on("click", ".tambah", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        let qty = $("qty").val();
        $.ajax({
            url: "/d/transaksi/tambah/" + id,
            type: "PUT",
            data: { id: id, qty: qty },
            success: function (res) {
                console.log(res);
                table.draw();
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", ".kurang", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        let qty = $("qty").val();
        if (qty <= 1) {
            alert("Qty Tidak Bisa Di Kurangi");
        } else {
            $.ajax({
                url: "/d/transaksi/kurang/" + id,
                type: "PUT",
                data: { id: id, qty: qty },
                success: function (res) {
                    if (res.errors) {
                        $("#err").append(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                res.errors +
                                '!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                        );
                    } else {
                        table.draw();
                    }
                },
                error: function (err) {
                    console.log(err);
                },
            });
        }
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
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

    var rupiah = document.getElementById("uang");
    rupiah.addEventListener("keyup", function (e) {
        rupiah.value = formatRupiah(this.value);
    });

    $(document).on("click", ".bayar", function (e) {
        e.preventDefault();
        let uang = $("#uang").val();
        let hit = $("#grand").html();
        if (uang < hit) {
            $("#err").append(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">Jumlah uang kurang dari total pembayaran !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            );
        } else {
            let grand = uang - hit;
            $("#err").append(
                '<div class="alert alert-success alert-dismissible fade show" role="alert">Jumlah uang kembalian ' +
                    grand +
                    '.000 !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            );
            $("#uang").val("");
        }
    });

    $(document).on("click", ".res", function (e) {
        e.preventDefault();
        $("#uang").val("");
    });
});
