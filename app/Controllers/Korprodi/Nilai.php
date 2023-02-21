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
            'data_mhs' => $this->db->query("SELECT * FROM tb_users WHERE idunit='" . session()->get('ses_idunit') . "' AND role='mahasiswa'")->getResult(),
        ];
        return view('Korprodi/daftar_nilai', $data);
    }
}
