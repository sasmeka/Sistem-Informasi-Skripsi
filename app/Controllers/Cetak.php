<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library
use App\Libraries\QRcodelib; // Import library
use CodeIgniter\Database\Query;
use Dompdf\Dompdf;
use Dompdf\Options;

class Cetak extends BaseController
{
    public function __construct()
    {
        $this->api = new Access_API();
        $this->qr = new QRcodelib();
        $this->db = \Config\Database::connect();
    }
    public function berkas_mhs_proposal()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'mahasiswa') {
            return redirect()->to('/');
        }
        $id = session()->get('ses_id');
        $data = [
            'title' => 'Berkas Proposal',
            'db' => $this->db,
            'dosen_pembimbing_1' => $this->db->query("SELECT * FROM tb_pengajuan_pembimbing a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` WHERE a.nim='" . $id . "' AND a.status_pengajuan='diterima' AND sebagai='1'")->getResult(),
            'dosen_pembimbing_2' => $this->db->query("SELECT * FROM tb_pengajuan_pembimbing a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` WHERE a.nim='" . $id . "' AND a.status_pengajuan='diterima' AND sebagai='2'")->getResult(),
            'penguji_1' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='1'")->getResult(),
            'penguji_2' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='2'")->getResult(),
            'penguji_3' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='3'")->getResult(),
        ];
        return view('Mahasiswa/Proposal/berkas_proposal', $data);
    }
    public function berkas_mhs_skripsi()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'mahasiswa') {
            return redirect()->to('/');
        }
        $id = session()->get('ses_id');
        $data = [
            'title' => 'Berkas Skripsi',
            'db' => $this->db,
            'dosen_pembimbing_1' => $this->db->query("SELECT * FROM tb_pengajuan_pembimbing a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` WHERE a.nim='" . $id . "' AND a.status_pengajuan='diterima' AND sebagai='1'")->getResult(),
            'dosen_pembimbing_2' => $this->db->query("SELECT * FROM tb_pengajuan_pembimbing a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` WHERE a.nim='" . $id . "' AND a.status_pengajuan='diterima' AND sebagai='2'")->getResult(),
            'penguji_1' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='1'")->getResult(),
            'penguji_2' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='2'")->getResult(),
            'penguji_3' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='3'")->getResult(),
        ];
        return view('Mahasiswa/Skripsi/berkas_sidang', $data);
    }
    public function form_bimbingan_proposal($id, $id_pembimbing)
    {
        if (session()->get('ses_id') == '') {
            return redirect()->to('/');
        }
        if ($id == '') {
            $id = session()->get('ses_id');
        }
        $nama_pembimbing = $this->db->query("SELECT * FROM tb_dosen WHERE nip='$id_pembimbing'")->getResult()[0];
        $disetujui_pada = $this->db->query("SELECT * FROM tb_perizinan_sidang WHERE nip='$id_pembimbing' AND nim='$id' AND jenis_sidang='seminar proposal'")->getResult();
        // ------------------------------------------------------------------
        $data = ['qr' => ''];
        if (!empty($disetujui_pada)) {
            if ($disetujui_pada[0]->status == 'disetujui') {
                $isi = "Disetujui Pada : " . $disetujui_pada[0]->acc_at . " Oleh " . $disetujui_pada[0]->izin_sebagai . " (" . $nama_pembimbing->gelardepan . ' ' . $nama_pembimbing->nama . ', ' . $nama_pembimbing->gelarbelakang . ")";
                $qr = $this->qr->cetakqr($isi);
            } else {
                $qr = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr = '<br>(BELUM DITANDA TANGANI)<br>';
        }
        // ------------------------------------------------------------------
        $data = [
            'title' => 'Form Bimbingan Proposal',
            'baseurl' => base_url(),
            'judul_skripsi' => $this->db->query("SELECT * FROM tb_pengajuan_topik WHERE nim='$id'")->getResult()[0]->judul_topik,
            'nim' => $id,
            'nama' => $this->db->query("SELECT * FROM tb_mahasiswa WHERE nim='$id'")->getResult()[0]->nama,
            'pembimbing' => $this->db->query("SELECT * FROM tb_pengajuan_pembimbing WHERE nip='$id_pembimbing' AND nim='$id' AND status_pengajuan='diterima'")->getResult()[0]->sebagai,
            'nama_pembimbing' => $nama_pembimbing,
            'nip' => $id_pembimbing,
            'data' => $this->db->query("SELECT * FROM tb_bimbingan WHERE `to`='$id' AND `from`='$id_pembimbing' AND pokok_bimbingan!=''  AND kategori_bimbingan='1'")->getResult(),
            'qr' => $qr,
            'db' => $this->db,
        ];
        // return view('Cetak/form_bimbingan_proposal', $data);
        $dompdf = new Dompdf();
        $filename = date('y-m-d-H-i-s');
        $dompdf->loadHtml(view('Cetak/form_bimbingan_proposal', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename, array('Attachment' => false));
        exit();
    }
    public function form_bimbingan_skripsi($id, $id_pembimbing)
    {
        if (session()->get('ses_id') == '') {
            return redirect()->to('/');
        }
        if ($id == '') {
            $id = session()->get('ses_id');
        }
        $nama_pembimbing = $this->db->query("SELECT * FROM tb_dosen WHERE nip='$id_pembimbing'")->getResult()[0];
        $disetujui_pada = $this->db->query("SELECT * FROM tb_perizinan_sidang WHERE nip='$id_pembimbing' AND nim='$id' AND jenis_sidang='skripsi'")->getResult();
        // ------------------------------------------------------------------
        if (!empty($disetujui_pada)) {
            if ($disetujui_pada[0]->status == 'disetujui') {
                $isi = "Disetujui Pada : " . $disetujui_pada[0]->acc_at . " Oleh " . $disetujui_pada[0]->izin_sebagai . " (" . $nama_pembimbing->gelardepan . ' ' . $nama_pembimbing->nama . ', ' . $nama_pembimbing->gelarbelakang . ")";
                $qr = $this->qr->cetakqr($isi);
            } else {
                $qr = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr = '<br>(BELUM DITANDA TANGANI)<br>';
        }
        // ------------------------------------------------------------------
        $data = [
            'title' => 'Form Bimbingan Skripsi',
            'baseurl' => base_url(),
            'judul_skripsi' => $this->db->query("SELECT * FROM tb_pengajuan_topik WHERE nim='$id'")->getResult()[0]->judul_topik,
            'nim' => $id,
            'nama' => $this->db->query("SELECT * FROM tb_mahasiswa WHERE nim='$id'")->getResult()[0]->nama,
            'pembimbing' => $this->db->query("SELECT * FROM tb_pengajuan_pembimbing WHERE nip='$id_pembimbing' AND nim='$id' AND status_pengajuan='diterima'")->getResult()[0]->sebagai,
            'nama_pembimbing' => $nama_pembimbing,
            'nip' => $id_pembimbing,
            'data' => $this->db->query("SELECT * FROM tb_bimbingan WHERE `to`='$id' AND `from`='$id_pembimbing' AND pokok_bimbingan!='' AND kategori_bimbingan='3'")->getResult(),
            'qr' => $qr,
            'db' => $this->db,
        ];
        // return view('Cetak/form_bimbingan_skripsi', $data);
        $dompdf = new Dompdf();
        $filename = date('y-m-d-H-i-s');
        $dompdf->loadHtml(view('Cetak/form_bimbingan_skripsi', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename, array('Attachment' => false));
        exit();
    }
    public function berita_acara_proposal($id)
    {
        if (session()->get('ses_id') == '') {
            return redirect()->to('/');
        }
        if ($id == '') {
            $id = session()->get('ses_id');
        }
        // --------------------------------------------------------------------
        $bc_pembimbing_1 = $this->db->query("SELECT * FROM tb_berita_acara WHERE jenis_sidang='proposal' and nim='$id' and sebagai='pembimbing 1'")->getResult();
        if (!empty($bc_pembimbing_1)) {
            $bc_pembimbing_1nip = $bc_pembimbing_1[0]->nip;
            $data_pembimbing_1 = $this->db->query("SELECT * FROM tb_dosen WHERE nip='" . $bc_pembimbing_1nip . "'")->getResult()[0];
            if ($bc_pembimbing_1[0]->status == 'ditandatangani') {
                $isi = "Disetujui Pada : " . $bc_pembimbing_1[0]->create_at . " Oleh " . $bc_pembimbing_1[0]->sebagai . " (" . $data_pembimbing_1->gelardepan . ' ' . $data_pembimbing_1->nama . ', ' . $data_pembimbing_1->gelarbelakang . ")";
                $qr_pembimbing_1 = $this->qr->cetakqr($isi);
            } else {
                $qr_pembimbing_1 = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr_pembimbing_1 = '<br>(BELUM DITANDA TANGANI)<br>';
        }

        $bc_pembimbing_2 = $this->db->query("SELECT * FROM tb_berita_acara WHERE jenis_sidang='proposal' and nim='$id' and sebagai='pembimbing 2'")->getResult();
        if (!empty($bc_pembimbing_2)) {
            $bc_pembimbing_2nip = $bc_pembimbing_2[0]->nip;
            $data_pembimbing_2 = $this->db->query("SELECT * FROM tb_dosen WHERE nip='" . $bc_pembimbing_2nip . "'")->getResult()[0];
            if ($bc_pembimbing_2[0]->status == 'ditandatangani') {
                $isi = "Disetujui Pada : " . $bc_pembimbing_2[0]->create_at . " Oleh " . $bc_pembimbing_2[0]->sebagai . " (" . $data_pembimbing_2->gelardepan . ' ' . $data_pembimbing_2->nama . ', ' . $data_pembimbing_2->gelarbelakang . ")";
                $qr_pembimbing_2 = $this->qr->cetakqr($isi);
            } else {
                $qr_pembimbing_2 = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr_pembimbing_2 = '<br>(BELUM DITANDA TANGANI)<br>';
        }

        $bc_penguji_1 = $this->db->query("SELECT * FROM tb_berita_acara WHERE jenis_sidang='proposal' and nim='$id' and sebagai='penguji 1'")->getResult();
        if (!empty($bc_penguji_1)) {
            $bc_penguji_1nip = $bc_penguji_1[0]->nip;
            $data_penguji_1 = $this->db->query("SELECT * FROM tb_dosen WHERE nip='" . $bc_penguji_1nip . "'")->getResult()[0];
            if ($bc_penguji_1[0]->status == 'ditandatangani') {
                $isi = "Disetujui Pada : " . $bc_penguji_1[0]->create_at . " Oleh " . $bc_penguji_1[0]->sebagai . " (" . $data_penguji_1->gelardepan . ' ' . $data_penguji_1->nama . ', ' . $data_penguji_1->gelarbelakang . ")";
                $qr_penguji_1 = $this->qr->cetakqr($isi);
            } else {
                $qr_penguji_1 = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr_penguji_1 = '<br>(BELUM DITANDA TANGANI)<br>';
        }

        $bc_penguji_2 = $this->db->query("SELECT * FROM tb_berita_acara WHERE jenis_sidang='proposal' and nim='$id' and sebagai='penguji 2'")->getResult();
        if (!empty($bc_penguji_2)) {
            $bc_penguji_2nip = $bc_penguji_2[0]->nip;
            $data_penguji_2 = $this->db->query("SELECT * FROM tb_dosen WHERE nip='" . $bc_penguji_2nip . "'")->getResult()[0];
            if ($bc_penguji_2[0]->status == 'ditandatangani') {
                $isi = "Disetujui Pada : " . $bc_penguji_2[0]->create_at . " Oleh " . $bc_penguji_2[0]->sebagai . " (" . $data_penguji_2->gelardepan . ' ' . $data_penguji_2->nama . ', ' . $data_penguji_2->gelarbelakang . ")";
                $qr_penguji_2 = $this->qr->cetakqr($isi);
            } else {
                $qr_penguji_2 = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr_penguji_2 = '<br>(BELUM DITANDA TANGANI)<br>';
        }

        $bc_penguji_3 = $this->db->query("SELECT * FROM tb_berita_acara WHERE jenis_sidang='proposal' and nim='$id' and sebagai='penguji 3'")->getResult();
        if (!empty($bc_penguji_3)) {
            $bc_penguji_3nip = $bc_penguji_3[0]->nip;
            $data_penguji_3 = $this->db->query("SELECT * FROM tb_dosen WHERE nip='" . $bc_penguji_3nip . "'")->getResult()[0];
            if ($bc_penguji_3[0]->status == 'ditandatangani') {
                $isi = "Disetujui Pada : " . $bc_penguji_3[0]->create_at . " Oleh " . $bc_penguji_3[0]->sebagai . " (" . $data_penguji_3->gelardepan . ' ' . $data_penguji_3->nama . ', ' . $data_penguji_3->gelarbelakang . ")";
                $qr_penguji_3 = $this->qr->cetakqr($isi);
            } else {
                $qr_penguji_3 = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr_penguji_3 = '<br>(BELUM DITANDA TANGANI)<br>';
        }
        // ------------------------------------------------------------------

        $prodi = $this->db->query("SELECT * FROM tb_unit WHERE idunit='" . session()->get('ses_idunit') . "'")->getResult();
        $jurusan = $this->db->query("SELECT * FROM tb_unit WHERE idunit='" . $prodi[0]->parentunit . "'")->getResult();
        $fakultas = $this->db->query("SELECT * FROM tb_unit WHERE idunit='" . $jurusan[0]->parentunit . "'")->getResult();
        $data = [
            'title' => 'Berita Acara Seminar Proposal',
            'baseurl' => base_url(),
            'judul_skripsi' => $this->db->query("SELECT * FROM tb_pengajuan_topik WHERE nim='$id'")->getResult()[0]->judul_topik,
            'nim' => $id,
            'nama' => $this->db->query("SELECT * FROM tb_mahasiswa WHERE nim='$id'")->getResult()[0]->nama,
            'dosen_pembimbing_1' => $this->db->query("SELECT * FROM tb_pengajuan_pembimbing a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` WHERE a.nim='" . $id . "' AND a.status_pengajuan='diterima' AND sebagai='1'")->getResult(),
            'dosen_pembimbing_2' => $this->db->query("SELECT * FROM tb_pengajuan_pembimbing a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` WHERE a.nim='" . $id . "' AND a.status_pengajuan='diterima' AND sebagai='2'")->getResult(),
            'penguji_1' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='1'")->getResult(),
            'penguji_2' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='2'")->getResult(),
            'penguji_3' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='3'")->getResult(),
            'qr_pembimbing_1' => $qr_pembimbing_1,
            'qr_pembimbing_2' => $qr_pembimbing_2,
            'qr_penguji_1' => $qr_penguji_1,
            'qr_penguji_2' => $qr_penguji_2,
            'qr_penguji_3' => $qr_penguji_3,
            'db' => $this->db,
            'nm_prodi' => $prodi[0]->namaunit,
            'nm_jurusan' => $jurusan[0]->namaunit,
            'nm_fakultas' => $fakultas[0]->namaunit,
        ];
        // return view('Cetak/berita_acara_proposal', $data);
        $dompdf = new Dompdf();
        $filename = date('y-m-d-H-i-s');
        $dompdf->loadHtml(view('Cetak/berita_acara_proposal', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename, array('Attachment' => false));
        exit();
    }
    public function berita_acara_skripsi($id)
    {
        if (session()->get('ses_id') == '') {
            return redirect()->to('/');
        }
        if ($id == '') {
            $id = session()->get('ses_id');
        }
        // --------------------------------------------------------------------
        $bc_pembimbing_1 = $this->db->query("SELECT * FROM tb_berita_acara WHERE jenis_sidang='skripsi' and nim='$id' and sebagai='pembimbing 1'")->getResult();
        if (!empty($bc_pembimbing_1)) {
            $bc_pembimbing_1nip = $bc_pembimbing_1[0]->nip;
            $data_pembimbing_1 = $this->db->query("SELECT * FROM tb_dosen WHERE nip='" . $bc_pembimbing_1nip . "'")->getResult()[0];
            if ($bc_pembimbing_1[0]->status == 'ditandatangani') {
                $isi = "Disetujui Pada : " . $bc_pembimbing_1[0]->create_at . " Oleh " . $bc_pembimbing_1[0]->sebagai . " (" . $data_pembimbing_1->gelardepan . ' ' . $data_pembimbing_1->nama . ', ' . $data_pembimbing_1->gelarbelakang . ")";
                $qr_pembimbing_1 = $this->qr->cetakqr($isi);
            } else {
                $qr_pembimbing_1 = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr_pembimbing_1 = '<br>(BELUM DITANDA TANGANI)<br>';
        }

        $bc_pembimbing_2 = $this->db->query("SELECT * FROM tb_berita_acara WHERE jenis_sidang='skripsi' and nim='$id' and sebagai='pembimbing 2'")->getResult();
        if (!empty($bc_pembimbing_2)) {
            $bc_pembimbing_2nip = $bc_pembimbing_2[0]->nip;
            $data_pembimbing_2 = $this->db->query("SELECT * FROM tb_dosen WHERE nip='" . $bc_pembimbing_2nip . "'")->getResult()[0];
            if ($bc_pembimbing_2[0]->status == 'ditandatangani') {
                $isi = "Disetujui Pada : " . $bc_pembimbing_2[0]->create_at . " Oleh " . $bc_pembimbing_2[0]->sebagai . " (" . $data_pembimbing_2->gelardepan . ' ' . $data_pembimbing_2->nama . ', ' . $data_pembimbing_2->gelarbelakang . ")";
                $qr_pembimbing_2 = $this->qr->cetakqr($isi);
            } else {
                $qr_pembimbing_2 = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr_pembimbing_2 = '<br>(BELUM DITANDA TANGANI)<br>';
        }

        $bc_penguji_1 = $this->db->query("SELECT * FROM tb_berita_acara WHERE jenis_sidang='skripsi' and nim='$id' and sebagai='penguji 1'")->getResult();
        if (!empty($bc_penguji_1)) {
            $bc_penguji_1nip = $bc_penguji_1[0]->nip;
            $data_penguji_1 = $this->db->query("SELECT * FROM tb_dosen WHERE nip='" . $bc_penguji_1nip . "'")->getResult()[0];
            if ($bc_penguji_1[0]->status == 'ditandatangani') {
                $isi = "Disetujui Pada : " . $bc_penguji_1[0]->create_at . " Oleh " . $bc_penguji_1[0]->sebagai . " (" . $data_penguji_1->gelardepan . ' ' . $data_penguji_1->nama . ', ' . $data_penguji_1->gelarbelakang . ")";
                $qr_penguji_1 = $this->qr->cetakqr($isi);
            } else {
                $qr_penguji_1 = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr_penguji_1 = '<br>(BELUM DITANDA TANGANI)<br>';
        }

        $bc_penguji_2 = $this->db->query("SELECT * FROM tb_berita_acara WHERE jenis_sidang='skripsi' and nim='$id' and sebagai='penguji 2'")->getResult();
        if (!empty($bc_penguji_2)) {
            $bc_penguji_2nip = $bc_penguji_2[0]->nip;
            $data_penguji_2 = $this->db->query("SELECT * FROM tb_dosen WHERE nip='" . $bc_penguji_2nip . "'")->getResult()[0];
            if ($bc_penguji_2[0]->status == 'ditandatangani') {
                $isi = "Disetujui Pada : " . $bc_penguji_2[0]->create_at . " Oleh " . $bc_penguji_2[0]->sebagai . " (" . $data_penguji_2->gelardepan . ' ' . $data_penguji_2->nama . ', ' . $data_penguji_2->gelarbelakang . ")";
                $qr_penguji_2 = $this->qr->cetakqr($isi);
            } else {
                $qr_penguji_2 = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr_penguji_2 = '<br>(BELUM DITANDA TANGANI)<br>';
        }

        $bc_penguji_3 = $this->db->query("SELECT * FROM tb_berita_acara WHERE jenis_sidang='skripsi' and nim='$id' and sebagai='penguji 3'")->getResult();
        if (!empty($bc_penguji_3)) {
            $bc_penguji_3nip = $bc_penguji_3[0]->nip;
            $data_penguji_3 = $this->db->query("SELECT * FROM tb_dosen WHERE nip='" . $bc_penguji_3nip . "'")->getResult()[0];
            if ($bc_penguji_3[0]->status == 'ditandatangani') {
                $isi = "Disetujui Pada : " . $bc_penguji_3[0]->create_at . " Oleh " . $bc_penguji_3[0]->sebagai . " (" . $data_penguji_3->gelardepan . ' ' . $data_penguji_3->nama . ', ' . $data_penguji_3->gelarbelakang . ")";
                $qr_penguji_3 = $this->qr->cetakqr($isi);
            } else {
                $qr_penguji_3 = '<br>(BELUM DITANDA TANGANI)<br>';
            }
        } else {
            $qr_penguji_3 = '<br>(BELUM DITANDA TANGANI)<br>';
        }
        // ------------------------------------------------------------------
        $prodi = $this->db->query("SELECT * FROM tb_unit WHERE idunit='" . session()->get('ses_idunit') . "'")->getResult();
        $jurusan = $this->db->query("SELECT * FROM tb_unit WHERE idunit='" . $prodi[0]->parentunit . "'")->getResult();
        $fakultas = $this->db->query("SELECT * FROM tb_unit WHERE idunit='" . $jurusan[0]->parentunit . "'")->getResult();
        $data = [
            'title' => 'Berita Acara Sidang Skripsi',
            'baseurl' => base_url(),
            'judul_skripsi' => $this->db->query("SELECT * FROM tb_pengajuan_topik WHERE nim='$id'")->getResult()[0]->judul_topik,
            'nim' => $id,
            'nama' => $this->db->query("SELECT * FROM tb_mahasiswa WHERE nim='$id'")->getResult()[0]->nama,
            'dosen_pembimbing_1' => $this->db->query("SELECT * FROM tb_pengajuan_pembimbing a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` WHERE a.nim='" . $id . "' AND a.status_pengajuan='diterima' AND sebagai='1'")->getResult(),
            'dosen_pembimbing_2' => $this->db->query("SELECT * FROM tb_pengajuan_pembimbing a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` WHERE a.nim='" . $id . "' AND a.status_pengajuan='diterima' AND sebagai='2'")->getResult(),
            'penguji_1' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='1'")->getResult(),
            'penguji_2' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='2'")->getResult(),
            'penguji_3' => $this->db->query("SELECT * from tb_penguji a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_profil_tambahan c ON a.`nip`=c.`id` where a.nim='" . session()->get('ses_id') . "' AND a.`status`='aktif' AND a.sebagai='3'")->getResult(),
            'qr_pembimbing_1' => $qr_pembimbing_1,
            'qr_pembimbing_2' => $qr_pembimbing_2,
            'qr_penguji_1' => $qr_penguji_1,
            'qr_penguji_2' => $qr_penguji_2,
            'qr_penguji_3' => $qr_penguji_3,
            'db' => $this->db,
            'nm_prodi' => $prodi[0]->namaunit,
            'nm_jurusan' => $jurusan[0]->namaunit,
            'nm_fakultas' => $fakultas[0]->namaunit,
        ];
        // return view('Cetak/berita_acara_skripsi', $data);
        $dompdf = new Dompdf();
        $filename = date('y-m-d-H-i-s');
        $dompdf->loadHtml(view('Cetak/berita_acara_skripsi', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename, array('Attachment' => false));
        exit();
    }
    public function cobaqr()
    {
        $isi = "SUKSES";
        return $this->qr->cetakqr($isi);
    }
}
