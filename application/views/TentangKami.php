<?php
// get profil
$getProfil = $this->db->get_where('profil');
$profil = [];
if ($getProfil->num_rows() > 0)
    $profil = $getProfil->row();
?>
<div class="container">
    <div class="row">
        <div class="col ">
            <div class='d-flex flex-column align-items-center'>
                <div class="d-flex flex-column text-center margin-top-10 margin-bottom-5">

                    <h3 class='fweight-600 '>Tentang Kami</h3>
                    <img src="<?= base_url('assets/img/logo.png') ?>">
                </div>

                <div class="d-flex margin-top-3 flex-wrap">
                    <div>
                        <div class='fweight-600'>
                            <i class="lni lni-envelope"></i> Email
                        </div>
                        <p class='text-muted'><?= $profil->email ?></p>
                    </div>

                    <div class='margin-x-4 d-none d-xs-none d-sm-none d-md-block d-lg-block d-xl-block' style="border-left:1px solid #ddd;"></div>
                    <div>
                        <div class='fweight-600'>
                            <i class="lni lni-map-marker"></i> Alamat
                        </div>
                        <p class='text-muted text-left'><?= $profil->alamat ?></p>
                    </div>
                    <div class='margin-x-4 d-none d-xs-none d-sm-none d-md-block d-lg-block d-xl-block' style="border-left:1px solid #ddd;"></div>

                    <div>
                        <div class='fweight-600'>
                            <i class="lni lni-whatsapp"></i> Whatsapp
                        </div>
                        <p class='text-muted text-left'>
                            <a href="https://wa.me/<?= $profil->whatsapp ?>" class='text-info' target='_blank'>+<?= $profil->whatsapp ?></a>
                        </p>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>