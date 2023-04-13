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
                        <?php
                        if ($tab == "Data Dosen") {
                            // if ($count_data < $total_data) { 
                        ?>
                            <!-- <a class="btn btn-primary btn-sm" href="<?= base_url() ?>update_data_dosen">UPDATE</a> -->
                            <?php
                            // }
                        } else {
                            if ($count_data < $total_data) { ?>
                                <a class="btn btn-primary btn-sm" href="<?= base_url() ?>update_data_mhs">UPDATE</a>
                        <?php }
                        }
                        ?>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Data dosen <?= $nama_prodi . ', ' . session()->get('jurusan') . ', ' . session()->get('fakultas') ?> yang telah tersinkronasi dengan Siakad UTM.</a></p>
                    <?= session()->getFlashdata('message') ?>
                    <a class="btn btn-primary  btn-sm mt-1" data-bs-target="#modaladd" id="" data-bs-toggle="modal" href="#">Tambah Dosen</a>
                    <div class="modal" id="modaladd">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <form action="<?= base_url() ?>add_dosen" method="POST" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <div class="modal-header">
                                        <h6 class="modal-title">Tambah Data Dosen</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="">NIP</label>
                                        <small class="text-danger">*</small>
                                        <input class="form-control" id="inputFirstName" type="text" name="nip">
                                        <label for="" class="mt-2">NIDN</label>
                                        <input class="form-control" id="inputFirstName" type="text" name="nidn">
                                        <label for="" class="mt-2">Gelar Depan</label>
                                        <small class="text-danger">( Contoh : Dr. )</small>
                                        <input class="form-control" id="inputFirstName" type="text" name="gelardepan">
                                        <label for="" class="mt-2">Nama</label>
                                        <input class="form-control" id="inputFirstName" type="text" name="nama">
                                        <label for="" class="mt-2">Gelar Bekalang</label>
                                        <small class="text-danger">( Contoh : S.H., M.H.)</small>
                                        <input class="form-control" id="inputFirstName" type="text" name="gelarbelakang">
                                        <label for="" class="mt-2">Jenis Kelamin</label>
                                        <select class="form-control select" name="lk">
                                            <option value='L'>Laki-Laki</option>
                                            <option value='P'>Perempuan</option>
                                        </select>
                                        <label for="" class="mt-2">Program Studi</label>
                                        <select class="form-control select" name="idunit">
                                            <?php
                                            foreach ($data_prodi as $keyp) { ?>
                                                <option value='<?= $keyp->idunit ?>' <?= $keyp->idunit == $id_prodi ? 'selected' : '' ?>><?= $keyp->idjenjang . ' - ' . $keyp->namaunit ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                        <label for="" class="mt-2">E-mail</label>
                                        <small class="text-danger">( Wajib menggunakan email universitas dan terlah terdaftar )</small>
                                        <input class="form-control" id="inputFirstName" type="text" name="email"">
                                    </div>
                                    <div class=" modal-footer">
                                        <button class="btn ripple btn-primary" type="submit">Tambah</button>
                                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Keluar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
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
                                            <th style="text-align: center; vertical-align: middle;"><span>E-mail</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Jabatan</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Aksi</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($data as $key) : ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $key->nip; ?></td>
                                                <td><?= $key->nidn; ?></td>
                                                <td><?= $key->gelardepan . ' ' . $key->nama . ', ' . $key->gelarbelakang; ?></td>
                                                <td><?= $key->jk; ?></td>
                                                <td><?= $key->email; ?></td>
                                                <td><?php
                                                    if ($key->nip == $korprodi->nip) {
                                                        echo "Kepala Prodi " . $korprodi->namaunit;
                                                    }
                                                    ?></td>
                                                <td>
                                                    <a class="btn btn-warning btn-sm mt-1" data-bs-target="#modalupdate<?= $key->id_dosen ?>" id="" data-bs-toggle="modal" href="#">Edit</a>
                                                    <?php if ($key->nip != $korprodi->nip) { ?>
                                                        <a class="btn btn-danger btn-sm mt-1" data-bs-target="#modaldelete<?= $key->id_dosen ?>" id="" data-bs-toggle="modal" href="#">Hapus</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <div class="modal" id="modaldelete<?= $key->id_dosen ?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content modal-content-demo">
                                                        <form action="<?= base_url() ?>delete_dosen" method="POST" enctype="multipart/form-data">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="id_dosen" value="<?= $key->id_dosen ?>">
                                                            <input type="hidden" name="nip" value="<?= $key->nip ?>">
                                                            <input type="hidden" name="idunit" value="<?= $key->idunit ?>">
                                                            <input type="hidden" name="email" value="<?= $key->email ?>">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Hapus Data Dosen</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah anda yakin ingin menghapus <b><?= $key->gelardepan . ' ' . $key->nama . ', ' . $key->gelarbelakang; ?></b> dengan NIP : <b><?= $key->nip; ?></b>, ini akan menghapus seluruh data yang berkaitan dengan dosen tersebut ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn ripple btn-danger" type="submit">Hapus</button>
                                                                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Keluar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal" id="modalupdate<?= $key->id_dosen ?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content modal-content-demo">
                                                        <form action="<?= base_url() ?>edit_dosen" method="POST" enctype="multipart/form-data">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="id_dosen" value="<?= $key->id_dosen ?>">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Edit Data Dosen</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label for="">NIP</label>
                                                                <small class="text-danger">*</small>
                                                                <input class="form-control" id="inputFirstName" type="text" name="nip" value="<?= $key->nip ?>">
                                                                <label for="" class="mt-2">NIDN</label>
                                                                <input class="form-control" id="inputFirstName" type="text" name="nidn" value="<?= $key->nidn ?>">
                                                                <label for="" class="mt-2">Gelar Depan</label>
                                                                <small class="text-danger">( Contoh : Dr. )</small>
                                                                <input class="form-control" id="inputFirstName" type="text" name="gelardepan" value="<?= $key->gelardepan ?>">
                                                                <label for="" class="mt-2">Nama</label>
                                                                <input class="form-control" id="inputFirstName" type="text" name="nama" value="<?= $key->nama ?>">
                                                                <label for="" class="mt-2">Gelar Bekalang</label>
                                                                <small class="text-danger">( Contoh : S.H., M.H.)</small>
                                                                <input class="form-control" id="inputFirstName" type="text" name="gelarbelakang" value="<?= $key->gelarbelakang ?>">
                                                                <label for="" class="mt-2">Jenis Kelamin</label>
                                                                <select class="form-control select" name="lk">
                                                                    <option value='L' <?= $key->jk == 'L' ? 'selected' : '' ?>>Laki-Laki</option>
                                                                    <option value='P' <?= $key->jk == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                                                </select>
                                                                <label for="" class="mt-2">Program Studi</label>
                                                                <select class="form-control select" name="idunit">
                                                                    <?php
                                                                    foreach ($data_prodi as $keyp) { ?>
                                                                        <option value='<?= $keyp->idunit ?>' <?= $key->idunit == $keyp->idunit ? 'selected' : '' ?>><?= $keyp->idjenjang . ' - ' . $keyp->namaunit ?></option>
                                                                    <?php }
                                                                    ?>
                                                                </select>
                                                                <label for="" class="mt-2">E-mail</label>
                                                                <small class="text-danger">( Wajib menggunakan email universitas dan terlah terdaftar )</small>
                                                                <input class="form-control" id="inputFirstName" type="text" name="email" value="<?= $key->email ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn ripple btn-warning" type="submit">Perbarui</button>
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