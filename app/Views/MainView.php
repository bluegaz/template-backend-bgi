<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BGI App</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <?= link_tag(RES_PLUGIN . '/fontawesome-free/css/all.min.css') ?>
    <?= link_tag(RES_BACKEND . '/css/adminlte.min.css') ?>
</head>

<body class="text-sm">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header border-bottom-0 navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-lg-none d-sm-inline-block nav-link">
                    Dokumen PT. BGI
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Profil -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">Hi, {fullname}</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="far fa-user mr-2"></i> {Username}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="far fa-file mr-2"></i> {Info lain}
                        </a>
                        <div class="dropdown-divider"></div>
                        <div class="row" style="padding: 0.5rem 1rem;">
                            <div class="col-6 my-auto">
                                <a href="#">Lupa Password?</a>
                            </div>
                            <div class="col-6">
                                <a class="btn btn-sm btn-block btn-outline-secondary btn-flat" href="#" role="button">Keluar</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            <span class="brand-link ml-3">Dokumen PT. BGI</span>

            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar nav-legacy nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item root-menu">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Starter Pages
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/back-end/menu-xyz" class="nav-link sidebar-menu">
                                        <i class="fas fa-minus nav-icon"></i>
                                        <p>Menu XYZ</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://google.com" class="nav-link sidebar-menu">
                                        <i class="fas fa-minus nav-icon"></i>
                                        <p>Menu ABC</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Simple Link
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
            <div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0">
                <a class="nav-link bg-light" href="#" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
                <ul class="navbar-nav overflow-hidden" role="tablist"></ul>
                <a class="nav-link bg-light" href="#" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>
                <a id="btn-refresh-iframe" class="nav-link bg-light" href="#" data-widget="iframe-refresh"><i class="fa fa-sync-alt"></i></a>
                <div class="nav-item dropdown">
                    <a class="nav-link bg-danger dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>
                    <div class="dropdown-menu mt-0">
                        <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all">Tutup semua</a>
                        <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all-other">Tutup yang lainnya</a>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-empty">
                    <h5 class="display-5">Tidak ada menu terbuka</h5>
                </div>
                <div class="tab-loading">
                    <div>

                        <?= img(RES_BACKEND . '/img/loading-page.svg') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= script_tag(RES_PLUGIN . '/jquery/jquery.min.js') ?>
    <?= script_tag(RES_PLUGIN . '/bootstrap/js/bootstrap.bundle.min.js') ?>

    <?= script_tag(RES_BACKEND . '/js/adminlte.min.js') ?>

    <?= script_tag(BACKEND_JS_APP . "/v1.0.0/{$class}View.js") ?>
</body>

</html>