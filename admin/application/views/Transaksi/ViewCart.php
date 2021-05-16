<?php
$items = @$_SESSION['items'] ?? [];

if (count($_SESSION['items']) > 0) : ?>
    <div class='d-flex flex-column margin-top-3'>
        <?php
        $total = 0;
        foreach ($items as  $list) :
            $total += $list['harga'] * $list['qty'];
        ?>
            <div class='padding-x-3 padding-y-2 d-flex justify-content-between' style='border-bottom:1px solid #ddd'>
                <div class='d-flex'>
                    <img src="<?= base_url('assets/uploads/files/produk/' . $list['foto']) ?>" width=35>
                    <div class='d-flex flex-column margin-left-2'>
                        <div class=' text-sm-4 fweight-600 text-info'><?= $list['nama_produk'] ?> <sub class='text-muted'><?= ' X ' . $list['qty'] ?></sub></div>
                        <small class='text-muted'><?= $list['nama_jenis'] ?></small>
                    </div>
                </div>

                <div class='d-flex'>
                    <div class=' text-sm-3 fweight-600'>Rp.<?= number_format($list['harga'] * $list['qty'], 0, '.', '.') ?></div>
                    <div class='text-danger text-sm-4 margin-left-1 hover-pointer' id="hapusItem" data-id="<?= $list['id'] ?>"><i class="lni lni-trash"></i></div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class='padding-x-3 padding-y-2 d-flex justify-content-between '>
            <div class='text-md-2 fweight-600'>Total</div>
            <div class='text-md-2 fweight-600'>Rp.<?= number_format($total, 0, '.', '.') ?></div>
        </div>

    </div>

<?php else : ?>
    <div class='d-flex flex-column margin-top-7 text-center'>
        <i class="lni lni-shopping-basket icon-xxl-title text-muted"></i>
        <div class='text-md-3 margin-top-4 text-muted'>Keranjang kosong</div>
    </div>
<?php endif; ?>


<?php if (count($_SESSION['items']) > 0) : ?>
    <div class="position-absolute w-100 padding-y-2" style=" bottom:-10px;">
        <button class="text-md-3 btn btn-success btn-block fweight-600 text-center text-white hover-pointer-bg " id="btnDataDiri" style='text-transform:none'>Selanjutnya <i class="lni lni-chevron-right"></i></button>
    </div>
<?php endif; ?>