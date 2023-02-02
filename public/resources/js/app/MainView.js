! function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof module && module.exports ? e(require("jquery")) : e(jQuery)
}((function (g, a) {
    "use strict"

    const APP_NAME = 'Dokumen'
    const COMPANY = 'PT. Blue Gas Indonesia'
    let baseTitlePage = "BGI App"
    const activeIframe = ".iframe-mode .tab-content .tab-pane.fade.active.show iframe"

    $(function () {
        baseTitlePage = `${APP_NAME} - ${COMPANY}`
        document.title = baseTitlePage

        $("#btn-refresh-iframe").click(function (e) {
            e.preventDefault();

            let currentSrc = $(activeIframe).attr('src')
            $(activeIframe).attr('src', currentSrc)
        })
    })

}))