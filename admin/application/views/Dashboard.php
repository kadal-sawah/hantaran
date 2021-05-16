<?php
$getProfil = $this->db->get_where('profil');
$profil = [];
if ($getProfil->num_rows() > 0)
    $profil = $getProfil->row();

?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid d-flex">
            <img class='mx-auto d-block' src="<?= base_url() ?>assets/img/<?= $profil->logo ?>">
        </div>
    </main>
</div>