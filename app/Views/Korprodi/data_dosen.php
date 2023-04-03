<?php

use CodeIgniter\Images\Image;
?>
<?= $this->extend('Template/content') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Data Dosen</h4>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Data dosen <?= $nama_prodi ?> yang telah mengakses SISRI.</a></p>
                    <div class="row mt-5">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table text-md-nowrap" id="validasitable1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;"><span>No.</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>NIP</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>NIDN</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Nama</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Jenis Kelamin</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Kuota Bimbingan</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Aksi</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($data as $key) :
                                            $kuota_p1 = $db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip='$key->nip' AND sebagai='pembimbing 1'")->getResult();
                                            $kuota_p2 = $db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip='$key->nip' AND sebagai='pembimbing 2'")->getResult();
                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $key->nip; ?></td>
                                                <td><?= $key->nidn; ?></td>
                                                <td><?= $key->gelardepan . ' ' . $key->nama . ', ' . $key->gelarbelakang; ?></td>
                                                <td><?= $key->jk; ?></td>
                                                <td>
                                                    Pembimbing 1 : <?= $kuota_p1 != NULL ? $kuota_p1[0]->jumlah . '/' . $kuota_p1[0]->kuota : "0/10" ?>
                                                    <br>
                                                    Pembimbing 2 : <?= $kuota_p2 != NULL ? $kuota_p2[0]->jumlah . '/' . $kuota_p2[0]->kuota : "0/10" ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-warning btn-sm" data-bs-target="#modalupdate<?= $key->nip ?>" data-bs-toggle="modal" href="#">Update</a>
                                                </td>
                                            </tr>
                                            <div class="modal" id="modalupdate<?= $key->nip ?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content modal-content-demo">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">Update Data Dosen</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <form action="<?= base_url() ?>update_kuota_dosen" method="POST" enctype="multipart/form-data">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="nip" value="<?= $key->nip ?>" />
                                                            <div class="modal-body">
                                                                <label for="">Kuota pembimbing 1</label>
                                                                <div class="input-group">
                                                                    <input class="form-control form-control-sm" name='p1' type="text" value=" <?= $kuota_p1 != NULL ? $kuota_p1[0]->kuota : "10" ?>">
                                                                </div>
                                                                <label for="" class="mt-2">Kuota Pembimbing 2</label>
                                                                <div class="input-group">
                                                                    <input class="form-control form-control-sm" name='p2' type="text" value=" <?= $kuota_p2 != NULL ? $kuota_p2[0]->kuota : "10" ?>">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn ripple btn-warning" type="submit">Update</button>
                                                                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Keluar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php $no++;
                                        endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3"></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>