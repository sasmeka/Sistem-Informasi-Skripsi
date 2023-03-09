<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Unit extends BaseController
{
    public function __construct()
    {
        $this->api = new Access_API();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        if (session()->get('total_page_unit') == '' && session()->get('total_data_unit') == '') {
            $data = $this->api->get_meta_api("https://api.trunojoyo.ac.id:8212/siakad/v1/unit?page=1&take=1000");
            session()->set('total_data_unit', intval($data->itemCount));
            $total_data = intval($data->itemCount);
        } else {
            $total_data = session()->get('total_data_unit');
        }
        $data = [
            'title' => 'Data Unit',
            'data' => $this->db->query("SELECT * FROM tb_unit")->getResult(),
            'count_data' => $this->db->query("SELECT count(idunit) as jumlah FROM tb_unit")->getResult()[0]->jumlah,
            'db' => $this->db,
            'total_data' => $total_data
        ];
        return view('Admin/data_unit', $data);
    }
    public function update_data_unit()
    {
        set_time_limit(0);
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', '0');
        $this->db->query("TRUNCATE TABLE tb_unit");
        $data1 = $this->api->get_meta_api("https://api.trunojoyo.ac.id:8212/siakad/v1/unit?page=1&take=100");
        $total_page = intval($data1->pageCount);
        function add_data($page, $a)
        {
            $array_data = [];
            $data = $a->api->get_data_api("https://api.trunojoyo.ac.id:8212/siakad/v1/unit?page=$page&take=100");
            foreach ($data as $key) {
                $nama = '"' . $key->namaunit . '"';
                // $cek_data = $a->db->query("SELECT count(idunit) as jumlah from tb_unit where idunit='$key->idunit'")->getResult()[0]->jumlah;
                // if ($cek_data == 0) {
                //     array_push($array_data, "INSERT INTO tb_unit (idunit,namaunit,jenisunit,idjenjang,parentunit,page) VALUES ('" . $key->idunit . "'," . $nama . ", '" . $key->jenisunit . "', '" . $key->idjenjang . "','" . $key->parentunit . "'" . ",$page)");
                // }
                array_push($array_data, "('" . $key->idunit . "'," . $nama . ", '" . $key->jenisunit . "', '" . $key->idjenjang . "','" . $key->parentunit . "'" . ",$page)");
            }
            return $array_data;
        }
        // $r = [];
        for ($i = 1; $i <= $total_page; $i++) {
            $result = add_data($i, $this);
            $rr = implode(', ', $result);
            $this->db->query("INSERT INTO tb_unit (idunit,namaunit,jenisunit,idjenjang,parentunit,page) VALUES $rr");
            // $r = array_merge($r, $result);
        }
        // for ($i = 0; $i < count($result); $i++) {
        //     $this->db->query("$result[$i]");
        // }
        $this->db->query("INSERT INTO tb_log (user,`action`,`log`,date_time) VALUES ('" . session()->get('ses_id') . "','insert or update','Update Data Unit',now())");
        return redirect()->to('/data_unit');
    }
}
