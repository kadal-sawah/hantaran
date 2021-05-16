<?php
$totalHarga = $transaksi->total_harga;

if ($transaksi->biaya_lain != null)
    $totalHarga += $transaksi->biaya_lain;
?>

<div class="container-fluid">
    <div class="row margin-top-7">
        <div class="col">
            <a href="javascript:history.go(-1)" class='text-dark'>
                <h4><i class="lni lni-chevron-left"></i> Detail Transaksi</h4>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">

            <div class="card box-shadow border-radius no-border margin-top-2">
                <div class="card-header bg-primary padding-3 border-radius-top">
                    <div class='text-md-2 text-white'>Transaksi</div>
                </div>
                <div class="card-body">

                    <div class="row padding-bottom-2">
                        <div class="col-lg-5 fweight-600">No Invoice</div>
                        <div class="col-lg-7">: <b><?= $transaksi->no_invoice ?></b></div>
                    </div>

                    <div class="row padding-bottom-2">
                        <div class="col-lg-5 fweight-600">Total Harga</div>
                        <div class="col-lg-7">: Rp.<?= number_format($totalHarga, 0, '.', '.') ?></div>
                    </div>

                    <div class="row padding-bottom-2">
                        <div class="col-lg-5 fweight-600">Pengiriman</div>
                        <div class="col-lg-7">: <?= $transaksi->status_pengiriman ?></div>
                    </div>


                    <div class="row padding-bottom-2">
                        <div class="col-lg-5 fweight-600">Status Transaksi</div>
                        <div class="col-lg-7">: <?= $transaksi->status_transaksi ?></div>
                    </div>

                    <?php if ($transaksi->bukti_tf != null) : ?>
                        <div class="row margin-top-2">
                            <div class="col text-center">
                                <img class='box-shadow' src="<?= base_url('assets/uploads/files/bukti_tf/' . $transaksi->bukti_tf) ?>" width='200'>
                                <h5 class='margin-top-2'>Bukti Transfer</h5>
                            </div>
                        </div>
                    <?php endif; ?>



                </div>
            </div>


            <div class="card box-shadow border-radius no-border margin-top-3">
                <div class="card-header bg-info padding-3 border-radius-top">
                    <div class='text-md-2 text-white'>Data Pelanggan</div>
                </div>
                <div class="card-body">

                    <div class="row padding-bottom-2">
                        <div class="col-lg-5 fweight-600">Nama Pelanggan</div>
                        <div class="col-lg-7">: <?= $transaksi->nama_pelanggan ?></div>
                    </div>

                    <div class="row padding-bottom-2">
                        <div class="col-lg-5 fweight-600">Alamat Lengkap</div>
                        <div class="col-lg-7">: <?= $transaksi->alamat_lengkap ?></div>
                    </div>

                    <div class="row padding-bottom-2">
                        <div class="col-lg-5 fweight-600">Telepon / Whatsapp</div>
                        <div class="col-lg-7">: <?= $transaksi->telepon_wa  == null ? "<span class='text-muted'>Tidak diisi</span>" : $transaksi->telepon_wa ?></div>
                    </div>

                </div>
            </div>


        </div>


        <div class="col-lg-8">
            <div class="card box-shadow border-radius no-border margin-top-2">
                <div class="card-header bg-primary padding-3 border-radius-top">
                    <div class='text-md-2 text-white'>Rincian Transaksi</div>
                </div>
                <div class="card-body">

                    <?php
                    $total = 0;
                    $hargaTotal  = 0;
                    foreach ($detailTransaksi as $list) :
                        $hargaTotal += $list['harga'] * $list['qty'];
                        $total = $list['harga'] * $list['qty'];
                    ?>
                        <div class="d-flex justify-content-lg-between margin-bottom-5">
                            <div class='d-flex '>
                                <div>
                                    <img src="<?= base_url('assets/uploads/files/produk/' . $list['foto']) ?>" width="75" height="75">
                                </div>
                                <div class='d-flex flex-column margin-left-2'>
                                    <div class='text-md-2 fweight-600'><?= $list['nama_produk'] ?></div>
                                    <div class='text-muted'>Rp.<?= number_format($list['harga'], 0, '.', '.') . ' X ' . $list['qty'] ?></div>
                                </div>
                            </div>

                            <div>
                                <div class='text-md-3 text-muted'>Rp.<?= number_format($total, 0, '.', '.') ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="d-flex justify-content-lg-between margin-bottom-5">
                        <div class='text-md-2 text-muted'>Biaya lain lain</div>
                        <div class='text-md-3 text-muted'>Rp.<?= number_format($transaksi->biaya_lain, 0, '.', '.') ?></div>
                    </div>

                    <hr style="background:#ccc; opacity:0.7">
                    <div class="d-flex justify-content-lg-between margin-bottom-5">
                        <div class='text-md-3 fweight-600'>TOTAL </div>
                        <div class='text-md-3 fweight-600'>Rp.<?= number_format($hargaTotal + $transaksi->biaya_lain, 0, '.', '.') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>