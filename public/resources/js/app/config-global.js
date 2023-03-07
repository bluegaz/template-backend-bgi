const APP_NAME = 'Title'
const COMPANY = 'PT. Blue Gas Indonesia'
const BASE_TITLE = `${APP_NAME} - ${COMPANY}`

const NOTIF_INFO = "info"
const NOTIF_WARNING = "warning"
const NOTIF_SUCCESS = "success"
const NOTIF_ERROR = "error"

const OVERLAY_PAGE = {
    image: "/resources/img/loading-page.svg",
    background: "rgba(0, 0, 0, 0.5)",
    imageAnimation: "",
    imageColor: ""
};

$.LoadingOverlaySetup({
    background: "rgba(0, 0, 0, 0.6)",
    image: "/resources/img/loading-general.svg",
    imageAnimation: "",
    imageColor: ""
});

const flashNotification = (type, message) => {
    switch (type) {
        case "warning":
            toastr.warning(message, "Perhatian")
            break;
        case "success":
            toastr.success(message, "Berhasil")
            break;
        case "info":
            toastr.info(message, "Informasi")
            break;
    }
}