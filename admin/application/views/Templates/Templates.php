<?php
$getProfil = $this->db->get_where('profil');
$profil = [];
if ($getProfil->num_rows() > 0) {
    $profil = $getProfil->row();
}

$user = $this->library->SessionData();
?>
<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

<head>
    <title>Aplikasi Hantaran Online | Admin</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Aplikasi Hantaran Online" />
    <meta name="keywords" content="hantaran online, twin salon">
    <meta name="author" content="Twinsalon" />

    <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url('assets/img/favicon'); ?>/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url('assets/img/favicon'); ?>/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('assets/img/favicon'); ?>/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/img/favicon'); ?>/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('assets/img/favicon'); ?>/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('assets/img/favicon'); ?>/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('assets/img/favicon'); ?>/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('assets/img/favicon'); ?>/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/img/favicon'); ?>/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('assets/img/favicon'); ?>/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/img/favicon'); ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('assets/img/favicon'); ?>/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/img/favicon'); ?>/favicon-16x16.png">

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Icon fonts -->
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <!-- Core stylesheets -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap-material.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/shreerang-material.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/uikit.css">
    <link rel="stylesheet" href="<?= base_url('assets/plugin/snackbar/snackbar.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom.css">

    <!-- Libs -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/libs/perfect-scrollbar/perfect-scrollbar.css">


    <!-- CSS -->
    <?php
    if (isset($crud) && $crud != null) {
        foreach ($crud->css_files as $file) : ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>

        <?php foreach ($crud->js_files as $file) : ?>
            <script src="<?php echo $file; ?>"></script>
        <?php endforeach;
    } else { ?>
        <script src="<?= base_url('assets/grocery_crud/js/jquery-1.11.1.min.js'); ?>"></script>
        <?php }
    if (isset($css)) {
        foreach ($css as $list) : ?>
            <link rel="stylesheet" href="<?= $list; ?>">
    <?php endforeach;
    }  ?>
