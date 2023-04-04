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
        $data1 = $this->api->get_meta_api("https://api.trunojoyo.ac.id:8212/siakad/v1/dosen?page=1&take=100");
        $total_page = intval($data1->pageCount);
        function add_data($page, $a)
        {
            $array_data = [];
            $data = $a->api->get_data_api("https://api.trunojoyo.ac.id:8212/siakad/v1/dosen?page=$page&take=100");
            foreach ($data as $key) {
                $nama = '"' . $key->nama . '"';
                $nip = preg_replace("/[^0-9]/", "", $key->nip);
                $nidn = preg_replace("/[^0-9]/", "", $key->nidn);
                array_push($array_data, "('" . $nip . "','" . $nidn . "', " . $nama . ", '" . $key->gelardepan . "','" . $key->gelarbelakang . "','" . $key->jk . "','" . $key->idunit . "','" . $key->email . "',$page)");
            }
            return $array_data;
        }
        for ($i = 1; $i <= $total_page; $i++) {
            $result = add_data($i, $this);
            $rr = implode(', ', $result);
            $this->db->query("INSERT INTO tb_dosen (nip,nidn,nama,gelardepan,gelarbelakang,jk,idunit,email,page) VALUES $rr");
        }
        $datados = $this->db->query("SELECT * FROM tb_dosen")->getResult();
        foreach ($datados as $key) {
            $dataid = $this->db->query("SELECT * FROM tb_users WHERE id='$key->nip' limit 1")->getResult();
            if (count($dataid) > 0 && $dataid[0]->email != $key->email) {
                $this->db->query("UPDATE tb_users SET email='$key->email' WHERE id='$key->nip';");
            }
            if ($key->email != '' || $key->email != NULL) {
                $datadoscek = $this->db->query("SELECT *,LENGTH(nip) AS jum  FROM tb_dosen WHERE email = '$key->email' ORDER BY jum DESC LIMIT 1")->getResult();
                $nip = $datadoscek[0]->nip;
                $dataemail = $this->db->query("SELECT * FROM tb_users WHERE email='$key->email' limit 1")->getResult();
                if (count($dataemail) > 0 && $dataemail[0]->id != $nip) {
                    $this->db->query("UPDATE tb_acc_revisi SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_berita_acara SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_bimbingan SET `from`='$nip' WHERE `from`='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_bimbingan SET `to`='$nip' WHERE `to`='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_dekan SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_jumlah_pembimbing SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_korprodi SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_log SET user='$nip' WHERE user='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_nilai SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_pengajuan_pembimbing SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_penguji SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_perizinan_sidang SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_profil_tambahan SET id='$nip' WHERE id='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_users SET id='$nip' WHERE id='" . $dataemail[0]->id . "'");
                }
            }
        }
        $this->db->query("INSERT INTO tb_log (user,`action`,`log`,date_time) VALUES ('" . session()->get('ses_id') . "','insert or update','Update Data Dosen',now())");
        return redirect()->to('/data_dosen');
    }
    public function update_data_dosen_perprodi($idunitnew)
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'admin') {
            return redirect()->to('/');
        }
        set_time_limit(0);
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', '0');
        $this->db->query("DELETE FROM tb_dosen WHERE idunit='$idunitnew'");
        $data1 = $this->api->get_meta_api("https://api.trunojoyo.ac.id:8212/siakad/v1/dosen?page=1&take=100");
        $total_page = intval($data1->pageCount);
        function add_data($page, $a, $idunitnew)
        {
            $array_data = [];
            $data = $a->api->get_data_api("https://api.trunojoyo.ac.id:8212/siakad/v1/dosen?page=$page&take=100");
            foreach ($data as $key) {
                $nama = '"' . $key->nama . '"';
                $nip = preg_replace("/[^0-9]/", "", $key->nip);
                $nidn = preg_replace("/[^0-9]/", "", $key->nidn);
                if ($key->idunit == $idunitnew) {
                    array_push($array_data, "('" . $nip . "','" . $nidn . "', " . $nama . ", '" . $key->gelardepan . "','" . $key->gelarbelakang . "','" . $key->jk . "','" . $key->idunit . "','" . $key->email . "',$page)");
                }
            }
            return $array_data;
        }
        $fix_result = [];
        for ($i = 1; $i <= $total_page; $i++) {
            $result = add_data($i, $this, $idunitnew);
            $fix_result = array_merge($fix_result, $result);
        }
        $rr = implode(', ', $fix_result);
        $this->db->query("INSERT INTO tb_dosen (nip,nidn,nama,gelardepan,gelarbelakang,jk,idunit,email,page) VALUES $rr");
        $datados = $this->db->query("SELECT * FROM tb_dosen WHERE idunit='$idunitnew'")->getResult();
        foreach ($datados as $key) {
            $dataid = $this->db->query("SELECT * FROM tb_users WHERE id='$key->nip' limit 1")->getResult();
            if (count($dataid) > 0 && $dataid[0]->email != $key->email) {
                $this->db->query("UPDATE tb_users SET email='$key->email' WHERE id='$key->nip';");
            }
            if ($key->email != '' || $key->email != NULL) {
                $datadoscek = $this->db->query("SELECT *,LENGTH(nip) AS jum  FROM tb_dosen WHERE email = '$key->email' ORDER BY jum DESC LIMIT 1")->getResult();
                $nip = $datadoscek[0]->nip;
                $dataemail = $this->db->query("SELECT * FROM tb_users WHERE email='$key->email' limit 1")->getResult();
                if (count($dataemail) > 0 && $dataemail[0]->id != $nip) {
                    $this->db->query("UPDATE tb_acc_revisi SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_berita_acara SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_bimbingan SET `from`='$nip' WHERE `from`='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_bimbingan SET `to`='$nip' WHERE `to`='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_dekan SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_jumlah_pembimbing SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_korprodi SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_log SET user='$nip' WHERE user='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_nilai SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_pengajuan_pembimbing SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_penguji SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_perizinan_sidang SET nip='$nip' WHERE nip='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_profil_tambahan SET id='$nip' WHERE id='" . $dataemail[0]->id . "'");
                    $this->db->query("UPDATE tb_users SET id='$nip' WHERE id='" . $dataemail[0]->id . "'");
                }
            }
        }
        $this->db->query("INSERT INTO tb_log (user,`action`,`log`,date_time) VALUES ('" . session()->get('ses_id') . "','insert or update','Update Data Dosen',now())");
        return redirect()->to('/data_dosen');
    }
}
