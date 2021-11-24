! function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof module && module.exports ? e(require("jquery")) : e(jQuery)
}((function (g, a) {
    "use strict"

    const BASE_URL = "/back-end/menu-xyz"
    const E_FORM_FILTER = "#filter-xyz"
    const E_TABLE = "#table-xyz"
    const E_I_BORN_DATE = "#born-date"

    const E_BTN_SAVE = "#btn-save"
    const E_BTN_CANCEL = "#btn-cancel"
    const E_F_3 = "#filter3"
    const E_F_DATE_RANGE = "#date-range"
    let dt
    let dtDetail = []

    $(function () {
        moment.locale("id")

        initHandler()
    });

    const initHandler = () => {
        $(window).scroll(function () {
            var y = $(window).scrollTop();
            if (y > 0) {
                $("#header").addClass('shadow-sm');
            } else {
                $("#header").removeClass('shadow-sm');
            }
        });

        $(E_BTN_CANCEL).click(function (e) {
            e.preventDefault();

            $.confirm({
                title: 'Konfirmasi',
                content: 'Pilih [ok] untuk keluar dari halaman ini',
                type: 'orange',
                autoClose: 'kembali|4000',
                buttons: {
                    ok: {
                        btnClass: 'btn-orange',
                        keys: ['enter'],
                        action: function () {
                            window.close();
                        }
                    },
                    kembali: function () {
                        // DO NOTHING
                    },
                }
            });
        });

        $(E_I_BORN_DATE).daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            minYear: 1990,
            autoApply: true,
            locale: {
                format: "YYYY-MM-DD"
            }
        }, function (start, end, label) {
            $(E_I_BORN_DATE).val(start.format('YYYY-MM-DD'))
        })
    }
}))