</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] Ebd -->

    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <!-- [ Layout sidenav ] Start -->
            <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-dark">
                <!-- Brand demo (see assets/css/demo/demo.css) -->
                <div class="app-brand demo bg-light">
                    <span class="">
                        <img src="<?= base_url(); ?>assets/img/<?= $profil->logo; ?>" width='50' class="img-fluid">
                    </span>
                    <a href="#" class="app-brand-text demo sidenav-text font-weight-normal ml-2">Admin Hantaran</a>
                    <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
                        <i class="ion ion-md-menu align-middle"></i>
                    </a>
                </div>
                <div class="sidenav-divider mt-0"></div>

                <!-- Links -->
                <ul class="sidenav-inner py-1">

                    <!-- Dashboards -->
                    <li class="sidenav-item">
                        <a href="<?= base_url('dashboard'); ?>" class="sidenav-link">
                            <i class="sidenav-icon lni lni-home"></i>
                            <div>Dashboard</div>
                            <!-- <div class="pl-1 ml-auto">
                                <div class="badge badge-danger">Hot</div>
                            </div> -->
                        </a>
                    </li>

                    <!-- Layouts -->
                    <li class="sidenav-divider mb-1"></li>
                    <li class="sidenav-header small font-weight-semibold">MASTER</li>
                    <li class="sidenav-item">
                        <a href="<?= base_url('produk'); ?>" class="sidenav-link">
                            <i class="sidenav-icon lni lni-gift"></i>
                            <div>Produk</div>
                        </a>
                    </li>

                    <li class="sidenav-item">
                        <a href="<?= base_url('JenisProduk'); ?>" class="sidenav-link">
                            <i class="sidenav-icon lni lni-layers"></i>
                            <div>Jenis Produk</div>
                        </a>
                    </li>


                    <!-- Forms & Tables -->
                    <li class="sidenav-divider mb-1"></li>
                    <li class="sidenav-header small font-weight-semibold">TRANSAKSI</li>
                    <li class="sidenav-item">
                        <a href="<?= base_url('transaksi'); ?>" class="sidenav-link">
                            <i class="sidenav-icon lni lni-shopping-basket"></i>
                            <div>Pesanan</div>
                        </a>
                    </li>

                    <li class="sidenav-header small font-weight-semibold">Pengaturan</li>

                    <li class="sidenav-item">
                        <a href="<?= base_url('profil'); ?>" class="sidenav-link">
                            <i class="sidenav-icon lni lni-user"></i>
                            <div>Profil Perusahaan</div>
                        </a>
                    </li>

                    <li class='sidenav-header font-weight-semibold'>
                        <a href="<?= base_url('buat-transaksi'); ?>" class='btn btn-primary btn-block '><i class="lni lni-plus"></i> &nbsp; Buat Pesanan</a>
                    </li>
                </ul>
            </div>
            <!-- [ Layout sidenav ] End -->
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <!-- [ Layout navbar ( Header ) ] Start -->
                <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-white container-p-x" id="layout-navbar">

                    <!-- Brand demo (see assets/css/demo/demo.css) -->
                    <a href="index.html" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
                        <span class="app-brand-logo demo">
                            <img src="<?= base_url(); ?>assets/img/logo-dark.png" alt="Brand Logo" class="img-fluid">
                        </span>
                        <span class="app-brand-text demo font-weight-normal ml-2">Bhumlu</span>
                    </a>

                    <!-- Sidenav toggle (see assets/css/demo/demo.css) -->
                    <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
                        <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:">
                            <i class="ion ion-md-menu text-large align-middle"></i>
                        </a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse" id="layout-navbar-collapse">
                        <!-- Divider -->
                        <hr class="d-lg-none w-100 my-2">

                        <div class="navbar-nav align-items-lg-center ml-auto">

                            <div class='padding-x-2'><?= @$fiturPage ?? ''; ?></div>
                            <!-- Divider -->
                            <!-- <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div> -->
                            <div class="demo-navbar-user nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0"><?= $user['nama_user']; ?></span>
                                        <i class="lni lni-user icon-primary"></i>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="<?= base_url('profil/saya'); ?>" class="dropdown-item">
                                        <i class="lni lni-user icon-secondary"></i> &nbsp; Profil Saya</a>
                                    <a href="<?= base_url('logout'); ?>" onclick="return confirm('apakah anda yakin, ingin keluar ?')" class="dropdown-item">
                                        <i class="lni lni-power-switch"></i> &nbsp; Keluar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- [ Layout navbar ( Header ) ] End -->

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view($page); ?>

                </div>
                <!-- [ content ] End -->

                <!-- [ Layout footer ] Start -->
                <nav class="layout-footer footer bg-white">
                    <div class="container-fluid d-flex flex-wrap justify-content-between text-center container-p-x pb-3">
                        <div class="pt-3">
                            <span class="footer-text font-weight-semibold">&copy; <a href="<?= base_url('../'); ?>" class="footer-link" target="_blank">Twinsalon</a></span>
                        </div>
                        <div>
                            <a href="<?= base_url('../'); ?>" class="footer-link pt-3" target="_blank">Ke Website</a>
                        </div>
                    </div>
                </nav>
                <!-- [ Layout footer ] End -->

            </div>
            <!-- [ Layout content ] Start -->

        </div>
        <!-- [ Layout container ] End -->

    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper ] end -->

    <!-- Core scripts -->

    <script src="<?= base_url(); ?>assets/js/pace.js"></script>
    <script src="<?= base_url(); ?>assets/libs/popper/popper.js"></script>
    <script src="<?= base_url(); ?>assets/js/bootstrap.js"></script>
    <script src="<?= base_url(); ?>assets/js/sidenav.js"></script>
    <script src="<?= base_url(); ?>assets/js/layout-helpers.js"></script>
    <script src="<?= base_url(); ?>assets/js/material-ripple.js"></script>

    <!-- Libs -->
    <script src="<?= base_url(); ?>assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url('assets/plugin/snackbar/snackbar.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/config.js'); ?>"></script>
    <?php
    if (isset($js)) {
        foreach ($js as $list) : ?>
            <script src="<?= $list; ?>"></script>
    <?php endforeach;
    } ?>
    <?= $this->session->flashdata('pesan'); ?>

</body>

</html>