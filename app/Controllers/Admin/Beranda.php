<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Beranda extends BaseController
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
            'title' => 'Beranda Admin',
            'db' => $this->db,
        ];
        // return view('Admin/beranda_admin', $data);
        return view('kosong', $data);
    }
}
