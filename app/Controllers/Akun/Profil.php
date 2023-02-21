<?php

namespace App\Controllers\Akun;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Profil extends BaseController
{
    public function __construct()
    {
        $this->api = new Access_API();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        if (session()->get('ses_id') == '') {
            return redirect()->to('/');
        }
        function data($a, $id)
        {
            $data_master_mhs = $a->query("SELECT * FROM tb_mahasiswa a LEFT JOIN tb_unit b ON a.`idunit`=b.`idunit` WHERE a.nim='" . $id . "'")->getResult();
            $data_master_dosen = $a->query("SELECT * FROM tb_dosen a LEFT JOIN tb_unit b ON a.`idunit`=b.`idunit` where a.nip='" . $id . "'")->getResult();
            if (count($data_master_mhs) > 0) {
                return $data_master_mhs;
            } elseif (count($data_master_dosen) > 0) {
                return $data_master_dosen;
            } else {
            }
        }
        $data = data($this->db, session()->get('ses_id'));
        $data = [
            'title' => 'Profil ' . ucfirst(session()->get('ses_login')),
            'db' => $this->db,
            'data' => $data
        ];
        return view('Akun/profil', $data);
    }
}
