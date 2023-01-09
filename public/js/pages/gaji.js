$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#table-gaji").DataTable({
        ajax: "/d/gaji/karyawan",
        serverSide: true,
        aaSorting: [[0, "desc"]],
        columns: [
            { data: "action" },
            { data: "tgl_keluar" },
            { data: "user.name" },
            { data: "user.nik" },
            { data: "user.email" },
            { data: "user.telp" },
            { data: "gaji" },
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

            gaji = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            const formatRupiah = (gaji) => {
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(gaji);
            };

            $(api.column(6).footer()).html(formatRupiah(gaji));
        },
    });

    var tablek = $("#table-gaji-role").DataTable({
        ajax: "/d/gaji/karyawan/check",
        serverSide: true,
        aaSorting: [[0, "desc"]],
        bPaginate: false,
        searching: false,
        info: false,
        columns: [
            { data: "action" },
            { data: "tgl_keluar" },
            { data: "user.name" },
            { data: "user.nik" },
            { data: "user.email" },
            { data: "user.telp" },
            { data: "gaji" },
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

            gaji = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            const formatRupiah = (gaji) => {
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(gaji);
            };

            $(api.column(6).footer()).html(formatRupiah(gaji));
        },
    });

    $(document).on("click", ".add", function (e) {
        e.preventDefault();
        $("#gajiModal").modal("show");
        $("#gajiModalLabel").html("Tambah Data Gaji Karyawan");
        $("#btn").html("Simpan");
        $("#btn").addClass("store").removeClass("update");
        $("#users_id").val("-- Pilih --");
        $("#gaji").val("");
    });

    $(document).on("click", ".store", function (e) {
        e.preventDefault();
        let users_id = $("#users_id").val();
        let gaji = $("#gaji").val();

        if (users_id == "-- Pilih --") {
            $("#err").append(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">Pilih salah satu karyawan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            );
            $("#gajiModal").modal("hide");
        } else {
            $.ajax({
                url: "/d/gaji/karyawan",
                type: "POST",
                data: {
                    users_id: users_id,
                    gaji: gaji,
                },
                dataType: "json",
                success: function (res) {
                    if (res.errors) {
                        console.log(res.errors);
                        $.each(res.errors, function (val) {
                            $("#err").append(
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                    val +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                            );
                        });
                        $("#gajiModal").modal("hide");
                    } else {
                        console.log(res);
                        $("#err").append(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil menyimpan data gaji !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                        );
                        $("#gajiModal").modal("hide");
                        $("#users_id").val("");
                        $("#gaji").val("");
                        table.draw();
                    }
                },
                error: function (err) {
                    console.log(err);
                },
            });
        }
    });

    $(document).on("click", ".editGaji", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        $.ajax({
            url: "/d/gaji/karyawan/" + id,
            type: "GET",
            success: function (res) {
                console.log(res);
                $("#gajiModal").modal("show");
                $("#gajiModalLabel").html("Ubah Data Gaji Karyawan");
                $("#btn").html("Ubah");
                $("#btn").addClass("update").removeClass("store");

                $("#id").val(res.data.id);
                $("#users_id").val(res.data.users_id);
                $("#gaji").val(res.data.gaji);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", ".update", function (e) {
        e.preventDefault();
        let id = $("#id").val();
        let users_id = $("#users_id").val();
        let gaji = $("#gaji").val();

        $.ajax({
            url: "/d/gaji/karyawan/" + id,
            type: "PUT",
            data: {
                id: id,
                users_id: users_id,
                gaji: gaji,
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
                    $("#gajiModal").modal("hide");
                } else {
                    $("#err").append(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil merubah data gaji !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                    );
                    $("#gajiModal").modal("hide");
                    $("#users_id").val("");
                    $("#gaji").val("");
                    table.draw();
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", ".printGaji", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        window.open("/d/gaji/karyawan/print/" + id);
    });

    $(document).on("click", ".deleteGaji", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        Swal.fire({
            title: "Warning?",
            text: "Anda yakin ingin menghapus data ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/d/gaji/karyawan/" + id,
                    type: "DELETE",
                    success: function (res) {
                        $("#err").append(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil menghapus data gaji !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
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
