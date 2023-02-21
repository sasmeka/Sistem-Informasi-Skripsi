<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Logout extends BaseController
{
    public function __construct()
    {
        $this->api = new Access_API();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        $this->db->query("INSERT INTO tb_log (user,`action`,`log`,date_time) VALUES ('" . session()->get('ses_id') . "','logout','Logout " . session()->get('ses_login') . "',now())");
        session()->destroy();
        return redirect()->to('/');
    }
}
