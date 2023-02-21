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
                        <h4 class="card-title mg-b-0">Manajemen Bidang Minat</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Mengatur Bidang Minat Mahasiswa</p>
                    <div class="row mt-4">
                    </div>
                    <?= session()->getFlashdata('message') . "<br>"; ?>
                    <form action="<?= base_url() ?>add_bidang_minat" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="exampleInputPeriode">Bidang Minat</label>
                            <input type="teks" class="form-control" id="exampleInput" placeholder=" Tulis Bidang Minat" name="nama">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPeriode">Deskripsi Bidang Minat</label>
                            <input type="teks" class="form-control" id="exampleInput" placeholder=" Tulis Deskripsi Bidang Minat" name="detail_topik">
                        </div>
                        <div class="form-group">
                            <div class="row row-sm mg-b-20">
                                <div class="col-lg-4">
                                    <label for="exampleInputPeriode">Status</label>
                                    <select name="status" class="form-control select2">
                                        <option value="aktif">
                                            Aktif
                                        </option>
                                        <option value="nonaktif">
                                            Tidak Aktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Tambah</button>
                    </form>
                </div>
                <div class="row mt-3"></div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Data Bidang Minat</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Data Bidang Minat dan Detail</a></p>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mg-b-0 text-md-nowrap" id="validasitable1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;"><span>No.</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Bidang Minat</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Deskripsi Bidang Minat</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Status</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Aksi</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data as $key) {
                                        ?>
                                            <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><?= $key->nama ?></td>
                                                <td><?= $key->detail_topik ?></td>
                                                <td><?= $key->status == 'aktif' ? '<span class="text-success">Aktif</span>' : '<span class="text-danger">Tidak Aktif</span>' ?></td>
                                                <td>
                                                    <input type="hidden" name="id_bimbingan" value="" />
                                                    <div class="btn-group">
                                                        <a class="btn btn-warning btn-sm" data-bs-target="#modalupdate<?= $key->idtopik ?>" data-bs-toggle="modal" href="#"><i class="las la-pen"></i></a>
                                                        <a class="btn btn-danger btn-sm" data-bs-target="#modaldel<?= $key->idtopik ?>" data-bs-toggle="modal" href="#"><i class="las la-trash"></i></a>
                                                    </div>
                                                </td>
                                                <div class="modal" id="modaldel<?= $key->idtopik ?>">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content modal-content-demo">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Hapus Topik</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <form action="<?= base_url() ?>del_bidang_minat" method="POST" enctype="multipart/form-data">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="idtopik" value="<?= $key->idtopik ?>" />
                                                                <div class="modal-body">
                                                                    Apakah anda yakin ingin menghapus topik <b></b> ?
                                                                    <p class="mt-3"></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn ripple btn-danger" type="submit">Hapus</button>
                                                                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Keluar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal" id="modalupdate<?= $key->idtopik ?>">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content modal-content-demo">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Edit Topik</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <form action="<?= base_url() ?>upd_bidang_minat" method="POST" enctype="multipart/form-data">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="idtopik" value="<?= $key->idtopik ?>" />
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputPeriode">Topik</label>
                                                                        <input type="teks" class="form-control" id="exampleInput" value="<?= $key->nama ?>" name="nama">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="exampleInputPeriode">Detail Topik</label>
                                                                        <input type="teks" class="form-control" id="exampleInput" value="<?= $key->detail_topik ?>" name="detail_topik">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="row row-sm mg-b-20">
                                                                            <div class="col-lg-4">
                                                                                <label for="exampleInputPeriode">Status</label>
                                                                                <select name="status" class="form-control select">
                                                                                    <option value="aktif" <?= $key->status == 'aktif' ? 'selected' : '' ?>>
                                                                                        Aktif
                                                                                    </option>
                                                                                    <option value="nonaktif" <?= $key->status != 'aktif' ? 'selected' : '' ?>>
                                                                                        Tidak Aktif
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn ripple btn-primary" type="submit">Update</button>
                                                                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Keluar</button>
                                                                    </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        <?php $no++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>