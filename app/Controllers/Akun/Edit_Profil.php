<?php

namespace App\Controllers\Akun;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Edit_Profil extends BaseController
{
    public function __construct()
    {
        $this->api = new Access_API();
        $this->db = \Config\Database::connect();

        $this->image = \Config\Services::image();
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
            'title' => 'Edit Profil ' . ucfirst(session()->get('ses_login')),
            'db' => $this->db,
            'data' => $data
        ];
        return view('Akun/edit_profil', $data);
    }
    public function proses()
    {
        if (session()->get('ses_id') == '') {
            return redirect()->to('/');
        }

        if (!$this->validate([
            'image_file' => [
                // 'rules' => 'uploaded[berkas]|mime_in[berkas,application/pdf]|max_size[berkas,2048]',
                'rules' => 'mime_in[image_file,image/jpg,image/jpeg]|max_size[image_file,2048]',
                'errors' => [
                    // 'uploaded' => 'Harus Ada File yang diupload',
                    'mime_in' => 'File Extention Harus Berupa JPG/JPEG',
                    'max_size' => 'Ukuran File Maksimal 2 MB'
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
        $image = $this->request->getFile('image_file');
        $name = $image->getRandomName();
        if ($image->getName() != '') {
            if ($image->move(WRITEPATH . '../public/image/', $name)) {
                session()->set('ses_image', $name);
                $this->image->withFile(WRITEPATH . '../public/image/' . $name);
                $this->image->fit(300, 300, 'center');
                $this->image->save(WRITEPATH . '../public/image/' . $name);
                $this->db->query("UPDATE tb_profil_tambahan SET `image` = '$name' WHERE id='" . session()->get('ses_id') . "'");
                session()->setFlashdata("message", '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>Sukses!</strong> update profil.</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
                $this->db->query("INSERT INTO tb_log (user,`action`,`log`,date_time) VALUES ('" . session()->get('ses_id') . "','update profil','Update foto profil',now())");
            } else {
                session()->setFlashdata("message", '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
            <span class="alert-inner--text"><strong>Gagal!</strong> update profil.</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
            }
        } else {
            session()->set('ses_image', 'Profile_Default.png');
            $this->db->query("UPDATE tb_profil_tambahan SET `image` = 'Profile_Default.png' WHERE id='" . session()->get('ses_id') . "'");
            session()->setFlashdata("message", '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>Sukses!</strong> Hapus foto profil.</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
            $this->db->query("INSERT INTO tb_log (user,`action`,`log`,date_time) VALUES ('" . session()->get('ses_id') . "','update profil','Hapus foto profil',now())");
        }
        return redirect()->to('/edit_profil');
    }
}
