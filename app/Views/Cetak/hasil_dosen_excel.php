<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pelaksanaan Sidang</title>
</head>

<body>
    <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Hasil Pelaksanaan Sidang.xls");
    ?>
    <table style="border: 1px solid black;border-collapse: collapse;font-size: 11px" rules="cols" width="100%">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;border: 1px solid black;" rowspan="2"><span>No.</span></th>
                <th style="text-align: center; vertical-align: middle;border: 1px solid black;" rowspan="2"><span>NIP</span></th>
                <th style="text-align: center; vertical-align: middle;border: 1px solid black;" rowspan="2"><span>Nama Dosen</span></th>
                <th style="text-align: center; vertical-align: middle;border: 1px solid black;" rowspan="2"><span>Sebagai</span></th>
                <th style="text-align: center; vertical-align: middle;border: 1px solid black;" rowspan="2"><span>Mahasiwa</span></th>
                <th style="text-align: center; vertical-align: middle;border: 1px solid black;" rowspan="2"><span>Judul Skripsi</span></th>
                <th style="text-align: center; vertical-align: middle;border: 1px solid black;" colspan="2"><span>Nilai</span></th>
            </tr>
            <tr>
                <th style="text-align: center; vertical-align: middle;border: 1px solid black;"><span>Nilai Bimbingan</span></th>
                <th style="text-align: center; vertical-align: middle;border: 1px solid black;"><span>Nilai Sidang</span></th>
            </tr>
        </thead>
        <tbody>

            <?php
            $no = 1;
            foreach ($tb_dosen as $key) {
                $data_mhs = $db->query("SELECT * FROM tb_nilai a LEFT JOIN tb_mahasiswa b ON a.`nim`=b.`nim` WHERE nip='$key->nip' AND (create_at BETWEEN '$date1' AND ('$date2' + INTERVAL 1 DAY))")->getResult();
            ?>

                <?php
                $no2 = 1;
                foreach ($data_mhs as $key2) {
                    $mhs = $db->query("SELECT * FROM tb_mahasiswa WHERE nim = '" . $key2->nim . "'")->getResult();
                    $judul = $db->query("SELECT * FROM tb_pengajuan_topik WHERE nim = '" . $key2->nim . "'")->getResult();
                    $nilai = $db->query("SELECT * FROM tb_mahasiswa WHERE nim = '" . $key2->nim . "'")->getResult();
                    $pembimbing1 = $db->query("SELECT * FROM tb_nilai WHERE nim = '" . $key2->nim . "' AND sebagai='pembimbing 1'")->getResult();
                    $pembimbing2 = $db->query("SELECT * FROM tb_nilai WHERE nim = '" . $key2->nim . "' AND sebagai='pembimbing 2'")->getResult();
                    $penguji1 = $db->query("SELECT * FROM tb_nilai WHERE nim = '" . $key2->nim . "' AND sebagai='penguji 1'")->getResult();
                    $penguji2 = $db->query("SELECT * FROM tb_nilai WHERE nim = '" . $key2->nim . "' AND sebagai='penguji 2'")->getResult();
                    $penguji3 = $db->query("SELECT * FROM tb_nilai WHERE nim = '" . $key2->nim . "' AND sebagai='penguji 3'")->getResult();
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
                    $sidang = $db->query("SELECT * FROM tb_pendaftar_sidang a LEFT JOIN tb_jadwal_sidang b ON a.`id_jadwal`=b.`id_jadwal` WHERE a.`nim`='" . $key2->nim . "' AND b.`jenis_sidang`='sidang skripsi' ORDER BY create_at DESC LIMIT 1")->getResult();
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
                    if ($no2 == 1) { ?>
                        <tr>
                            <td style="text-align: center; vertical-align: middle;border: 1px solid black;" rowspan="<?= count($data_mhs) ?>"><?= $no ?></td>
                            <td style="text-align: left; vertical-align: middle;border: 1px solid black;" rowspan="<?= count($data_mhs) ?>"><?= $key->nip ?></td>
                            <td style="text-align: left; vertical-align: middle;border: 1px solid black;" rowspan="<?= count($data_mhs) ?>"><?= $key->gelardepan . ' ' . $key->nama . ', ' . $key->gelarbelakang; ?></td>
                            <td style="text-align: center; vertical-align: middle;border: 1px solid black;"><?= $key2->sebagai ?></td>
                            <td style="text-align: center; vertical-align: middle;border: 1px solid black;"><?= $key2->nama ?></td>
                            <td style="text-align: center; vertical-align: middle;border: 1px solid black;"><?= $judul[0]->judul_topik ?></td>
                            <td style="text-align: center; vertical-align: middle;border: 1px solid black;">
                                <?php
                                if ($key2->sebagai == 'pembimbing 1') {
                                    echo $nb_pembimbing1;
                                } elseif ($key2->sebagai == 'pembimbing 2') {
                                    echo $nb_pembimbing2;
                                } else {
                                    echo "";
                                }
                                ?>
                            </td>
                            <td style="text-align: center; vertical-align: middle;border: 1px solid black;">
                                <?php
                                if ($key2->sebagai == 'pembimbing 1') {
                                    echo $ns_pembimbing1;
                                } elseif ($key2->sebagai == 'pembimbing 2') {
                                    echo $ns_pembimbing2;
                                } elseif ($key2->sebagai == 'penguji 1') {
                                    echo $ns_penguji1;
                                } elseif ($key2->sebagai == 'penguji 2') {
                                    echo $ns_penguji2;
                                } else {
                                    echo $ns_penguji3;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                    } else {
                    ?>
                        <tr>
                            <td style="text-align: center; vertical-align: middle;border: 1px solid black;"><?= $key2->sebagai ?></td>
                            <td style="text-align: center; vertical-align: middle;border: 1px solid black;"><?= $key2->nama ?></td>
                            <td style="text-align: center; vertical-align: middle;border: 1px solid black;"><?= $judul[0]->judul_topik ?></td>
                            <td style="text-align: center; vertical-align: middle;border: 1px solid black;">
                                <?php
                                if ($key2->sebagai == 'pembimbing 1') {
                                    echo $nb_pembimbing1;
                                } elseif ($key2->sebagai == 'pembimbing 2') {
                                    echo $nb_pembimbing2;
                                } else {
                                    echo "";
                                }
                                ?>
                            </td>
                            <td style="text-align: center; vertical-align: middle;border: 1px solid black;">
                                <?php
                                if ($key2->sebagai == 'pembimbing 1') {
                                    echo $ns_pembimbing1;
                                } elseif ($key2->sebagai == 'pembimbing 2') {
                                    echo $ns_pembimbing2;
                                } elseif ($key2->sebagai == 'penguji 1') {
                                    echo $ns_penguji1;
                                } elseif ($key2->sebagai == 'penguji 2') {
                                    echo $ns_penguji2;
                                } else {
                                    echo $ns_penguji3;
                                }
                                ?>
                            </td>
                        </tr>
            <?php
                    }
                    $no2++;
                }
                $no++;
            }
            ?>
        </tbody>
    </table>
</body>

</html>