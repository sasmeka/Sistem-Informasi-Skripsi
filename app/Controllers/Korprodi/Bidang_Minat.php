<?php

namespace App\Controllers\Korprodi;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Bidang_Minat extends BaseController
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
        $idunit = $this->db->query("SELECT * FROM tb_dosen WHERE nip='" . session()->get('ses_id') . "'")->getResult()[0]->idunit;
        $idjurusan = $this->db->query("SELECT c.`idunit` AS idjurusan FROM tb_dosen a LEFT JOIN tb_unit b ON a.`idunit`=b.idunit LEFT JOIN tb_unit c ON b.`parentunit`=c.`idunit` WHERE a.nip='" . session()->get('ses_id') . "'")->getResult()[0]->idjurusan;
        $data = [
            'title' => 'Bidang Minat',
            'db' => $this->db,
            'idunit' => $idunit,
            'idjurusan' => $idjurusan,
            'data' => $this->db->query("SELECT * FROM tb_topik WHERE idunit='$idunit'")->getResult(),
        ];
        return view('Korprodi/bidang_minat', $data);
    }
    public function add()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'korprodi') {
            return redirect()->to('/');
        }
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukkan topik'
                ]
            ],
            'detail_topik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukkan detail topik.'
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
            return redirect()->back()->withInput();
        }
        $nama = $this->request->getPost('nama');
        $detail_topik = $this->request->getPost('detail_topik');
        $status = $this->request->getPost('status');
        $this->db->query("INSERT INTO tb_topik (nama,detail_topik,idunit,`status`) VALUES ('$nama','$detail_topik','" . session()->get('ses_idunit') . "','$status')");

        session()->setFlashdata("message", '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>Sukses!</strong> Menambahkan topik</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');

        return redirect()->to('/bidang_minat');
    }
    public function del()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'korprodi') {
            return redirect()->to('/');
        }
        $idtopik = $this->request->getPost('idtopik');
        $this->db->query("DELETE FROM tb_topik WHERE idtopik='$idtopik'");

        session()->setFlashdata("message", '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>Sukses!</strong> Menghapus bidang minat</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');

        return redirect()->to('/bidang_minat');
    }
    public function upd()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'korprodi') {
            return redirect()->to('/');
        }
        $idtopik = $this->request->getPost('idtopik');
        $nama = $this->request->getPost('nama');
        $detail_topik = $this->request->getPost('detail_topik');
        $status = $this->request->getPost('status');
        if ($status == '') {
            $status = 'nonaktif';
        }
        $this->db->query("UPDATE tb_topik SET nama='$nama',detail_topik='$detail_topik',`status`='$status' WHERE idtopik='$idtopik'");

        session()->setFlashdata("message", '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>Sukses!</strong> Mengedit bidang minat</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');

        return redirect()->to('/bidang_minat');
    }
}
