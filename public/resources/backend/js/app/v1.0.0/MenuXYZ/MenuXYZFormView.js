! function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof module && module.exports ? e(require("jquery")) : e(jQuery)
}((function (g, a) {
    "use strict"

    const BASE_URL = '/back-end/menu-xyz'
    const FORM_NAME = 'Form User'

    const E_FORM_USER = '#form-user'
    const E_BTN_SAVE = '#btn-save'
    const E_H_ACT = '#act'
    const E_H_ID_USER = '#id-user'

    const E_I_STATUS = '#is_active'
    const E_I_PASSWORD = '#password'
    const E_PASSWORD_GROUP = '#password-group'
    const E_H_IS_ACTIVE_SELECTED = '#is-active-selected'

    const E_I_BORN_DATE = '#born-date'

    let act
    let idUser
    let dt
    let dtDetail = []

    $(function () {
        $(".navbar-brand").html(FORM_NAME)
        document.title = `${FORM_NAME} | ${BASE_TITLE}`
        
        moment.locale("id")
        
        act = $(E_H_ACT).val()

        if (act == 'e') {
            $(E_I_PASSWORD).prop("disabled", true)
            $(E_PASSWORD_GROUP).hide()
            $(E_I_STATUS).val($(E_H_IS_ACTIVE_SELECTED).val())
            idUser = $(E_H_ID_USER).val()
        }

        initHandler()
    })

    const initHandler = () => {
        $(window).scroll(function () {
            var y = $(window).scrollTop()
            if (y > 0) {
                $("#header").addClass('shadow-sm')
            } else {
                $("#header").removeClass('shadow-sm')
            }
        })

        $(E_BTN_SAVE).click(function (e) {
            e.preventDefault()

            $(E_FORM_USER).submit()
        })

        $(E_FORM_USER).submit(function (e) {
            e.preventDefault()

            let endPoint = act == 'e' ? `update/${idUser}` : 'new'

            let data = new FormData(this)

            $.ajax({
                url: `${BASE_URL}/${endPoint}`,
                type: "POST",
                data: data,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.message != null) {
                        showNotification(NOTIF_WARNING, res.message)
                        return
                    }

                    showFormSuccessDialog(act)

                },
                error: function (xhr, textStatus, errorThrown) {
                    showNotification(NOTIF_ERROR, errorThrown)
                }
            })
        })

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