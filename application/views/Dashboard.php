<!-- Product Catagories Area Start -->
<div class="products-catagories-area clearfix">

    <!-- TITLE -->
    <div class="row margin-y-3">
        <div class="col text-center">
            <h4 class='fweight-500'>Etalase</h4>
            <div class='mx-auto bg-warning' style="width:50px; height:3px"></div>
        </div>
    </div>

    <div class="amado-pro-catagory clearfix">
        <?php foreach ($jenis as $list) : ?>
            <!-- Single Catagory -->
            <div class="single-products-catagory clearfix bg-dark">
                <a href="<?= base_url($list['slug']); ?>">
                    <img style="opacity:0.9" src="<?= base_url('admin/assets/uploads/files/jenis/'.$list['cover']); ?>" height=100%>
                    <!-- Hover Content -->
                    <div class="hover-content text-center bg-dark padding-x-2 padding-y-1" style="opacity:0.8;   position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                        <h3 class='fweight-700 text-white mb-0 ' style='letter-spacing:1.5px'><?= strtoupper($list['nama_jenis']); ?></h3>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>

    </div>
</div>
<!-- Product Catagories Area End -->