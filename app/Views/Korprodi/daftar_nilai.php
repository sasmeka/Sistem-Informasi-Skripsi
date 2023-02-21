<?php

use CodeIgniter\Images\Image;
?>
<?= $this->extend('Template/content') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-cl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="card-title mg-b-0">Daftar Nilai Ujian Skripsi</div>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Daftar Nilai</p>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mg-b-0 text-md-nowrap" id="validasitable1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;"><span>No.</span></th>
                                            <th style="text-align: center; vertical-align: middle;"><span>Nim</span></th>
                                            <th style="text-align: center; vertical-align: middle;" class="col-sm-7 col-md-6 col-lg-2"><span>Nama</span></th>
                                            <th style="text-align: center; vertical-align: middle;" class="col-sm-7 col-md-6 col-lg-4"><span>Judul Skripsi</span></th>
                                            <th style="text-align: center; vertical-align: middle;" class="col-sm-7 col-md-6 col-lg-3"><span>Nilai Bimbingan</span></th>
                                            <th style="text-align: center; vertical-align: middle;" class="col-sm-7 col-md-6 col-lg-3"><span>Nilai Ujian Skripsi</span></th>
                                            <th style=" text-align: center; vertical-align: middle;" class="col-sm-7 col-md-6 col-lg-4"><span>Nilai Akhir Angka</span></th>
                                            <th style=" text-align: center; vertical-align: middle;" class="col-sm-7 col-md-6 col-lg-4"><span>Nilai Akhir Huruf</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data_mhs as $key) {
                                            $mhs = $db->query("SELECT * FROM tb_mahasiswa WHERE nim = '" . $key->id . "'")->getResult();
                                            $judul = $db->query("SELECT * FROM tb_pengajuan_topik WHERE nim = '" . $key->id . "'")->getResult();
                                            $nilai = $db->query("SELECT * FROM tb_mahasiswa WHERE nim = '" . $key->id . "'")->getResult();
                                            $pembimbing1 = $db->query("SELECT * FROM tb_nilai WHERE nim = '" . $key->id . "' AND sebagai='pembimbing 1'")->getResult();
                                            $pembimbing2 = $db->query("SELECT * FROM tb_nilai WHERE nim = '" . $key->id . "' AND sebagai='pembimbing 2'")->getResult();
                                            $penguji1 = $db->query("SELECT * FROM tb_nilai WHERE nim = '" . $key->id . "' AND sebagai='penguji 1'")->getResult();
                                            $penguji2 = $db->query("SELECT * FROM tb_nilai WHERE nim = '" . $key->id . "' AND sebagai='penguji 2'")->getResult();
                                            $penguji3 = $db->query("SELECT * FROM tb_nilai WHERE nim = '" . $key->id . "' AND sebagai='penguji 3'")->getResult();
                                            if (!empty($pembimbing1)) {
                                                $nb_pembimbing1 = $pembimbing1[0]->nilai_bimbingan == NULL ? 0 : $pembimbing1[0]->nilai_bimbingan;
                                                $ns_pembimbing1 = $pembimbing1[0]->nilai_ujian == NULL ? 0 : $pembimbing1[0]->nilai_ujian;
                                            } else {
                                                $nb_pembimbing1 = 0;
                                                $ns_pembimbing1 = 0;
                                            }
                                            if (!empty($pembimbing2)) {
                                                $nb_pembimbing2 = $pembimbing2[0]->nilai_bimbingan == NULL ? 0 : $pembimbing2[0]->nilai_bimbingan;
                                                $ns_pembimbing2 = $pembimbing2[0]->nilai_ujian == NULL ? 0 : $pembimbing2[0]->nilai_ujian;
                                            } else {
                                                $nb_pembimbing2 = 0;
                                                $ns_pembimbing2 = 0;
                                            }
                                            if (!empty($penguji1)) {
                                                $ns_penguji1 = $penguji1[0]->nilai_ujian == NULL ? 0 : $penguji1[0]->nilai_ujian;
                                            } else {
                                                $ns_penguji1 = 0;
                                            }
                                            if (!empty($penguji2)) {
                                                $ns_penguji2 = $penguji2[0]->nilai_ujian == NULL ? 0 : $penguji2[0]->nilai_ujian;
                                            } else {
                                                $ns_penguji2 = 0;
                                            }
                                            if (!empty($penguji3)) {
                                                $ns_penguji3 = $penguji3[0]->nilai_ujian == NULL ? 0 : $penguji3[0]->nilai_ujian;
                                            } else {
                                                $ns_penguji3 = 0;
                                            }
                                            $nb = (($nb_pembimbing1 + $nb_pembimbing2) / 2) * (60 / 100);
                                            $ns = (($ns_pembimbing1 + $ns_pembimbing2 + $ns_penguji1 + $ns_penguji2 + $ns_penguji3) / 5) * (40 / 100);
                                            $total = $nb + $ns;
                                            $sidang = $db->query("SELECT * FROM tb_pendaftar_sidang a LEFT JOIN tb_jadwal_sidang b ON a.`id_jadwal`=b.`id_jadwal` WHERE a.`nim`='" . $key->id . "' AND b.`jenis_sidang`='sidang skripsi' ORDER BY create_at DESC LIMIT 1")->getResult();
                                            if (!empty($sidang)) {
                                                if ($total >= 80) {
                                                    $grade = "A";
                                                } elseif ($total >= 75 && $total <= 79) {
                                                    $grade = "B+";
                                                } elseif ($total >= 70 && $total <= 74) {
                                                    $grade = "B";
                                                } elseif ($total >= 65 && $total <= 69) {
                                                    $grade = "C+";
                                                } elseif ($total >= 60 && $total <= 64) {
                                                    $grade = "C";
                                                } elseif ($total >= 55 && $total <= 59) {
                                                    $grade = "D+";
                                                } elseif ($total >= 50 && $total <= 54) {
                                                    $grade = "D";
                                                } else {
                                                    $grade = "E";
                                                }
                                            } else {
                                                $grade = "<span class='text-danger ms-2'>Belum Mendaftar Sidang Skripsi</span>";
                                            }
                                        ?>
                                            <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><?= $key->id ?></td>
                                                <td><?= $mhs[0]->nama ?></td>
                                                <td><?= $judul[0]->judul_topik ?></td>
                                                <td><?= $nb ?></td>
                                                <td><?= $ns ?></td>
                                                <td><?= $total ?></td>
                                                <td><?= $grade ?></td>
                                            </tr>
                                        <?php $no++;
                                        } ?>
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