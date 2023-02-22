<?php

use CodeIgniter\Images\Image;
?>
<?= $this->extend('Template/content') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">Pengaturan Akun</div>
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-md-8 col-lg-8 col-xl-8">
                            <label class="form-label">Ubah Password</label>
                            <p class="tx-12 tx-gray-500 pt-0">**********************</p>
                        </div>
                        <div class="col-md-4 col-lg-4 col-xl-4">
                            <div class="btn-list">
                                <a aria-controls="multiCollapseExample1" aria-expanded="false" class="btn ripple btn-light plus float-right" href=".multi-collapse" data-bs-toggle="collapse" role="button">Ubah Password</a>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col">
                            <?= session()->getFlashdata('message') != NULL ? session()->getFlashdata('message') . "<br>" : "" ?>
                            <div class="collapse <?= session()->getFlashdata('message') != NULL ? 'show' : ''  ?> multi-collapse" id="multiCollapseExample1">
                                <form action="<?= base_url() ?>/update_pass" method="POST" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <div class="row row-sm">
                                        <!-- <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">Password Lama</label>
                                                <input class="form-control" name="old_pass" placeholder="Isikan Password Lama" type="password">
                                            </div>
                                        </div> -->
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">Password Baru</label>
                                                <input class="form-control" name="new_pass" placeholder="Isikan Password Baru" type="password">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">Verifikasi Password</label>
                                                <input class="form-control" name="re_new_pass" placeholder="Isikan Password Baru" type="password">
                                            </div>
                                        </div>
                                        <div class="col-12"><button class="btn btn-success pd-x-20 mg-t-10" type="submit">Update Password</button>
                                            <a aria-controls="multiCollapseExample1" aria-expanded="false" class="btn ripple btn-light pd-x-20 mg-t-10" href=".multi-collapse" data-bs-toggle="collapse" role="button" class="col-md-10 col-lg-9 col-xl-2 offset-xl-10 pt-4">Tutup</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- <hr> -->
                    <?php

                    $nip_dekan = $db->query("SELECT * FROM tb_dekan WHERE id=1")->getResult()[0]->nip;
                    if (session()->get('ses_id') == $nip_dekan) {
                    ?>
                        <div class="row">
                            <div class="col-md-8 col-lg-8 col-xl-8">
                                <label class="form-label">Ubah Universal Password</label>
                                <p class="tx-12 tx-gray-500 pt-0">**********************</p>
                            </div>
                            <div class="col-md-4 col-lg-4 col-xl-4">
                                <div class="btn-list">
                                    <a aria-controls="multiCollapseExample2" aria-expanded="false" class="btn ripple btn-light plus float-right" href=".multi-collapse2" data-bs-toggle="collapse" role="button">Ubah Universal Password</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= session()->getFlashdata('message2') != NULL ? session()->getFlashdata('message') . "<br>" : "" ?>
                                <div class="collapse <?= session()->getFlashdata('message') != NULL ? 'show' : ''  ?> multi-collapse2" id="multiCollapseExample2">
                                    <form action="<?= base_url() ?>/update_universal_pass" method="POST" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <div class="row row-sm">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label class="form-label">Password Baru</label>
                                                    <input class="form-control" name="new_pass" placeholder="Isikan Password Baru" type="password">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label class="form-label">Verifikasi Password</label>
                                                    <input class="form-control" name="re_new_pass" placeholder="Isikan Password Baru" type="password">
                                                </div>
                                            </div>
                                            <div class="col-12"><button class="btn btn-success pd-x-20 mg-t-10" type="submit">Update Universal Password</button>
                                                <a aria-controls="multiCollapseExample2" aria-expanded="false" class="btn ripple btn-light pd-x-20 mg-t-10" href=".multi-collapse" data-bs-toggle="collapse" role="button" class="col-md-10 col-lg-9 col-xl-2 offset-xl-10 pt-4">Tutup</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>