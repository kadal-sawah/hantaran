<div class="container-fluid">
    <div class="row margin-top-7">
        <div class="col-lg-6 offset-3">
            <div class="card box-shadow border-radius ">
                <div class="d-flex justify-content-between card-header bg-primary text-white">
                    <h4 class='mb-0'><i class="icon-title sidenav-icon lni lni-user"></i> Profil Perusahaan</h4>
                    <div id='wrapper-gantiProfil' class='d-flex align-items-center'>
                        <div class='margin-top-2 hover-pointer' id="gantiProfil"><i class="lni lni-pencil-alt"></i> Ganti profil</div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- PROFIL -->
                    <div class="row padding-2">
                        <div class="col-lg-5 text-right fweight-600">Logo Perusahaan</div>
                        <div class="col-lg-7">
                            <div class='d-flex flex-column'>

                                <img src="<?= base_url('assets/img/' . $profil->logo) ?>" width=100>
                                <label for="uploadFile" class=" margin-top-2">
                                    <div class='btn btn-info btn-sm'>Ganti logo</div>
                                    <input type="file" name="logo" class='d-none' id='uploadFile'>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id='modeEdit'>

                        <div class="row padding-2">
                            <div class="col-lg-5 text-right fweight-600">Email Perusahaan</div>
                            <div class="col-lg-7" id='emailText'><?= $profil->email ?></div>
                        </div>
                        <div class="row padding-2">
                            <div class="col-lg-5 text-right fweight-600">Alamat</div>
                            <div class="col-lg-7" id="alamatText"><?= $profil->alamat ?></div>
                        </div>
                        <div class="row padding-2">
                            <div class="col-lg-5 text-right fweight-600">Nomor Whatsapp aktif</div>
                            <div class="col-lg-7" id="whatsappText"><a class='text-info' target='_blank' id="" href="https://wa.me/<?= $profil->whatsapp ?>">+<?= $profil->whatsapp ?></a></div>
                        </div>
                    </div>

                    <!-- /PROFIL -->

                </div>
            </div>
        </div>

    </div>
</div>