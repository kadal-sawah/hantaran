<?php
if ($this->library->nowAccess() == 'produk/index') : ?>
    <link href="<?= base_url('assets/css/') ?>bootstrap-glyphicons.css" rel="stylesheet">
    <link href="<?= base_url('assets/plugin/kartik-upload/') ?>fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<?php endif; ?>


<!-- CONTENT -->
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Produk</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Data Produk</li>
        </ol>
    </div>

    <?= $crud->output; ?>
</div>
<!-- /CONTENT -->

<?php
if ($this->library->nowAccess() == 'produk/index') { ?>

    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <!-- link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.0/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you 
    wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="<?= base_url('assets/plugin/kartik-upload/') ?>piexif.min.js" type="text/javascript"></script>
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
    This must be loaded before fileinput.min.js -->
    <script src="<?= base_url('assets/plugin/kartik-upload/') ?>sortable.min.js" type="text/javascript"></script>
    <!-- bootstrap.min.js below is needed if you wish to zoom and preview file content in a detail modal-->
    <script src="<?= base_url('assets/plugin/kartik-upload/') ?>fileinput.min.js"></script>
    <!-- optionally if you need a theme like font awesome theme you can include it as mentioned below -->
    <script src="<?= base_url('assets/plugin/kartik-upload/') ?>theme.js"></script>
    <!-- optionally if you need translation for your language then include  locale file as mentioned below -->

    <script>
        $(document).ready(function() {
            $("#input-b6").fileinput({
                showUpload: false,
                dropZoneEnabled: false,
                maxFileCount: 10,
                mainClass: "input-group-lg"
            });
        });
    </script>
<?php } ?>