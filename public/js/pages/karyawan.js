$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#table-karyawan").DataTable({
        ajax: "/d/karyawan",
        serverSide: true,
        aaSorting: [[0, "desc"]],
        columns: [
            { data: "check", name: "check" },
            { data: "name", name: "name" },
            { data: "nik", name: "nik" },
            { data: "umur", name: "umur" },
            { data: "telp", name: "telp" },
            { data: "alamat", name: "alamat" },
            { data: "status", name: "status" },
            { data: "action", name: "action" },
        ],
        columnDefs: [{ width: "5%", targets: 0 }],
    });

    $(".add").click(function (e) {
        e.preventDefault();
        $("#userModal").modal("show");
        $("#userModalLabel").html("Tambah Karyawan");
    });

    $(".batal").click(function (e) {
        e.preventDefault();
        $("#userModal").modal("hide");
        $("#name").val("");
        $("#email").val("");
        $("#nik").val("");
        $("#password").val("");
    });

    $(document).on("click", "#store", function (e) {
        e.preventDefault();
        let name = $("#name").val();
        let email = $("#email").val();
        let nik = $("#nik").val();
        let password = $("#password").val();

        $.ajax({
            url: "/d/karyawan/add",
            type: "POST",
            dataType: "json",
            data: {
                name: name,
                email: email,
                nik: nik,
                password: password,
            },
            success: function (res) {
                if (res.errors) {
                    console.log(res.errors);
                    $.each(res.errors, function (key, val) {
                        $("#mes").append(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                val +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                        );
                    });
                    $("#userModal").modal("hide");
                } else {
                    $("#mes").append(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil Menambahkan Karyawan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                    );
                    setTimeout(() => {
                        $("#userModal").modal("hide");
                        $("#name").val("");
                        $("#email").val("");
                        $("#nik").val("");
                        $("#password").val("");
                        $("#userModal").modal("hide");
                        table.draw();
                        $(".alert").addClass("d-none");
                    }, 500);
                }
            },
            error: function (errors) {
                console.log(errors);
            },
        });
    });

    $(document).on("click", ".ban", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        Swal.fire({
            title: "Warning?",
            text: "Anda yakin ingin menonaktifkan akun karyawan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Nonaktifkan!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/d/karyawan/ban/" + id,
                    type: "PUT",
                    data: { id: id },
                    success: function (res) {
                        alertify.set("notifier", "position", "top-center");
                        alertify.success(
                            "Berhasil Menonaktifkan Akun Karyawan !"
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

    $(document).on("click", ".active", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        $.ajax({
            url: "/d/karyawan/" + id,
            type: "GET",
            success: function (res) {
                $("#activateUser").modal("show");
                $("#id").val(res.id);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", ".activate", function (e) {
        e.preventDefault();
        let id = $("#id").val();
        let password = $("#password").val();
        if (password.length == "") {
            $("#mes").append(
                '<div class="alert alert-success alert-dismissible fade show" role="alert">Silahkan masukan password baru untuk mengaktifkan karyawan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            );
            $("#activateUser").modal("hide");
        } else {
            $.ajax({
                url: "/d/karyawan/aktif/" + id,
                type: "PUT",
                data: { id: id, password: password },
                success: function (res) {
                    alertify.set("notifier", "position", "top-center");
                    alertify.success("Berhasil Mengaktifkan Akun Karyawan !");
                    table.draw();
                    $("#activateUser").modal("hide");
                },
                error: function (err) {
                    console.log(err);
                },
            });
        }
    });

    $(document).on("click", ".delete", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        Swal.fire({
            title: "Warning?",
            text: "Anda yakin ingin menghapus akun karyawan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/d/karyawan/" + id,
                    type: "DELETE",
                    data: { id: id },
                    success: function (res) {
                        alertify.set("notifier", "position", "top-center");
                        alertify.success("Berhasil Menghapus Akun Karyawan !");
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
