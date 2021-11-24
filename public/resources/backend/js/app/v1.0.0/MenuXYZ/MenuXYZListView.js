! function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof module && module.exports ? e(require("jquery")) : e(jQuery)
}((function (g, a) {
    "use strict"

    const baseURL = "/back-end/menu-xyz"
    const E_FORM_FILTER = "#filter-xyz"
    const E_TABLE = "#table-xyz"
    const E_F_1 = "#filter1"
    const E_F_2 = "#filter2"
    const E_F_3 = "#filter3"
    const E_F_DATE_SINGLE = "#date-single"
    const E_F_DATE_RANGE = "#date-range"
    let dt
    let dtDetail = []

    $(function () {
        // biar tanggalnya jadi bahasa indonesia
        moment.locale("id")

        initToolbarTooltip()
        initDaterangeHandler()
        initDataTables()
        initClickHandler()
    })

    const initToolbarTooltip = () => {
        let tooltipOpt = {
            placement: 'top',
            trigger: 'hover',
        }

        $(".btn-action").tooltip(tooltipOpt)
    }

    const initDaterangeHandler = () => {
        $(E_F_DATE_SINGLE).daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            minYear: 1990,
            drops: 'up',
            autoApply: true,
            locale: {
                format: "YYYY-MM-DD"
            }
        }, function (start, end, label) {
            $(E_F_DATE_SINGLE).val(start.format('YYYY-MM-DD'))
        })

        $(E_F_DATE_RANGE).daterangepicker({
            autoUpdateInput: false,
            drops: 'up',
            autoApply: true,
            ranges: {
                'Hari ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 hari terakhir': [moment().subtract(6, 'days'), moment()],
                '30 hari terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
        }, function (start, end, label) {
            $(E_F_DATE_RANGE).val(start.format('YYYY-MM-DD') + ' s/d ' + end.format('YYYY-MM-DD'))
        })
    }

    const initDataTables = () => {
        let btnAct = `<button type="button" class="btn btn-xs btn-warning text-xs edit">Ubah</button>
            <button type="button" class="btn btn-xs btn-danger text-xs delete">Hapus</button>`

        dt = $(E_TABLE).DataTable({
            "rowId": "uuid",
            "ordering": false,
            "searching": false,
            "processing": true,
            "serverSide": true,
            "deferLoading": false,
            "ajax": {
                "url": `${baseURL}/list`,
                "type": "POST",
                "typeData": "JSON",
                "data": function (d) {
                    d.filter1 = $(E_F_1).val()
                    d.filter2 = $(E_F_2).val()
                    d.filter3 = $(E_F_3).val()
                    d.date_single = $(E_F_DATE_SINGLE).val()
                    d.date_range = $(E_F_DATE_RANGE).val()
                },
                "error": function (jqXHR, textStatus, errorThrown) {
                    toastr.error(`Terjadi kesalahan saat mengambil data. Err: ${errorThrown}`, textStatus)
                }
            },
            "columns": [
                {
                    "targets": -1,
                    "data": null,
                    "defaultContent": btnAct,
                    "className": "text-center"
                },
                {
                    "data": "name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "phone"
                },
                {
                    "data": "born_date",
                    "className": "text-center"
                },
                {
                    "class": "details-control",
                    "orderable": false,
                    "data": null,
                    "defaultContent": "",
                    "className": "text-center"
                },
            ],
        })

        $(`${E_TABLE} tbody`).on('click', 'button.edit', function () {
            let id = dt.row($(this).parents('tr')).data()['uuid']
            $.alert(`OTW edit ${id}`)
        })

        $(`${E_TABLE} tbody`).on("click", `button.delete`, function () {
            let rowData = dt.row($(this).parents('tr')).data()
            let id = rowData['uuid']
            let content = rowData['name']

            $.confirm({
                title: 'Konfirmasi',
                content: `Apakah anda yakin ingin menghapus ${content}?`,
                buttons: {
                    confirm: {
                        btnClass: 'btn-red',
                        keys: ['enter'],
                        action: function () {
                            dt.row(`#${id}`).remove().draw()
                            toastr.success(`${content} berhasil dihapus`, "Berhasil")
                        }
                    },
                    cancel: {
                        keys: ['esc'],
                        action: function () {
                            // DO NOTHING
                        }
                    },
                }
            })
        })

        $(`${E_TABLE} tbody`).on('click', 'tr td.details-control', function () {
            let tr = $(this).closest('tr')
            let row = dt.row(tr)
            let idx = $.inArray(tr.attr('id'), dtDetail)

            if (row.child.isShown()) {
                tr.removeClass('details')
                row.child.hide()

                // Remove from the 'open' array
                dtDetail.splice(idx, 1)
            } else {
                tr.addClass('details')
                row.child(formatDetail(row.data())).show()

                // Add to the 'open' array
                if (idx === -1) {
                    dtDetail.push(tr.attr('id'))
                }
            }
        })

        dt.on('draw', function () {
            $.each(dtDetail, function (i, id) {
                $('#' + id + ' td.details-control').trigger('click')
            })
        })
    }
    
    let formatDetail = (d) => {
        let html = `Alamat: ${d.address}<br>
            <img src="${d.avatar}" class="img-thumbnail" alt="${d.name}">`

        return html
    }

    const initClickHandler = () => {
        $(document).on("click", "#btn-search", function () {
            dt.ajax.reload()
        })

        $(document).on("click", "#btn-add", function () {
            window.open(`${baseURL}/form/n`)
        })

        $(document).on("click", "#btn-download-pdf", function () {
            $.alert("Asdfasdf " + $(this).data('id'))
        })

        $(document).on("click", "#btn-download-spreadsheet", function () {
            $.alert("Asdfasdf " + $(this).data('id'))
        })
    }
}))