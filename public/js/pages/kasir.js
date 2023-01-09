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
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                }).format(grand);
            };

            $(api.column(5).footer()).html(formatRupiah(grand));
        },
    });
});
