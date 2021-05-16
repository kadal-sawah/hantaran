<?php

// get profil
$getProfil = $this->db->get_where('profil');
$profil = [];
if ($getProfil->num_rows() > 0) {
    $profil = $getProfil->row();
}

$text = 'Hallo Admin, saya mau order';
@$whatsapp = "https://wa.me/{$profil->whatsapp}?text={$text}";
$nowAccess = $this->library->nowAccess();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Aplikasi Hantaran Online</title>

    <!-- Favicon  -->
    <!-- <link rel="icon" href="img/core-img/favicon.ico"> -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url('assets/img/favicon/apple-icon-57x57.png'); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url('assets/img/favicon/apple-icon-60x60.png'); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('assets/img/favicon/apple-icon-72x72.png'); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/img/favicon/apple-icon-76x76.png'); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('assets/img/favicon/apple-icon-114x114.png'); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('assets/img/favicon/apple-icon-120x120.png'); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('assets/img/favicon/apple-icon-144x144.png'); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('assets/img/favicon/apple-icon-152x152.png'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/img/favicon/apple-icon-180x180.png'); ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('assets/img/favicon/android-icon-192x192.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/img/favicon/favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('assets/img/favicon/favicon-96x96.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/img/favicon/favicon-16x16.png'); ?>">


    <!-- Core Style CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/core-style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugin/snackbar/snackbar.min.css'); ?>">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">

</head>

<body>
    <!-- Search Wrapper Area Start -->
    <div class="search-wrapper section-padding-100">
        <div class="search-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-content">
                        <form action="#" method="get">
                            <input type="search" name="search" id="search" placeholder="Type your keyword...">
                            <button type="submit"><img src="img/core-img/search.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Wrapper Area End -->

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <!-- Mobile Nav (max width 767px)-->
        <div class="mobile-nav">
            <!-- Navbar Brand -->
            <div class="amado-navbar-brand">
                <a href="<?= base_url(); ?>"><img src="<?= base_url('admin/assets/img/'.$profil->logo); ?>" alt=""></a>
            </div>
            <!-- Navbar Toggler -->
            <div class="amado-navbar-toggler">
                <span></span><span></span><span></span>
            </div>
        </div>

        <!-- Header Area Start -->
        <header class="header-area clearfix" style="min-height:100vh">
            <!-- Close Icon -->
            <div class="nav-close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </div>
            <!-- Logo -->
            <div class="logo">
                <a href="<?= base_url(); ?>"><img src="<?= base_url('admin/assets/img/'.$profil->logo); ?>" alt=""></a>
            </div>
            <!-- Amado Nav -->
            <nav class="amado-nav">
                <ul>
                    <li class="<?= $nowAccess == 'dashboard/index' ? 'active' : ''; ?>"><a style="text-transform: capitalize !important; font-size:18px;" href="<?= base_url(); ?>"><i class="lni lni-home"></i> Beranda</a></li>
                    <li class="<?= $nowAccess == 'produk/produkkami' ? 'active' : ''; ?>"><a href="<?= base_url('produk-kami'); ?>" style="text-transform: capitalize !important; font-size:18px;"><i class="lni lni-gift"></i> Katalog Produk</a></li>
                    <li class="<?= $nowAccess == 'dashboard/tentang' ? 'active' : ''; ?>"><a href="<?= base_url('tentang'); ?>" style="text-transform: capitalize !important; font-size:18px;"><i class="lni lni-phone"></i> Tentang kami</a></li>
                    <!-- <li><a href="cart.html" style="text-transform: capitalize !important; font-size:18px;"><i class="lni lni-search-alt"></i> Cari Produk</a></li> -->
                </ul>
            </nav>

            <!-- Social Button -->
            <div class="social-info d-flex  mt-3">
                <button onclick="javascript:window.open('<?= $whatsapp; ?>')" class='d-flex border-radius btn' style="background:#39c864">
                    <img src="<?= base_url('assets/img/logowa.png'); ?>" width=30 height=30 style="border-radius: 50%;">
                    <div class='margin-top-1 text-white padding-x-3'>Whatsapp</div>
                </button>
            </div>
        </header>
        <!-- Header Area End -->

        <?php $this->load->view($content); ?>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix ">
        <div class="container">
            <div class="row align-items-center">
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-4">
                    <div class="single_widget_area">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="#"><img src="<?= base_url('assets/img/favicon/favicon-32x32.png'); ?>" alt="logo"></a>
                        </div>
                        <!-- Copywrite Text -->
                        <p class="copywrite">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script>&nbsp;<a href="#" target="#">Twins Salon</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-8">
                    <div class="single_widget_area">
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <nav class="navbar navbar-expand-lg justify-content-end">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#footerNavContent" aria-controls="footerNavContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
                                <div class="collapse navbar-collapse" id="footerNavContent">
                                    <ul class="navbar-nav ml-auto">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="<?= base_url(); ?>">Beranda</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('produk-kami'); ?>">Katalog</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('tentang'); ?>">Tentang kami</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
    <script src="<?= base_url('assets/js/jquery/jquery-2.2.4.min.js'); ?>"></script>
    <!-- Popper js -->
    <script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
    <!-- Bootstrap js -->
    <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <!-- Plugins js -->
    <script src="<?= base_url('assets/js/plugins.js'); ?>"></script>
    <!-- Active js -->
    <script src="<?= base_url('assets/js/active.js'); ?>"></script>
    <script src="<?= base_url('assets/plugin/snackbar/snackbar.min.js'); ?>"></script>

    <?= $this->session->flashdata('pesan'); ?>
</body>

</html>