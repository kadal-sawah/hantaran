<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Dashboard';

$route['produk-kami'] = 'Produk/produkKami';
$route['tentang'] = 'Dashboard/tentang';

$route['(:any)'] = 'Dashboard/kategori/$1';
$route['produk/(:any)'] = 'Produk/detailProduk/$1';
