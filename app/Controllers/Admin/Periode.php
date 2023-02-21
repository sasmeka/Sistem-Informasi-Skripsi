<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Periode extends BaseController
{
    public function __construct()
    {
        $this->api = new Access_API();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        if (session()->get('total_page_periode') == '' && session()->get('total_data_periode') == '') {
            $data = $this->api->get_meta_api("https://api.trunojoyo.ac.id:8212/siakad/v1/periode?page=1&take=1000");
            session()->set('total_data_periode', intval($data->itemCount));
            $total_data = intval($data->itemCount);
        } else {
            $total_data = session()->get('total_data_periode');
        }
        $data = [
            'title' => 'Data Periode',
            'data' => $this->db->query("SELECT * FROM tb_periode")->getResult(),
            'count_data' => $this->db->query("SELECT count(idperiode) as jumlah FROM tb_periode")->getResult()[0]->jumlah,
            'db' => $this->db,
            'total_data' => $total_data
        ];
        return view('Admin/data_periode', $data);
    }
    public function update_data_periode()
    {
        set_time_limit(0);
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', '0');
        $this->db->query("TRUNCATE TABLE tb_periode");
        $data1 = $this->api->get_meta_api("https://api.trunojoyo.ac.id:8212/siakad/v1/periode?page=1&take=1000");
        $total_page = intval($data1->pageCount);
        function add_data($page, $a)
        {
            $array_data = [];
            $data = $a->api->get_data_api("https://api.trunojoyo.ac.id:8212/siakad/v1/periode?page=$page&take=1000");
            foreach ($data as $key) {
                $nama = '"' . $key->namaperiode . '"';
                $cek_data = $a->db->query("SELECT count(idperiode) as jumlah from tb_periode where idperiode='$key->idperiode'")->getResult()[0]->jumlah;
                if ($cek_data == 0) {
                    array_push($array_data, "INSERT INTO tb_periode (idperiode,namaperiode,page) VALUES ('" . $key->idperiode . "'," . $nama . ",$page)");
                }
            }
            return $array_data;
        }
        $r = [];
        for ($i = 1; $i <= $total_page; $i++) {
            $result = add_data($i, $this);
            $r = array_merge($r, $result);
        }
        for ($i = 0; $i < count($r); $i++) {
            $this->db->query("$r[$i]");
        }
        $this->db->query("INSERT INTO tb_log (user,`action`,`log`,date_time) VALUES ('" . session()->get('ses_id') . "','insert or update','Update Data Periode',now())");
        return redirect()->to('/data_periode');
    }
}
