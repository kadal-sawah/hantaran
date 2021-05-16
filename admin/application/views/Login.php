<?php
$getProfil = $this->db->get_where('profil');
$profil = [];
if ($getProfil->num_rows() > 0)
    $profil = $getProfil->row();
?>
<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

<head>
    <title>Aplikasi Hantaran Online | Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Bhumlu Bootstrap admin template made using Bootstrap 4, it has tons of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="Bhumlu, bootstrap admin template, bootstrap admin panel, bootstrap 4 admin template, admin template">
    <meta name="author" content="Srthemesvilla" />
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/img/favicon.ico">

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Core stylesheets -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-material.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/shreerang-material.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/uikit.css">

    <!-- Libs -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/libs/perfect-scrollbar/perfect-scrollbar.css">
    <!-- Page -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/pages/authentication.css">
</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ content ] Start -->
    <br /><br /><br /><br /><br />
    <br /><br /><br />

    <div class="container margin-top-7">

        <div class="row">
            <div class="col-lg-6">
                <img class='mx-auto d-block' src="<?= base_url('assets/img/' . $profil->logo) ?>" alt="">


            </div>
            <div class="col-lg-6">
                <div class="card box-shadow border-radius no-border">
                    <div class="card-body">
                        <div class='d-flex flex-column text-center'>
                            <b class='text-md-2'>Login</b>
                            <div class='text-muted text-sm-4'>Aplikasi Hantaran Online</div>
                        </div>
                        <!-- [ Form ] Start -->
                        <form class="padding-y-3" action="<?= base_url('login/store') ?>" method="POST">
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group margin-top-7">
                                <label class="form-label d-flex justify-content-between align-items-end">
                                    <span>Password</span>
                                </label>
                                <input type="password" class="form-control" name="password">
                                <div class="clearfix"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center m-0">
                                <button type="submit" class="btn btn-primary btn-block padding-y-3">Masuk</button>
                            </div>
                        </form>
                        <!-- [ Form ] End -->


                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- [ content ] End -->

    <!-- Core scripts -->
    <script src="<?= base_url() ?>assets/js/pace.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/popper/popper.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.js"></script>
    <script src="<?= base_url() ?>assets/js/sidenav.js"></script>
    <script src="<?= base_url() ?>assets/js/layout-helpers.js"></script>
    <script src="<?= base_url() ?>assets/js/material-ripple.js"></script>

    <!-- Libs -->
    <script src="<?= base_url() ?>assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
</body>

</html>