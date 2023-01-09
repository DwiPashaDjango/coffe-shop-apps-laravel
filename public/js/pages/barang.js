$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#kategori_id").select2({
        width: "100%",
        ajax: {
            url: "/d/kategori/json",
            type: "post",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                };
            },
            processResults: function (response) {
                return {
                    results: response,
                };
            },
            cache: true,
        },
        placeholder: "-- Pilih --",
    });

    var table = $("#table-barang").DataTable({
        ajax: "/d/barang",
        serverSide: true,
        aaSorting: [[0, "desc"]],
        columns: [
            { data: "action", name: "action" },
            { data: "kode", name: "kode" },
            { data: "nm_barang", name: "nm_barang" },
            {
                data: "kategori",
                name: "kategori.nm_kategori",
            },
            { data: "jumlah", name: "jumlah" },
            { data: "harga", name: "harga" },
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

            qty = api
                .column(4, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            harga = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            let sum = harga * qty;

            const formatRupiah = (barang) => {
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(barang);
            };

            $(api.column(5).footer()).html(formatRupiah(sum));
        },
    });

    $(document).on("click", ".add", function (e) {
        e.preventDefault();
        $("#barangModal").modal("show");
        $("#barangModalLabel").html("Tambah Makanan / Minuman");
        $("#tmb").removeClass("update").addClass("store");
        $("#form-barang")[0].reset();
        $("#tmb").html("Tambah");
    });

    $(document).on("click", ".cancel", function (e) {
        e.preventDefault();
        $("#barangModal").modal("hide");
        $("#form-barang")[0].reset();
        $("#kategori_id")[0].reset();
    });

    $(document).on("click", ".store", function (e) {
        e.preventDefault();
        let nm_barang = $("#nm_barang").val();
        let kategori_id = $("#kategori_id").val();
        let jumlah = $("#jumlah").val();
        let harga = $("#harga").val();

        $.ajax({
            url: "/d/barang",
            type: "POST",
            data: {
                nm_barang: nm_barang,
                kategori_id: kategori_id,
                jumlah: jumlah,
                harga: harga,
            },
            dataType: "json",
            success: function (res) {
                if (res.errors) {
                    $.each(res.errors, function (key, val) {
                        $("#err").append(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                val +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                        );
                    });
                    $("#barangModal").modal("hide");
                } else {
                    $("#barangModal").modal("hide");
                    $("#err").append(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil menabhkan menu !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                    );
                    table.draw();
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", ".editBarang", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        $.ajax({
            url: "/d/barang/" + id,
            type: "GET",
            success: function (res) {
                console.log(res);
                $("#barangModal").modal("show");
                $("#barangModalLabel").html(res.data.nm_barang);
                $("#id").val(res.data.id);
                $("#nm_barang").val(res.data.nm_barang);
                $("#kategori_id").val(res.data.kategori_id);
                $("#jumlah").val(res.data.jumlah);
                $("#harga").val(res.data.harga);
                $("#tmb").removeClass("store").addClass("update");
                $("#tmb").html("Edit");
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", ".update", function (e) {
        e.preventDefault();
        let id = $("#id").val();
        let nm_barang = $("#nm_barang").val();
        let kategori_id = $("#kategori_id").val();
        let jumlah = $("#jumlah").val();
        let harga = $("#harga").val();
        $.ajax({
            url: "/d/barang/" + id,
            type: "PUT",
            data: {
                nm_barang: nm_barang,
                kategori_id: kategori_id,
                jumlah: jumlah,
                harga: harga,
            },
            success: function (res) {
                $("#barangModal").modal("hide");
                $("#err").append(
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil mengupdate menu !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                );
                table.draw();
            },
            error: function (err) {
                $("#barangModal").modal("hide");
                $("#err").append(
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">Gagal mengupdate menu silahkan cek apakah ada kolom yang belum terisi !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                );
            },
        });
    });

    $(document).on("click", ".deleteBarang", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        Swal.fire({
            title: "Warning",
            text: "Anda yakin ingin menghapus menu ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/d/barang/" + id,
                    type: "DELETE",
                    success: function (res) {
                        $("#err").append(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil menghapus menu !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                        );
                        table.draw();
                    },
                    error: function (err) {
                        console.log(err);
                    },
                });
            }
        });
    });
});
