$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(".edit").html("save");

    $(document).on("click", ".edit", function (e) {
        e.preventDefault();
        $(".edit").html("processing");
        let id = $(this).data("id");
        let name = $("#name").val();
        let nik = $("#nik").val();
        let telp = $("#telp").val();
        let umur = $("#umur").val();
        let alamat = $("#alamat").val();
        Swal.fire({
            icon: "info",
            title: "Info?",
            text: "Anda Yakin Ingin Mengupdate Data Profile Anda!",
            showCancelButton: true,
            confirmButtonText: "Save",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/v/edit/profile/" + id,
                    type: "PUT",
                    dataType: "json",
                    data: {
                        name: name,
                        nik: nik,
                        telp: telp,
                        umur: umur,
                        alamat: alamat,
                    },
                    success: function (res) {
                        $(".edit").html("Saved");
                        $("#err").append(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil Mengupdate Data Profile Anda !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                        );
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                        console.log(res);
                    },
                    error: function (err) {
                        console.log(err);
                        $("#err").append(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">Gagal Mengupdate Data Profile Anda !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                        );
                    },
                });
            }
        });
    });

    $(document).on("click", "#btnPrPasswordEditSave", function (e) {
        e.preventDefault();
        let current_password = $("current_password").val();
        let new_password = $("new_password").val();
        let new_confirm_password = $("new_confirm_password").val();
        $.ajax({
            url: "/change/password",
            type: "POST",
            data: {
                current_password: current_password,
                new_password: new_password,
                new_confirm_password: new_confirm_password,
            },
            success: function (res) {
                console.log(res);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });
});
