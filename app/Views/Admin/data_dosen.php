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
                            <a class="btn btn-primary btn-sm" href="<?= base_url() ?>update_data_dosen">UPDATE</a>
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
                                            <th style="text-align: center; vertical-align: middle;"><span>E-mail</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Jabatan</span></th>
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
                                            </tr>
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