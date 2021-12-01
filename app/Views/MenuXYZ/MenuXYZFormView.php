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
                <?= form_open('', "id='form-user'", [$act == 'e' ? 'updated_by' : 'created_by' => 'template']) ?>
                <input id="act" type="hidden" value="<?= $act ?>">
                <input id="id-user" type="hidden" value="<?= @$id ?>">
                <div class="card-deck mb-lg-3 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input id="nik" name="nik" class="form-control form-control-sm" type="text" autocomplete="off" placeholder="NIK" value="<?= @$nik ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input id="name" name="name" class="form-control form-control-sm" type="text" autocomplete="off" placeholder="Nama" value="<?= @$name ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="initial">Initial</label>
                                <input id="initial" name="initial" class="form-control form-control-sm" type="text" autocomplete="off" value="<?= @$initial ?>" placeholder="Inisial" required>
                            </div>
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select id="is_active" name="is_active" class="form-control form-control-sm" required>
                                    <option selected disabled value="">Pilih..</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                </select>
                                <input id="is-active-selected" type="hidden" value="<?= @$is_active ?>">
                            </div>
                            <div id="password-group" class="form-group">
                                <label for="password">Password</label>
                                <input id="password" name="password" class="form-control form-control-sm" type="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="born-date">Tanggal Lahir</label>
                                <input id="born-date" class="form-control form-control-sm" type="text" autocomplete="off" value="<?= @$born_date ?>" placeholder="Tanggal Lahir" required readonly>
                                <small class="form-text text-muted mt-0">yyyy-mm-dd</small>
                            </div>
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea id="address" class="form-control form-control-sm" rows="3" placeholder="Alamat" required><?= @$address ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="avatar">Upload atau perbaharui Avatar</label>
                                <input id="avatar" type="file" class="form-control-file form-control-file-sm" required>
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

    <?= script_tag(BACKEND_JS_APP . "/v1.0.0/config-global.js") ?>
    <?= script_tag(BACKEND_JS_APP . "/v1.0.0/config-form.js") ?>
    <?= script_tag(BACKEND_JS_APP . "/v1.0.0/{$class}/{$class}FormView.js") ?>
</body>

</html>