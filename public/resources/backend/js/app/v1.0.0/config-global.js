const APP_NAME = 'Dokumen'
const COMPANY = 'PT. Blue Gas Indonesia'
const BASE_TITLE = `${APP_NAME} - ${COMPANY}`

const NOTIF_INFO = "info"
const NOTIF_WARNING = "warning"
const NOTIF_SUCCESS = "success"
const NOTIF_ERROR = "error"

const PAGE = {
    image: "/resources/backend/img/loading-page.svg",
    background: "rgba(0, 0, 0, 0.5)",
    imageAnimation: "",
    imageColor: ""
};

const INPUT = {
    image: "/resources/backend/img/loading-page.svg",
    background: "rgba(0, 0, 0, 0.5)",
    imageAnimation: "",
    imageColor: ""
};

const ELEMENT = {
    image: "/resources/backend/img/loading-page.svg",
    background: "rgba(0, 0, 0, 0.5)",
    imageAnimation: "",
    imageColor: ""
};

const BUTTON = {
    image: "/resources/backend/img/loading-page.svg",
    background: "rgba(0, 0, 0, 0.5)",
    imageAnimation: "",
    imageColor: ""
};

const showNotification = (type, message) => {
    switch (type) {
        case "warning":
            toastr.warning(message, "Perhatian")
            break;
        case "error":
            toastr.error(`Terjadi kesalahan server. Err: ${message}`, "Error")
            break;
        case "success":
            toastr.success(message, "Berhasil")
            break;
        case "info":
            toastr.info(message, "Informasi")
            break;
    }
}