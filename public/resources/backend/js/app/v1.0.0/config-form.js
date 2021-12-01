const showFormSuccessDialog = (act) => {
    let opt = {};

    switch (act) {
        case 'n':
            opt = {
                content: 'Data berhasil disimpan. Pilih [YA] atau tekan [Enter] jika ingin menambah data lainnya',
                buttons: {
                    ya: {
                        btnClass: 'btn-green',
                        keys: ['enter'],
                        action: function () {
                            location.reload()
                        }
                    },
                    keluar: function () {
                        window.close()
                    },
                }
            }
            break;
        case 'e':
            opt = {
                content: 'Perubahan berhasil disimpan',
                buttons: {
                    keluar: function () {
                        window.close()
                    },
                }
            }
            break;
    }

    let baseOPT = {
        title: 'Berhasil',
        type: 'green',
        autoClose: 'keluar|10000',
    }

    $.confirm({...baseOPT, ...opt})
}

$("#btn-cancel").click(function (e) {
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