<?php

use CodeIgniter\Images\Image;
?>
<?= $this->extend('Template/content') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Pengaturan Akun</h4>
                </div>
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
                    $nip_dekan = $db->query("SELECT * FROM tb_dekan WHERE nip='" . session()->get('ses_id') . "'")->getResult()[0]->nip;
                    if (!empty($nip_dekan) && session()->get('ses_id') == $nip_dekan) { ?>
                        <div class="row">
                            <div class="col-md-8 col-lg-8 col-xl-8">
                                <?= session()->getFlashdata('message2') != NULL ? session()->getFlashdata('message2') . "<br>" : "" ?>
                                <label class="form-label"><b>Universal Password</b></label>
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
                                <div class="collapse <?= session()->getFlashdata('message') != NULL ? 'show' : ''  ?> multi-collapse2" id="multiCollapseExample2">
                                    <form action="<?= base_url() ?>update_universal_pass" method="POST" enctype="multipart/form-data">
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
                                                <a aria-controls="multiCollapseExample2" aria-expanded="false" class="btn ripple btn-light pd-x-20 mg-t-10" href=".multi-collapse2" data-bs-toggle="collapse" role="button" class="col-md-10 col-lg-9 col-xl-2 offset-xl-10 pt-4">Tutup</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-4">
                            <div class="col-md-8 col-lg-8 col-xl-8">
                                <?= session()->getFlashdata('message3') != NULL ? session()->getFlashdata('message3') . "<br>" : "" ?>
                                <label class="form-label"><b>Hapus Data Mahasiswa</b></label>
                                <p class="tx-12 tx-gray-500 pt-0">Ini akan mengapus/membersihkan seluruh data mahasiswa, silahkan gunakan dengan hati-hati.<br>Mahasiswa tetap dapat login kembali.</p>
                            </div>
                            <div class="col-md-4 col-lg-4 col-xl-4">
                                <div class="btn-list">
                                    <a aria-controls="multiCollapseExample3" aria-expanded="false" class="btn ripple btn-light plus float-right" href=".multi-collapse3" data-bs-toggle="collapse" role="button">Masukkan NIM</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="collapse <?= session()->getFlashdata('message') != NULL ? 'show' : ''  ?> multi-collapse3" id="multiCollapseExample3">
                                    <form action="<?= base_url() ?>delete_data_mhs" method="POST" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <div class="row row-sm">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label class="form-label">NIM mahasiswa yang akan dihapus/dibersihkan</label>
                                                    <input class="form-control" name="nim" placeholder="Nomor Induk Mahasiswa" type="text">
                                                </div>
                                            </div>
                                            <div class="col-12"><button class="btn btn-danger pd-x-20 mg-t-10" type="submit">Hapus / Bersihkan</button>
                                                <a aria-controls="multiCollapseExample3" aria-expanded="false" class="btn ripple btn-light pd-x-20 mg-t-10" href=".multi-collapse3" data-bs-toggle="collapse" role="button" class="col-md-10 col-lg-9 col-xl-2 offset-xl-10 pt-4">Tutup</a>
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