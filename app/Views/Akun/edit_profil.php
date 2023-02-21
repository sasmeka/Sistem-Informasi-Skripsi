<?php

use CodeIgniter\Images\Image;
?>
<?= $this->extend('Template/content') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-xl-4">
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Edit Profil</div>
                <div class="card-body text-center">
                    <form action="<?= base_url() ?>proses_edit_profil" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <!-- <div class="upload"> -->
                        <input type="file" name='image_file' accept="image/*" class="dropify" data-default-file="<?= base_url() ?>image/<?= session()->get('ses_image') ?>" data-height="200" />
                        <!-- </div> -->
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">Detail Profil</div>
                <div class="table-responsive border-top userlist-table"></div>
                <div class="card-body">
                    <?= session()->getFlashdata('message') . "<br>"; ?>
                    <div class="mb-3">
                        <label for="">Nama</label>
                        <input class="form-control" id="inputUsername" type="nama" readonly value="<?= $data[0]->nama ?>">
                    </div>
                    <div class="mb-3">
                        <?php
                        if (isset($data[0]->nim)) { ?>
                            <label for="">NIM</label>
                            <input class="form-control" id="inputFirstName" type="nim" readonly value="<?= $data[0]->nim ?>">
                        <?php } else { ?>
                            <label for="">NIP</label>
                            <input class="form-control" id="inputFirstName" type="nip" readonly value="<?= $data[0]->nip ?>">
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="">Prodi</label>
                        <input class="form-control" id="inputLastName" type="idunit" readonly value="<?= $data[0]->namaunit ?>">
                    </div>
                    <?php
                    if (isset($data[0]->nim)) {
                    ?>
                        <div class="mb-3">
                            <label for="">Angkatan</label>
                            <input class="form-control" id="inputOrgName" type="idperiode" readonly value="<?= substr($data[0]->idperiode, 0, 4) ?>">
                        </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label for="">E-Mail</label>
                        <input class="form-control" id="inputOrgName" type="email" readonly value="<?= $data[0]->email ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">No. Handphone</label>
                        <input class="form-control" id="inputOrgName" type="no" readonly value="<?= $data[0]->email ?>">
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>