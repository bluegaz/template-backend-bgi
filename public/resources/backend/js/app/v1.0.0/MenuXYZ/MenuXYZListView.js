! function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof module && module.exports ? e(require("jquery")) : e(jQuery)
}((function (g, a) {
    "use strict"

    let dt
    const baseURL = "/back-end/menu-xyz"

    $(function () {
        // biar tanggalnya jadi bahasa indonesia
        moment.locale("id");

        initToolbarTooltip();
        initDaterangeHandler();
        initDataTables();

        $(document).on("click", "#table-xyz td .edit", function () {
            $.alert("Asdfasdf " + $(this).data('id'))
        })

        $(document).on("click", "#table-xyz td .delete", function () {
            let id = $(this).data('id')

            let content = $(`#${id} td:nth-child(3)`).text()

            $.confirm({
                title: 'Konfirmasi',
                content: `Apakah anda yakin ingin menghapus ${content}?`,
                buttons: {
                    confirm: {
                        btnClass: 'btn-red',
                        keys: ['enter'],
                        action: function () {
                            dt.row(`#${id}`).remove().draw();
                            toastr.success("Berhasil", `${content} berhasil dihapus`)
                        }
                    },
                    cancel: {
                        keys: ['esc'],
                        action: function () {
                            $.alert('Canceled!');
                        }
                    },
                }
            });
        })
    })

    const initToolbarTooltip = () => {
        let tooltipOpt = {
            placement: 'top',
            trigger: 'hover',
        }

        $(".btn-action").tooltip(tooltipOpt)
    }

    const initDaterangeHandler = () => {
        $('#tanggal_single').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            minYear: 1990,
            maxYear: parseInt(moment().format('YYYY'), 10),
            drops: 'up',
            autoApply: true,
            locale: {
                format: "YYYY-MM-DD"
            }
        }, function (start, end, label) {
            $('#tanggal_single').val(start.format('YYYY-MM-DD'));
        });

        $('#tanggal_range').daterangepicker({
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
            $('#tanggal_range').val(start.format('YYYY-MM-DD') + ' s/d ' + end.format('YYYY-MM-DD'));
        });
    }

    const initDataTables = () => {
        dt = $('#table-xyz').DataTable({
            "ordering": false,
            "searching": false,
            "processing": true,
            "serverSide": true,
            "ajax":`${baseURL}/list`
        })
    }
}))