<?php

namespace App\Controllers\Korprodi;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Data_Dosen extends BaseController
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
            'nama_prodi' => $this->db->query("SELECT * FROM tb_unit where idunit='" . session()->get('ses_idunit') . "'")->getResult()[0]->namaunit,
            'title' => 'Data Dosen',
            'data' => $this->db->query("SELECT a.* FROM tb_dosen a WHERE a.`idunit`='" . session()->get('ses_idunit') . "'")->getResult(),
            'db' => $this->db
        ];
        return view('Korprodi/data_dosen', $data);
    }
    public function update()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'korprodi') {
            return redirect()->to('/');
        }
        $nip = $this->request->getPost("nip");
        $p1 = $this->request->getPost("p1");
        $p2 = $this->request->getPost("p2");
        $jum_p1 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip='$nip' AND sebagai='pembimbing 1'")->getResult();
        $jum_p2 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip='$nip' AND sebagai='pembimbing 2'")->getResult();
        if ($jum_p1 == NULL) {
            $this->db->query("INSERT INTO tb_jumlah_pembimbing(nip,jumlah,sebagai,kuota) VALUES ('$nip','0','pembimbing 1','10')");
        } else {
            $this->db->query("UPDATE tb_jumlah_pembimbing SET kuota = '$p1' WHERE nip='$nip' AND sebagai='pembimbing 1'");
        }
        if ($jum_p2 == NULL) {
            $this->db->query("INSERT INTO tb_jumlah_pembimbing(nip,jumlah,sebagai,kuota) VALUES ('$nip','0','pembimbing 2','10')");
        } else {
            $this->db->query("UPDATE tb_jumlah_pembimbing SET kuota = '$p2' WHERE nip='$nip' AND sebagai='pembimbing 2'");
        }
        return redirect()->to('/data_dosen_koorprodi');
    }
}
