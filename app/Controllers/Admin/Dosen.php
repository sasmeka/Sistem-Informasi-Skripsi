<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Dosen extends BaseController
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
        if (session()->get('total_page_ds') == '' && session()->get('total_data_ds') == '') {
            $data = $this->api->get_meta_api("https://api.trunojoyo.ac.id:8212/siakad/v1/dosen?page=1&take=1000");
            session()->set('total_data_ds', intval($data->itemCount));
            $total_data = intval($data->itemCount);
        } else {
            $total_data = session()->get('total_data_ds');
        }
        $data = [
            'tab' => 'Data Dosen',
            'title' => 'Data Fakultas',
            'data' => $this->db->query("SELECT * FROM tb_unit where jenisunit='F'")->getResult(),
            'count_data' => $this->db->query("SELECT count(nip) as jumlah FROM tb_dosen")->getResult()[0]->jumlah,
            'db' => $this->db,
            'total_data' => $total_data
        ];
        return view('Admin/data_fakultas', $data);
    }
    public function jurusan_dosen($id)
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'admin') {
            return redirect()->to('/');
        }
        if (session()->get('total_page_ds') == '' && session()->get('total_data_ds') == '') {
            $data = $this->api->get_meta_api("https://api.trunojoyo.ac.id:8212/siakad/v1/dosen?page=1&take=1000");
            session()->set('total_data_ds', intval($data->itemCount));
            $total_data = intval($data->itemCount);
        } else {
            $total_data = session()->get('total_data_ds');
        }
        $data = [
            'nama_fakultas' => $this->db->query("SELECT * FROM tb_unit where idunit='$id'")->getResult()[0]->namaunit,
            'tab' => 'Data Dosen',
            'title' => 'Data Jurusan',
            'data' => $this->db->query("SELECT * FROM tb_unit where jenisunit='J' and parentunit='$id'")->getResult(),
            'count_data' => $this->db->query("SELECT count(nip) as jumlah FROM tb_dosen")->getResult()[0]->jumlah,
            'db' => $this->db,
            'total_data' => $total_data
        ];
        return view('Admin/data_jurusan', $data);
    }
    public function prodi_dosen($id)
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'admin') {
            return redirect()->to('/');
        }
        if (session()->get('total_page_ds') == '' && session()->get('total_data_ds') == '') {
            $data = $this->api->get_meta_api("https://api.trunojoyo.ac.id:8212/siakad/v1/dosen?page=1&take=1000");
            session()->set('total_data_ds', intval($data->itemCount));
            $total_data = intval($data->itemCount);
        } else {
            $total_data = session()->get('total_data_ds');
        }
        $data = [
            'nama_jurusan' => $this->db->query("SELECT * FROM tb_unit where idunit='$id'")->getResult()[0]->namaunit,
            'tab' => 'Data Dosen',
            'title' => 'Data Jurusan',
            'data' => $this->db->query("SELECT * FROM tb_unit where jenisunit='P' and parentunit='$id'")->getResult(),
            'count_data' => $this->db->query("SELECT count(nip) as jumlah FROM tb_dosen")->getResult()[0]->jumlah,
            'db' => $this->db,
            'total_data' => $total_data
        ];
        return view('Admin/data_prodi', $data);
    }
    public function detail_data_dosen($id)
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'admin') {
            return redirect()->to('/');
        }
        if (session()->get('total_page_ds') == '' && session()->get('total_data_ds') == '') {
            $data = $this->api->get_meta_api("https://api.trunojoyo.ac.id:8212/siakad/v1/dosen?page=1&take=1000");
            session()->set('total_data_ds', intval($data->itemCount));
            $total_data = intval($data->itemCount);
        } else {
            $total_data = session()->get('total_data_ds');
        }
        $data = [
            'tab' => 'Data Dosen',
            'nama_prodi' => $this->db->query("SELECT * FROM tb_unit where idunit='$id'")->getResult()[0]->namaunit,
            'title' => 'Data Dosen',
            'data' => $this->db->query("SELECT a.*,b.`namaunit` FROM tb_dosen a LEFT JOIN tb_unit b ON a.`idunit`=b.`idunit` WHERE a.idunit='$id'")->getResult(),
            'korprodi' => $this->db->query("SELECT COUNT(a.nip) AS cek,a.nip,b.namaunit FROM tb_korprodi a left join tb_unit b on a.idunit=b.idunit WHERE a.idunit='$id'")->getResult()[0],
            'count_data' => $this->db->query("SELECT count(nip) as jumlah FROM tb_dosen")->getResult()[0]->jumlah,
            'db' => $this->db,
            'total_data' => $total_data
        ];
        return view('Admin/data_dosen', $data);
    }
    public function update_data_dosen()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'admin') {
            return redirect()->to('/');
        }
        set_time_limit(0);
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', '0');
        $this->db->query("TRUNCATE TABLE tb_dosen");
        $data1 = $this->api->get_meta_api("https://api.trunojoyo.ac.id:8212/siakad/v1/dosen?page=1&take=1000");
        $total_page = intval($data1->pageCount);
        function add_data($page, $a)
        {
            $array_data = [];
            $data = $a->api->get_data_api("https://api.trunojoyo.ac.id:8212/siakad/v1/dosen?page=$page&take=1000");
            foreach ($data as $key) {
                $nama = '"' . $key->nama . '"';
                $nip = preg_replace("/[^0-9]/", "", $key->nip);
                $nidn = preg_replace("/[^0-9]/", "", $key->nidn);
                $cek_data = $a->db->query("SELECT count(nip) as jumlah from tb_dosen where nip='$nip'")->getResult()[0]->jumlah;
                if ($cek_data == 0) {
                    array_push($array_data, "INSERT INTO tb_dosen (nip,nidn,nama,gelardepan,gelarbelakang,jk,idunit,email,page) VALUES ('" . $nip . "','" . $nidn . "', " . $nama . ", '" . $key->gelardepan . "','" . $key->gelarbelakang . "','" . $key->jk . "','" . $key->idunit . "','" . $key->email . "',$page)");
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
        $this->db->query("INSERT INTO tb_log (user,`action`,`log`,date_time) VALUES ('" . session()->get('ses_id') . "','insert or update','Update Data Dosen',now())");
        return redirect()->to('/data_dosen');
    }
}
