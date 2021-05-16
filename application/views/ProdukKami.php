<!-- Product Catagories Area Start -->
<div class="products-catagories-area clearfix">

    <!-- TITLE -->
    <div class="row margin-y-3">
        <div class="col text-center">
            <h4 class='fweight-500'>Produk kami</h4>
            <div class='mx-auto bg-warning' style="width:50px; height:3px"></div>
        </div>
    </div>
    <!-- /TITLE -->
    <div class="amado-pro-catagory clearfix">
        <?php foreach ($collections as $list) : ?>
            <!-- Single Catagory -->
            <div class="single-products-catagory clearfix bg-dark">
                <a href="<?= base_url('produk/' . $list['slug']) ?>">

                    <?php if (count($list['detail_gambar']) > 0) : ?>
                        <img style="opacity:0.9" src="<?= base_url('admin/assets/uploads/files/produk/' . $list['detail_gambar'][0]) ?>" height=100%>
                    <?php endif; ?>
                    <!-- Hover Content -->
                    <div class="hover-content bg-dark padding-x-4 padding-y-3" style="opacity:0.8;   position: absolute; bottom:0; left:0; right:0;">
                        <h4 class='fweight-600 text-white mb-0 ' style='letter-spacing:1.5px'><?= strtoupper($list['nama_produk']) ?></h4>
                        <div class="line margin-y-2"></div>
                        <h5 class='text-white'>Rp. <?= number_format($list['harga'], 0, '.', '.') ?></h5>
                    </div>

                    <!-- KODE PRODUK -->
                    <div class="position-absolute bg-success  padding-x-3 text-md-2 text-white" style="top:0; right:0"><?= $list['kode_produk'] ?></div>
                    <!-- /KODE PRODUK -->


                </a>
            </div>
        <?php endforeach; ?>

    </div>
</div>
<!-- Product Catagories Area End -->