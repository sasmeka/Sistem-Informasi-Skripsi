<?php

namespace App\Controllers\Korprodi;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Nilai extends BaseController
{
    public function __construct()
    {
        $this->api = new Access_API();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'korprodi') {
            return redirect()->to('/');
        }
        $data = [
            'title' => 'Daftar Nilai Ujian Skripsi',
            'db' => $this->db,
            'data_mhs' => $this->db->query("SELECT * FROM tb_users WHERE idunit='" . session()->get('ses_idunit') . "' AND role='mahasiswa' ORDER BY id ASC")->getResult(),
            'data_periode' => $this->db->query("SELECT * FROM tb_periode")->getResult(),
            'data_jadwal' => $this->db->query("SELECT * FROM tb_jadwal_sidang WHERE idunit='" . session()->get('ses_idunit') . "' AND jenis_sidang='sidang skripsi'")->getResult(),
        ];
        return view('Korprodi/daftar_nilai', $data);
    }
    public function export()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'korprodi') {
            return redirect()->to('/');
        }
        $idperiode = $this->request->getPost("id_periode");
        $id_jadwal = $this->request->getPost("id_jadwal");
        if ($idperiode == '') {
            if ($id_jadwal == '') {
                $data = $this->db->query("SELECT * FROM tb_users a LEFT JOIN tb_mahasiswa b ON a.`id`=b.`nim` WHERE a.`idunit`='" . session()->get('ses_idunit') . "' AND a.role='mahasiswa' ORDER BY id ASC")->getResult();
            } else {
                $data = $this->db->query("SELECT * FROM tb_users a LEFT JOIN tb_mahasiswa b ON a.`id`=b.`nim` LEFT JOIN tb_pendaftar_sidang c ON c.`nim`=a.`id` WHERE a.`idunit`='" . session()->get('ses_idunit') . "' AND a.`role`='mahasiswa' AND c.`id_jadwal`='" . $id_jadwal . "' ORDER BY id ASC")->getResult();
            }
        } else {
            if ($id_jadwal == '') {
                $data = $this->db->query("SELECT * FROM tb_users a LEFT JOIN tb_mahasiswa b ON a.`id`=b.`nim` LEFT JOIN tb_pendaftar_sidang c ON c.`nim`=a.`id` WHERE a.`idunit`='" . session()->get('ses_idunit') . "' AND a.`role`='mahasiswa' AND b.`idperiode`='" . $idperiode . "' ORDER BY id ASC")->getResult();
            } else {
                $data = $this->db->query("SELECT * FROM tb_users a LEFT JOIN tb_mahasiswa	b ON a.`id`=b.`nim` LEFT JOIN tb_pendaftar_sidang c ON c.`nim`=a.`id` WHERE a.`idunit`='" . session()->get('ses_idunit') . "' AND a.role='mahasiswa' AND b.`idperiode`='$idperiode' AND c.`id_jadwal`='$id_jadwal' ORDER BY id ASC;")->getResult();
            }
        }
        $data = [
            'title' => 'Daftar Nilai Ujian Skripsi',
            'db' => $this->db,
            'data_mhs' => $data
        ];
        return view('Cetak/export_nilai', $data);
    }
}
