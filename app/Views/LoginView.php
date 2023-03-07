<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <?= link_tag(RESOURCES . '/css/adminlte.min.css') ?>
    <?= link_tag(RESOURCES . '/css/custom.css') ?>

    <?= link_tag(RESOURCE_PLUGINS . '/fontawesome-free/css/all.min.css') ?>
    <?= link_tag(RESOURCE_PLUGINS . '/icheck-bootstrap/icheck-bootstrap.min.css') ?>

    <?= script_tag(RESOURCE_PLUGINS . '/jquery/jquery.min.js') ?>
    <?= script_tag(RESOURCE_PLUGINS . '/bootstrap/js/bootstrap.bundle.min.js') ?>
    <?= script_tag(RESOURCES . '/js/adminlte.min.js') ?>

    <?= script_tag(RESOURCE_PLUGINS . '/gasparesganga-jquery-loading-overlay/loadingoverlay.min.js') ?>
</head>

<body class="login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>blue</b>gaz</a>
            </div>

            <div id="login-detail" class="card-body">
                <p class="login-box-msg">Masuk to start your session</p>
                <form id="form-login">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <input type="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button id="btn-signin-first-auth" class="btn btn-primary btn-block">Masuk</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>

            <div id="otp" class="card-body" style="display: none;">
                <p class="login-box-msg">OTP telah dikirimkan ke alamat e-mail <span id="email-censored"></span>, silahkan periksa kotak masuk atau folder spam.</p>
                <form id="form-otp">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fas fa-key"></span>
                            </div>
                        </div>
                        <input type="number" class="form-control" name="otp" placeholder="Masukan OTP">
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button id="btn-signin" class="btn btn-secondary btn-block">Kembali</button>
                        </div>
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <button id="btn-signin-second-auth" class="btn btn-primary btn-block">Masuk</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <?= script_tag(APP_JS . '/config-global.js') ?>

    <script>
        $(function() {
            $('#btn-signin-first-auth').on('click', function(e) {
                e.preventDefault();
                $(this).LoadingOverlay('show');
            });
        });
    </script>
</body>

</html>