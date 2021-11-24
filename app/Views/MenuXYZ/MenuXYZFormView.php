<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Menu XYZ</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <?= link_tag(RES_PLUGIN . '/fontawesome-free/css/all.min.css') ?>
    <?= link_tag(RES_PLUGIN . '/daterangepicker/daterangepicker.css') ?>
    <?= link_tag(RES_PLUGIN . '/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>
    <?= link_tag(RES_PLUGIN . '/datatables-responsive/css/responsive.bootstrap4.min.css') ?>
    <?= link_tag(RES_PLUGIN . '/jquery-confirm/jquery-confirm.min.css') ?>
    <?= link_tag(RES_PLUGIN . '/toastr/toastr.min.css') ?>

    <?= link_tag(RES_BACKEND . '/css/adminlte.min.css') ?>
</head>

<body class="text-sm content-iframe bg-light">
    <nav id="header" class="navbar navbar-expand-md sticky-top navbar-light bg-white">
        <div class="container-lg">
            <span class="navbar-brand">Form XYZ</span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a id="btn-save" class="nav-link" href="#"><i class="fas fa-save"></i> Simpan</a>
                    </li>
                    <li class="nav-item">
                        <a id="btn-cancel" class="nav-link" href="#"><i class="fas fa-times"></i> Batal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-lg">
        <!-- Main content -->
        <section class="content mt-lg-3 mt-2">
            <div class="container-fluid">
                <?= form_open('', "id='form'", ['act' => $act]) ?>
                <input type="hidden" name="id" value="<?= @$uuid ?>">
                <div class="card-deck mb-lg-3 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input id="name" name="name" class="form-control form-control-sm" type="text" autocomplete="off" placeholder="Nama" value="<?= @$name ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" name="email" class="form-control form-control-sm" type="text" autocomplete="off" placeholder="Email" value="<?= @$email ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone-number">Nomor Telp.</label>
                                <input id="phone-number" name="phone_number" class="form-control form-control-sm" type="text" autocomplete="off" value="<?= @$phone_number ?>" placeholder="Nomor Telp." required>
                            </div>
                            <div class="form-group">
                                <label for="born-date">Tanggal Lahir</label>
                                <input id="born-date" name="born_date" class="form-control form-control-sm" type="text" autocomplete="off" value="<?= @$born_date ?>" placeholder="Tanggal Lahir" required readonly>
                                <small class="form-text text-muted mt-0">yyyy-mm-dd</small>
                            </div>
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea id="address" name="address" class="form-control form-control-sm" rows="3" placeholder="Alamat" required><?= @$address ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="avatar">Upload atau perbaharui Avatar</label>
                                <input id="avatar" name="avatar" type="file" class="form-control-file form-control-file-sm" required>
                            </div>

                            File yang sudah terupload: <br>
                            <a href="<?=@$avatar?>" target="_blank" rel="noopener noreferrer">Nama dokument.jpg</a>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </section>
    </div>

    <?= script_tag(RES_PLUGIN . '/jquery/jquery.min.js') ?>
    <?= script_tag(RES_PLUGIN . '/bootstrap/js/bootstrap.bundle.min.js') ?>
    <?= script_tag(RES_PLUGIN . '/moment/moment-with-locales.min.js') ?>
    <?= script_tag(RES_PLUGIN . '/daterangepicker/daterangepicker.js') ?>
    <?= script_tag(RES_PLUGIN . '/datatables/jquery.dataTables.min.js') ?>
    <?= script_tag(RES_PLUGIN . '/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>
    <?= script_tag(RES_PLUGIN . '/datatables-responsive/js/dataTables.responsive.min.js') ?>
    <?= script_tag(RES_PLUGIN . '/datatables-responsive/js/responsive.bootstrap4.min.js') ?>
    <?= script_tag(RES_PLUGIN . '/gasparesganga-jquery-loading-overlay/loadingoverlay.min.js') ?>
    <?= script_tag(RES_PLUGIN . '/jquery-confirm/jquery-confirm.min.js') ?>
    <?= script_tag(RES_PLUGIN . '/toastr/toastr.min.js') ?>

    <?= script_tag(RES_BACKEND . '/js/adminlte.min.js') ?>

    <?= script_tag(BACKEND_JS_APP . "/v1.0.0/{$class}/{$class}FormView.js") ?>
</body>

</html>