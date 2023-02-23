<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Akun_Khusus extends BaseController
{
    public function __construct()
    {
        $this->api = new Access_API();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'admin') {
            return redirect()->to('/');
        }
        $data = [
            'tab' => 'Data Dosen',
            'title' => 'Data Korprodi',
            'db' => $this->db,
            'data' => $this->db->query("SELECT a.*,b.`nama`,b.`gelardepan`,b.`gelarbelakang` FROM (SELECT a.*,b.`namaunit` AS fakultas FROM
            (SELECT a.*,b.`namaunit` AS jurusan, b.`parentunit` AS idunitfakultas
            FROM (SELECT a.*,c.`namaunit` AS prodi,c.`parentunit` AS idunitjurusan FROM tb_dekan a LEFT JOIN tb_dosen b ON a.`nip`=b.`nip` LEFT JOIN tb_unit c ON b.`idunit`=c.`idunit`) AS a 
            LEFT JOIN tb_unit b ON a.idunitjurusan = b.`idunit`) AS a
            LEFT JOIN tb_unit b ON a.idunitfakultas = b.`idunit`) AS a
            LEFT JOIN tb_dosen b ON a.nip=b.`nip`")->getResult(),
            'dosen' => $this->db->query("SELECT * FROM tb_dosen")->getResult()

        ];
        return view('Admin/data_akun_khusus', $data);
    }
    public function add()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'admin') {
            return redirect()->to('/');
        }
        if (!$this->validate([
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih Dosen Yang Diberika Akses Khusus'
                ]
            ]
        ])) {
            session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
            <span class="alert-inner--text"><strong>Gagal!</strong> ' . $this->validator->listErrors() . '</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
            return redirect()->to('/data_akun_khusus');
        }
        $nip = $this->request->getPost("nip");
        $cek_nip = $this->db->query("SELECT * FROM tb_dekan WHERE nip='$nip'")->getResult();
        if (count($cek_nip) != 0) {
            session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
            <span class="alert-inner--text"><strong>Gagal!</strong> Dosen telah memiliki akses khusus.</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
            return redirect()->to('/data_akun_khusus');
        }
        $this->db->query("INSERT INTO tb_dekan (nip) VALUES ('$nip')");
        session()->setFlashdata('message', '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>Sukses!</strong> menambahkan akun khusus.</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
        return redirect()->to('/data_akun_khusus');
    }
    public function delete()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'admin') {
            return redirect()->to('/');
        }
        $nip = $this->request->getPost("nip");
        $this->db->query("DELETE FROM tb_dekan WHERE nip = $nip");
        session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>Sukses!</strong> menghapus akun khusus.</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
        return redirect()->to('/data_akun_khusus');
    }
}
