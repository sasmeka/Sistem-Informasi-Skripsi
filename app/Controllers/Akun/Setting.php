<?php

namespace App\Controllers\Akun;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Setting extends BaseController
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
        $data = [
            'title' => 'Setting ' . ucfirst(session()->get('ses_login')),
            'db' => $this->db,
        ];
        return view('Akun/setting', $data);
    }
    public function update_pass()
    {
        if (session()->get('ses_id') == '') {
            return redirect()->to('/');
        }
        $encrypt_pass = $this->db->query("SELECT * FROM tb_users WHERE id='" . session()->get('ses_id') . "'")->getResult()[0]->password;
        if (!$this->validate([
            // 'old_pass' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'Password Lama Harus Diisi.',
            //         'min_length' => 'Password Lama Minimal 8 Karakter'
            //     ]
            // ],
            'new_pass' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Silahkan Masukkan Password Baru.',
                    'min_length' => 'Password Baru Minimal 8 Karakter'
                ]
            ],
            're_new_pass' => [
                'rules' => 'required|matches[new_pass]',
                'errors' => [
                    'required' => 'Silahkan Masukkan Kembali Password Baru.',
                    'matches' => 'Password Harus Sama.'
                ]
            ],
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
        // $old_pass = $this->request->getPost("old_pass");
        $new_pass = $this->request->getPost("new_pass");
        // if (password_verify($old_pass, $encrypt_pass) == false) {
        //     session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
        //     <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
        //     <span class="alert-inner--text"><strong>Gagal!</strong> Password Lama Tidak Sesuai.</span>
        //     <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
        //         <span aria-hidden="true">×</span>
        //     </button>
        // </div>');
        //     return redirect()->back()->withInput();
        // } else {
        $ciphertext = password_hash($new_pass, PASSWORD_DEFAULT);
        $this->db->query("UPDATE tb_users SET password='$ciphertext' WHERE id='" . session()->get('ses_id') . "'");
        session()->setFlashdata('message', '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>Berhasil!</strong> Mengganti Password.</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
        return redirect()->back()->withInput();
        // }
    }
    public function update_universal_pass()
    {
        if (session()->get('ses_id') == '') {
            return redirect()->to('/');
        }
        if (!$this->validate([
            'new_pass' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan Masukkan Password Baru.',
                    'min_length' => 'Password Baru Minimal 8 Karakter'
                ]
            ],
            're_new_pass' => [
                'rules' => 'required|matches[new_pass]',
                'errors' => [
                    'required' => 'Silahkan Masukkan Kembali Password Baru.',
                    'matches' => 'Password Harus Sama.'
                ]
            ],
        ])) {
            session()->setFlashdata('message2', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
            <span class="alert-inner--text"><strong>Gagal!</strong> ' . $this->validator->listErrors() . '</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
            return redirect()->back()->withInput();
        }
        $new_pass = $this->request->getPost("new_pass");
        $ciphertext = password_hash($new_pass, PASSWORD_DEFAULT);
        $this->db->query("UPDATE tb_dekan SET universal_password='$ciphertext' WHERE nip='" . session()->get('ses_id') . "'");
        session()->setFlashdata('message2', '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>Berhasil!</strong> Mengganti Password.</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
        return redirect()->back()->withInput();
    }
}
