<!DOCTYPE html>
<html lang="en">

<head>
    <?= view("_include/form_head.php") ?>

    <?= link_tag(RES_PLUGIN . '/daterangepicker/daterangepicker.css') ?>
</head>

<body class="text-sm content-iframe bg-light">
    <?= view("_include/form_header.php") ?>

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
                            <a href="<?= @$avatar ?>" target="_blank" rel="noopener noreferrer">Nama dokument.jpg</a>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </section>
    </div>

    <?= view("_include/form_footer.php") ?>

    <?= script_tag(RES_PLUGIN . '/moment/moment-with-locales.min.js') ?>
    <?= script_tag(RES_PLUGIN . '/daterangepicker/daterangepicker.js') ?>

    <?= script_tag(BACKEND_JS_APP . "/v1.0.0/{$class}/{$class}FormView.js") ?>
</body>

</html>