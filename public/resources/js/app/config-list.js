$.extend(true, $.fn.dataTable.defaults, {
    "ordering": false,
    "searching": false,
    "processing": true,
    "serverSide": true,
    "deferLoading": false,
    "language": {
        "decimal": ",",
        "emptyTable": "Tidak ada data untuk ditampilkan",
        "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        "infoEmpty": "Menampilkan 0 - 0 dari 0 data",
        "thousands": ".",
        "lengthMenu": "Menampilkan _MENU_ data",
        "loadingRecords": "Loading...",
        "processing": "Processing...",
        "paginate": {
            "first": "Awal",
            "last": "Akhir",
            "next": "»",
            "previous": "«"
        },
    }
})

function deleteRow(url, id) {
    let ajax = $.ajax({
        type: "DELETE",
        url: `${url}/${id}`,
        dataType: "JSON",
        error: function (jqxhr, textStatus, errorThrown) {
            showNotification("error", errorThrown)
        }
    })

    return ajax;
}