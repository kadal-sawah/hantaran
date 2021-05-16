<div class="single-product-area margin-top-7 clearfix margin-bottom-10">
    <div class="container-fluid">
        <?php if ($status_code != 200) : ?>
            <div class="row margin-top-10">
                <div class="col text-center  text-muted d-flex flex-column">
                    <div class='icon-xl-title'><i class="lni lni-search"></i></div>
                    <h5 class=' text-muted'>Produk tidak tersedia</h5>

                    <span>
                        <button onclick="javascript:history.go(-1)" class="btn btn-warning text-white fweight-600">Kembali</button>
                    </span>
                </div>
            </div>
    </div>
</div>
<?php exit(1);
        endif;

        $text = "Hallo Admin, saya order produk dengan *kode produk* : " . $collection['kode_produk'];
        $whatsapp = "https://wa.me/628886351120?text={$text}";

?>
<div class="row">
    <div class="col">
        <a href="javascript:history.go(-1)">
            <h4><i class="lni lni-chevron-left"></i> Detail Produk</h4>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-7">
        <div class="single_product_thumb">
            <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php
                    $x = 0;
                    foreach ($collection['detail_gambar'] as $list) : ?>
                        <li class="active" data-target="#product_details_slider" data-slide-to="<?= $x++ ?>" style="background-image: url(<?= base_url('admin/assets/uploads/files/produk/' . $list) ?>);">
                        </li>

                    <?php endforeach; ?>
                </ol>
                <div class="carousel-inner">
                    <?php
                    $x = 0;
                    foreach ($collection['detail_gambar'] as $list) : ?>
                        <div class="carousel-item <?= $x++ == 0 ? 'active' : '' ?>">
                            <a class="gallery_img" href="<?= base_url('admin/assets/uploads/files/produk/' . $list) ?>">
                                <img class="d-block w-100" src="<?= base_url('admin/assets/uploads/files/produk/' . $list) ?>">
                            </a>
                        </div>

                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="single_product_desc">
            <!-- Product Meta Data -->
            <div class="product-meta-data">
                <h3 class=""><?= $collection['nama_produk'] ?></h3>
                <div class="line mb-3"></div>
                <div class='text-md-2 text-white'>
                    <span class=" bg-success padding-1">Kode Produk : <?= $collection['kode_produk'] ?></span>
                </div>


            </div>

            <div class="short_overview margin-top-3">
                <p class='text-justify'><?= $collection['deskripsi'] ?></p>
            </div>

            <span>
                <div class='text-md-3 text-dark fweight-600'>Rp <?= number_format($collection['harga'], 0, '.', '.') ?></div>
            </span>

        </div>
        <button onclick="window.open('<?= $whatsapp ?>')" class="margin-top-7 btn text-white padding-x-4 padding-y-2 text-md-1" style="background:#39c864">
            <img src="<?= base_url('assets/img/logowa.png') ?>" width='30' style="border-radius: 50%;"> Pesan sekarang</button>

    </div>
</div>


</div>

</div>