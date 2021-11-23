<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <?= link_tag(RES_PLUGIN . '/fontawesome-free/css/all.min.css') ?>
    <?= link_tag(RES_PLUGIN . '/daterangepicker/daterangepicker.css') ?>
    <?= link_tag(RES_PLUGIN . '/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>
    <?= link_tag(RES_PLUGIN . '/datatables-responsive/css/responsive.bootstrap4.min.css') ?>
    <?= link_tag(RES_PLUGIN . '/jquery-confirm/jquery-confirm.min.css') ?>
    <?= link_tag(RES_PLUGIN . '/toastr/toastr.min.css') ?>

    <?= link_tag(RES_BACKEND . '/css/adminlte.min.css') ?>
</head>

<body class="text-sm content-iframe">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Menu XYZ</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="btn-group w-100 mb-3" role="group">
                        <button id="btn-search" type="button" class="btn btn-sm btn-outline-secondary btn-action" data-toggle="tooltip" title="Cari"><i class="fa fa-search"></i></button>
                        <button id="btn-add" type="button" class="btn btn-sm btn-outline-secondary btn-action" data-toggle="tooltip" title="Tambah"><i class="fa fa-plus-square"></i></button>
                        <div class="btn-group w-25" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-block dropdown-toggle btn-action" data-toggle="dropdown" title="Download"><i class="fa fa-download"></i> </button>
                            <div class="dropdown-menu">
                                <a id="btn-download-pdf" class="dropdown-item download-pdf" href="#">PDF</a>
                                <a id="btn-download-spreadsheet" class="dropdown-item download-spreadsheet" href="#">Spreadsheet</a>
                            </div>
                        </div>
                    </div>

                    <div class="card card-secondary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Filter</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" onclick="document.getElementById('filter-general').reset()">
                                    Reset
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= form_open('', "id='filter-general'") ?>
                            <div class="form-group">
                                <label for="filter1" mb-0>Filter 1</label>
                                <input id="filter1" name="filter1" class="form-control form-control-sm" type="text" placeholder="Filter 1">
                            </div>
                            <div class="form-group">
                                <label for="filter2">Filter 2</label>
                                <select id="filter2" name="filter2" class="form-control form-control-sm">
                                    <option selected disabled value="">Pilih...</option>
                                    <option>option 1</option>
                                    <option>option 2</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="filter3">Filter 3</label>
                                <select id="filter3" name="filter3" class="form-control form-control-sm">
                                    <option selected value="">Semua</option>
                                    <option>option 1</option>
                                    <option>option 2</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_single">Tanggal Single</label>
                                <input id="tanggal_single" name="tanggal_single" class="form-control form-control-sm" type="text" placeholder="Tanggal Single" readonly>
                                <small class="form-text text-muted mt-0">yyyy-mm-dd</small>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_range">Tanggal Range</label>
                                <input id="tanggal_range" name="tanggal_range" class="form-control form-control-sm" type="text" placeholder="Tanggal Range" readonly>
                                <small class="form-text text-muted mt-0">yyyy-mm-dd s/d yyyy-mm-dd</small>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card card-secondary card-outline">
                        <div class="card-body">
                            <table id="table-xyz" class="table table-sm table-striped table-responsive nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No. Telp</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <?= script_tag(BACKEND_JS_APP . "/v1.0.0/{$class}/{$class}ListView.js") ?>
</body>

</html>