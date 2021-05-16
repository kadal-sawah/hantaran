<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Login';
$route['produk'] = 'Produk/index';
$route['produk/delete/gambar/(:num)'] = 'Produk/deleteGambar/$1';
$route['dashboard'] = 'Dashboard/index';


$route['jenisproduk'] = 'JenisProduk';

$route['profil'] = 'Profil';
$route['profil/saya'] = 'Profil/ProfilSaya';
$route['profil/saya/store'] = 'Profil/StoreProfilSaya';
$route['profil/store'] = 'Profil/Store';
$route['profil/updatelogo'] = 'Profil/updateLogo';

$route['buat-transaksi'] = 'Transaksi/Buat';
$route['transaksi/get_dt'] = 'Transaksi/getDataTable';

$route['transaksi/cart/add'] = 'Transaksi/AddCart';
$route['transaksi/cart/hapus'] = 'Transaksi/HapusCart';
$route['transaksi/cart/view'] = 'Transaksi/ViewCart';
$route['transaksi/datadiri'] = 'Transaksi/nextDataDiri';
$route['transaksi/checkout'] = 'Transaksi/Checkout';
$route['transaksi/sukses'] = 'Transaksi/Sukses';
$route['transaksi/detail/(:num)'] = 'Transaksi/detailTransaksi/$1';

$route['login'] = 'Login/index';
$route['login/store'] = 'Login/Store';

$route['logout'] = 'Login/logout';
