<?php
$isAktif = "<span class='text-success fweight-600'>Aktif</span>";

if ($profil->is_aktif == '0')
    $isAktif = "<span class='text-danger'>Banned</span>";


$hakAkses = "<span class='fweight-600'>Admin</span>";

if ($profil->level == 'S.ADMIN')
    $hakAkses = "<span class='fweight-600 text-success'>Super Admin</span>";
?>
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-3">
            <div class="card box-shadow border-radius ">
                <div class="d-flex justify-content-between card-header bg-primary text-white">
                    <h4 class='mb-0'><i class="icon-title sidenav-icon lni lni-user"></i> Profil Saya</h4>
                    <div id='wrapper-gantiProfil' class='d-flex align-items-center'>
                        <div class='margin-top-2 hover-pointer' id="gantiProfil"><i class="lni lni-pencil-alt"></i> Ganti profil</div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- PROFIL -->
                    <div id='modeEdit'>

                        <div class="row padding-2">
                            <div class="col-lg-4 text-right fweight-600">Nama User</div>
                            <div class="col-lg-8" id='userText'><?= $profil->nama_user ?></div>
                        </div>
                        <div class="row padding-2">
                            <div class="col-lg-4 text-right fweight-600">Username</div>
                            <div class="col-lg-8" id="usernameText"><?= $profil->username ?></div>
                        </div>
                        <div class="row padding-2">
                            <div class="col-lg-4 text-right fweight-600">Password</div>
                            <div class="col-lg-8" id="passwordText">********</div>
                        </div>

                        <div class="row padding-2">
                            <div class="col-lg-4 text-right fweight-600">Hak akses</div>
                            <div class="col-lg-8"><?= $hakAkses ?></div>
                        </div>
                        <div class="row padding-2">
                            <div class="col-lg-4 text-right fweight-600">Status Akun</div>
                            <div class="col-lg-8"><?= $isAktif ?></div>
                        </div>

                    </div>

                    <!-- /PROFIL -->

                </div>
            </div>
        </div>
    </div>
</div>