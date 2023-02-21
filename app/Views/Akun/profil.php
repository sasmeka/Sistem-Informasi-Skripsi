<?php

use CodeIgniter\Images\Image;
?>
<?= $this->extend('Template/content') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="<?= base_url() ?>/image/<?= session()->get('ses_image') ?>" alt="Admin" class="rounded-circle" width="150">
                        <div class="mt-3">
                            <h4><?= session()->get('ses_nama') ?></h4>
                            <p class="text-secondary mb-1"><?= session()->get('ses_id') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $data[0]->nama ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <?php
                            if (isset($data[0]->nim)) {
                                echo "<h6 class='mb-0'>NIM</h6>";
                            } else {
                                echo "<h6 class='mb-0'>NIP</h6>";
                            }
                            ?>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php
                            if (isset($data[0]->nim)) {
                                echo $data[0]->nim;
                            } else {
                                echo $data[0]->nip;
                            }
                            ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Program Studi</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $data[0]->namaunit ?>
                        </div>
                    </div>
                    <hr>
                    <?php
                    if (isset($data[0]->nim)) {
                    ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Angkatan</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?= substr($data[0]->idperiode, 0, 4) ?>
                            </div>
                        </div>
                        <hr>
                    <?php } ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">E-mail</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $data[0]->email ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>