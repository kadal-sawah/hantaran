<?php $items = @$_SESSION['items'] ?? []; ?>

<div class="container-fluid margin-top-10">
    <div class="row">
        <div class="col-lg-12">

            <!-- LIST -->

            <div class="table-responsive">
                <table id="transaksi" class="display cards w-100 table table-hover ">
                    <thead>
                        <tr>
                            <th>NAMA PANGKAT</th>
                            <th>TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody id="List" class='d-flex justify-content-start flex-wrap'></tbody>
                </table>
            </div>
            <!-- /LIST -->

        </div>
    </div>
</div>

<!-- CART -->
<div class='mysidebar'>
    <div class="mysidebar-contentWrapper h-100">
        <!-- HEADER -->
        <div class="bg-primary text-white d-flex justify-content-between padding-x-3 padding-y-4">
            <div class='text-md-2 mb-0'><i class="lni lni-shopping-basket"></i> Keranjang <?= count($items) > 0 ? "<small class='text-md-1 fweight-600'>(" . count($items) . ")</small>" : ''; ?></div>
            <div class='text-md-2 hover-pointer' id='closeSidebar'><i class="lni lni-close"></i></div>
        </div>
        <!-- /HEADER -->

        <!-- BODY -->
        <div id="listCart">
            <?php if (@count($_SESSION['items']) > 0) : ?>
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
                                <div class=' text-sm-4 fweight-600'>Rp.<?= number_format($list['harga'] * $list['qty'], 0, '.', '.') ?></div>
                                <div class='text-danger text-sm-4 margin-left-1 hover-pointer' id="hapusItem" data-id="<?= $list['id'] ?>"><i class="lni lni-trash"></i></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class='padding-x-3 padding-y-2 d-flex justify-content-between '>
                        <div class='text-md-2 fweight-600'>Total</div>
                        <div class='text-md-2 fweight-600'>Rp.<?= number_format($total, 0, '.', '.') ?></div>
                    </div>

                </div>
            <?php
            else : ?>

                <div class='d-flex flex-column margin-top-7 text-center'>
                    <i class="lni lni-shopping-basket icon-xxl-title text-muted"></i>
                    <div class='text-md-3 margin-top-4 text-muted'>Keranjang kosong</div>
                </div>

            <?php endif; ?>

            <?php if (@count($_SESSION['items']) > 0) : ?>
                <div class="position-absolute w-100 padding-y-2" style=" bottom:-10px;">
                    <button class="text-md-3 btn btn-info btn-block fweight-600 text-center text-white hover-pointer-bg " id="btnDataDiri" style='text-transform:none'>Selanjutnya <i class="lni lni-chevron-right"></i></button>
                </div>
            <?php endif; ?>
        </div>
        <!-- /BODY -->


    </div>
</div>
<!-- /CART -->

<!-- ALAMAT -->
<div class='mysidebar-2'>
    <div class="mysidebar-contentWrapper h-100">
        <!-- HEADER -->
        <div class="bg-info text-white d-flex justify-content-between padding-x-3 padding-y-4">
            <div class='text-md-2 mb-0'><i class="lni lni-user"></i> Data Pelanggan </div>
            <div class='text-md-2 hover-pointer' id='closeSidebar-2'><i class="lni lni-close"></i></div>
        </div>
        <!-- /HEADER -->

        <!-- BODY -->
        <div id="dataPelanggan" class="margin-top-5 ">
            <form method='POST' id='storeCheckout' enctype="multipart/form-data">
                <div class="row  padding-x-3" style='overflow:auto'>
                    <div class="col padding-x-3">

                        <div class="form-group margin-top-2">
                            <label class='fweight-600'>Nama pelanggan</label>
                            <div class='d-flex'>
                                <div class='no-border bg-light padding-x-2'><i class="lni lni-user icon-secondary  margin-top-2"></i></div>
                                <input type="text" class='form-control bg-light' name='nama_pelanggan' placeholder="">
                            </div>
                            <div class='text-muted font-italic margin-top-2'>isi nama pelanggan dengan benar</div>
                        </div>

                        <div class="form-group margin-top-5">
                            <label class='fweight-600'>Alamat lengkap</label>
                            <div class='d-flex'>
                                <div class='no-border bg-light padding-x-2'><i class="lni lni-direction margin-top-2"></i></div>
                                <textarea class='form-control bg-light' name='alamat_lengkap'></textarea>
                            </div>
                            <div class='text-muted font-italic margin-top-2'>isi alamat lengkap dengan benar</div>
                        </div>

                        <div class="form-group margin-top-5">
                            <label class='fweight-600'>No Telpon / Whatsapp Aktif <sup class='text-muted'>Opsional</sup></label>
                            <div class='d-flex'>
                                <div class='no-border bg-light padding-x-2'><i class="lni lni-phone margin-top-2"></i></div>
                                <input type="text" class='form-control bg-light' name='telpon_wa' placeholder="">
                            </div>
                            <div class='text-muted font-italic margin-top-2'>isi telepon atau nomor whatsapp yang aktif </div>
                        </div>

                        <div class="form-group margin-top-5">
                            <label class='fweight-600'>Status Pengiriman</label>
                            <div class='d-flex'>
                                <div class='no-border bg-light padding-x-2'><i class="lni lni-delivery margin-top-2"></i></div>
                                <select name="status_pengiriman" class='form-control bg-light'>
                                    <option value="COD">Cash On Delivery (COD)</option>
                                    <option value="KURIR">Jasa Ekspedisi (Kurir)</option>
                                </select>
                            </div>
                            <div class='text-muted font-italic margin-top-2'>pilih status pengiriman dengan benar </div>

                        </div>

                        <div class="form-group margin-top-5">
                            <label class='fweight-600'>Biaya lain <sup class='text-muted'>Opsional</sup></label>

                            <div class='d-flex'>
                                <div class='no-border bg-light padding-x-2'> <i class="lni lni-handshake margin-top-2"></i></div>
                                <input type="number" class='form-control bg-light' name='biaya_lain' placeholder="">
                            </div>

                            <div class='text-muted font-italic margin-top-2'>isi kolom inputan ini jika ada biaya tambahan, misal : biaya transportasi, biaya administrasi, dll </div>
                        </div>


                        <div class="form-group margin-top-5 d-flex flex-column">
                            <label class='fweight-600'>Bukti transfer <sup class='text-muted'>Opsional</sup></label>

                            <label for='uploadBukti' class="btn btn-info btn-lg btn-block">
                                <input type="file" class='bg-light d-none' id='uploadBukti' name='bukti_tf'>
                                <div>Upload Bukti Transfer</div>
                            </label>

                            <div class='text-muted font-italic margin-top-2'>upload bukti transfer, jika pelangganmu memberikan bukti transfer</div>
                        </div>

                    </div>
                </div>

                <div class="position-absolute w-100 padding-y-2" style=" bottom:-10px;">
                    <button class="text-md-3 btn btn-success btn-block fweight-600 text-center text-white hover-pointer-bg " id="btnCheckout" style='text-transform:none'>Checkout</button>
                </div>
            </form>

        </div>
        <!-- /BODY -->


    </div>
</div>
<!-- /ALAMAT -->