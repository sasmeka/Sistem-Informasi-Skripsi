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
            'total_data' => $total_data,
            'data_prodi' => $this->db->query("SELECT * FROM tb_unit WHERE jenisunit='P'")->getResult(),
            'id_prodi' => $id
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
        $datados = $this->db->query("SELECT * FROM tb_dosen WHERE (email != NULL OR email != '')")->getResult();
        foreach ($datados as $key) {
            $dataid = $this->db->query("SELECT * FROM tb_users WHERE id='$key->nip' limit 1")->getResult();
            if (count($dataid) > 0 && $dataid[0]->email != $key->email) {
                $this->db->query("UPDATE tb_users SET email='$key->email',idunit='$key->idunit' WHERE id='$key->nip';");
            }
            $nip = $key->nip;
            $idunit = $key->idunit;
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
                $this->db->query("UPDATE tb_users SET id='$nip',idunit='$idunit' WHERE id='" . $dataemail[0]->id . "'");
                $jumlah_p1 = count($this->db->query("SELECT * FROM tb_pengajuan_pembimbing WHERE nip = '$nip' AND sebagai = '1' AND status_pengajuan='diterima'")->getResult());
                $jumlah_p2 = count($this->db->query("SELECT * FROM tb_pengajuan_pembimbing WHERE nip = '$nip' AND sebagai = '2' AND status_pengajuan='diterima'")->getResult());
                $data_jum_bimbingan_p1 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip = '$nip' AND sebagai = 'pembimbing 1'")->getResult();
                $data_jum_bimbingan_p2 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip = '$nip' AND sebagai = 'pembimbing 2'")->getResult();
                foreach ($data_jum_bimbingan_p1 as $kp1) {
                    if ($kp1->jumlah == $jumlah_p1) {
                        $this->db->query("DELETE FROM tb_jumlah_pembimbing WHERE nip='$nip' AND sebagai='pembimbing 1' AND id_jumlah_pembimbing!='" . $kp1->id_jumlah_pembimbing . "'");
                        break;
                    }
                }
                foreach ($data_jum_bimbingan_p2 as $kp2) {
                    if ($kp2->jumlah == $jumlah_p2) {
                        $this->db->query("DELETE FROM tb_jumlah_pembimbing WHERE nip='$nip' AND sebagai='pembimbing 2' AND id_jumlah_pembimbing!='" . $kp2->id_jumlah_pembimbing . "'");
                        break;
                    }
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

        $datados = $this->db->query("SELECT * FROM tb_dosen WHERE (email != NULL OR email != '') AND idunit='$idunitnew'")->getResult();
        foreach ($datados as $key) {
            $dataid = $this->db->query("SELECT * FROM tb_users WHERE id='$key->nip' limit 1")->getResult();
            if (count($dataid) > 0 && $dataid[0]->email != $key->email) {
                $this->db->query("UPDATE tb_users SET email='$key->email',idunit='$key->idunit' WHERE id='$key->nip';");
            }
            $nip = $key->nip;
            $idunit = $key->idunit;
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
                $this->db->query("UPDATE tb_users SET id='$nip',idunit='$idunit' WHERE id='" . $dataemail[0]->id . "'");
                $jumlah_p1 = count($this->db->query("SELECT * FROM tb_pengajuan_pembimbing WHERE nip = '$nip' AND sebagai = '1' AND status_pengajuan='diterima'")->getResult());
                $jumlah_p2 = count($this->db->query("SELECT * FROM tb_pengajuan_pembimbing WHERE nip = '$nip' AND sebagai = '2' AND status_pengajuan='diterima'")->getResult());
                $data_jum_bimbingan_p1 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip = '$nip' AND sebagai = 'pembimbing 1'")->getResult();
                $data_jum_bimbingan_p2 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip = '$nip' AND sebagai = 'pembimbing 2'")->getResult();
                foreach ($data_jum_bimbingan_p1 as $kp1) {
                    if ($kp1->jumlah == $jumlah_p1) {
                        $this->db->query("DELETE FROM tb_jumlah_pembimbing WHERE nip='$nip' AND sebagai='pembimbing 1' AND id_jumlah_pembimbing!='" . $kp1->id_jumlah_pembimbing . "'");
                        break;
                    }
                }
                foreach ($data_jum_bimbingan_p2 as $kp2) {
                    if ($kp2->jumlah == $jumlah_p2) {
                        $this->db->query("DELETE FROM tb_jumlah_pembimbing WHERE nip='$nip' AND sebagai='pembimbing 2' AND id_jumlah_pembimbing!='" . $kp2->id_jumlah_pembimbing . "'");
                        break;
                    }
                }
            }
        }
        $this->db->query("INSERT INTO tb_log (user,`action`,`log`,date_time) VALUES ('" . session()->get('ses_id') . "','insert or update','Update Data Dosen',now())");
        return redirect()->to('/data_dosen');
    }
    public function delete()
    {
        set_time_limit(0);
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', '0');
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'admin') {
            return redirect()->to('/');
        }
        $nip = $this->request->getPost("nip");
        $idunit = $this->request->getPost("idunit");
        $id_dosen = $this->request->getPost("id_dosen");
        $email = $this->request->getPost("email");
        $cek_p1 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing a LEFT JOIN tb_users b ON a.`nip`=b.`id` WHERE a.`nip`='$nip' AND b.`email`='$email' AND a.`sebagai`='pembimbing 1'")->getResult();
        $cek_p2 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing a LEFT JOIN tb_users b ON a.`nip`=b.`id` WHERE a.`nip`='$nip' AND b.`email`='$email' AND a.`sebagai`='pembimbing 2'")->getResult();
        if ((count($cek_p1) && $cek_p1[0]->jumlah > 0) || (count($cek_p2) && $cek_p2[0]->jumlah > 0)) {
            session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
            <span class="alert-inner--text"><strong>Gagal!</strong> Dosen/NIP tersebut masih dalam tanggungan bimbingan.</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
            return redirect()->back()->withInput();
        } else {
            $this->db->query("DELETE FROM tb_dosen WHERE id_dosen ='$id_dosen' AND nip='$nip'");
            $this->db->query("DELETE FROM tb_users WHERE id='$nip' AND email='$email'");
            $this->db->query("DELETE FROM tb_acc_revisi WHERE nip='$nip'");
            $this->db->query("DELETE FROM tb_berita_acara WHERE nip='$nip'");
            $this->db->query("DELETE FROM tb_bimbingan WHERE `from`='$nip'");
            $this->db->query("DELETE FROM tb_bimbingan WHERE `to`='$nip'");
            $this->db->query("DELETE FROM tb_dekan WHERE nip='$nip'");
            $this->db->query("DELETE FROM tb_jumlah_pembimbing WHERE nip='$nip'");
            $this->db->query("DELETE FROM tb_korprodi WHERE nip='$nip'");
            $this->db->query("DELETE FROM tb_log WHERE user='$nip'");
            $this->db->query("DELETE FROM tb_nilai WHERE nip='$nip'");
            $this->db->query("DELETE FROM tb_pengajuan_pembimbing WHERE nip='$nip'");
            $this->db->query("DELETE FROM tb_penguji WHERE nip='$nip'");
            $this->db->query("DELETE FROM tb_perizinan_sidang WHERE nip='$nip'");
            $this->db->query("DELETE FROM tb_profil_tambahan WHERE id='$nip'");
            session()->setFlashdata("message", '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>Sukses!</strong> Hapus dosen dengan NIP : ' . $nip . ' berhasil.</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
            return redirect()->back()->withInput();
        }
    }
    public function edit()
    {
        set_time_limit(0);
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', '0');
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'admin') {
            return redirect()->to('/');
        }
        if (!$this->validate([
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong'
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email tidak boleh kosong'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong'
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
        $id_dosen = $this->request->getPost("id_dosen");
        $nip = $this->request->getPost("nip");
        $nidn = $this->request->getPost("nidn");
        $gelardepan = $this->request->getPost("gelardepan");
        $nama = $this->request->getPost("nama");
        $gelarbelakang = $this->request->getPost("gelarbelakang");
        $jk = $this->request->getPost("jk");
        $idunit = $this->request->getPost("idunit");
        $email = $this->request->getPost("email");

        $execute = $this->db->query('UPDATE tb_dosen SET nip="' . $nip . '", nidn="' . $nidn . '",gelardepan="' . $gelardepan . '",nama="' . $nama . '",gelarbelakang="' . $gelarbelakang . '",jk="' . $jk . '",idunit="' . $idunit . '",email="' . $email . '" WHERE id_dosen="' . $id_dosen . '"');
        if ($execute) {
            $dataid = $this->db->query("SELECT * FROM tb_users WHERE id='$nip' limit 1")->getResult();
            if (count($dataid) > 0 && $dataid[0]->email != $email) {
                $this->db->query("UPDATE tb_users SET email='$email',idunit='$idunit' WHERE id='$nip';");
            }
            $dataemail = $this->db->query("SELECT * FROM tb_users WHERE email='$email' limit 1")->getResult();
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
                $this->db->query("UPDATE tb_users SET id='$nip',idunit='$idunit' WHERE id='" . $dataemail[0]->id . "'");
            }
            $this->db->query("DELETE FROM tb_dosen WHERE nip='$nip' AND id_dosen!='$id_dosen'");
            $cekdosenemail = $this->db->query('SELECT * FROM tb_dosen WHERE email="' . $email . '" AND id_dosen!="' . $id_dosen . '"')->getResult();
            foreach ($cekdosenemail as $key) {
                $this->db->query("DELETE FROM tb_dosen WHERE id_dosen='$key->id_dosen'");
            }
            $jumlah_p1 = count($this->db->query("SELECT * FROM tb_pengajuan_pembimbing WHERE nip = '$nip' AND sebagai = '1' AND status_pengajuan='diterima'")->getResult());
            $jumlah_p2 = count($this->db->query("SELECT * FROM tb_pengajuan_pembimbing WHERE nip = '$nip' AND sebagai = '2' AND status_pengajuan='diterima'")->getResult());
            $data_jum_bimbingan_p1 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip = '$nip' AND sebagai = 'pembimbing 1'")->getResult();
            $data_jum_bimbingan_p2 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip = '$nip' AND sebagai = 'pembimbing 2'")->getResult();
            foreach ($data_jum_bimbingan_p1 as $kp1) {
                if ($kp1->jumlah == $jumlah_p1) {
                    $this->db->query("DELETE FROM tb_jumlah_pembimbing WHERE nip='$nip' AND sebagai='pembimbing 1' AND id_jumlah_pembimbing!='" . $kp1->id_jumlah_pembimbing . "'");
                    break;
                }
            }
            foreach ($data_jum_bimbingan_p2 as $kp2) {
                if ($kp2->jumlah == $jumlah_p2) {
                    $this->db->query("DELETE FROM tb_jumlah_pembimbing WHERE nip='$nip' AND sebagai='pembimbing 2' AND id_jumlah_pembimbing!='" . $kp2->id_jumlah_pembimbing . "'");
                    break;
                }
            }
            session()->setFlashdata("message", '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
        <span class="alert-inner--text"><strong>Sukses!</strong> Data dosen berhasil diperbarui.</span>
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>');
            return redirect()->back()->withInput();
        } else {
            session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
            <span class="alert-inner--text"><strong>Gagal!</strong> proses perbarui data dosen.</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
            return redirect()->back()->withInput();
        }
    }
    public function add()
    {
        set_time_limit(0);
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', '0');
        if (session()->get('ses_id') == '' || session()->get('ses_login') != 'admin') {
            return redirect()->to('/');
        }
        if (!$this->validate([
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong'
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email tidak boleh kosong'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong'
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
        $nip = $this->request->getPost("nip");
        $nidn = $this->request->getPost("nidn");
        $gelardepan = $this->request->getPost("gelardepan");
        $nama = $this->request->getPost("nama");
        $gelarbelakang = $this->request->getPost("gelarbelakang");
        $jk = $this->request->getPost("jk");
        $idunit = $this->request->getPost("idunit");
        $email = $this->request->getPost("email");

        $cek_nip_dosen = $this->db->query("SELECT * FROM tb_dosen a LEFT JOIN tb_unit b ON a.`idunit`=b.`idunit` WHERE a.`nip` ='$nip'")->getResult();
        $cek_email_dosen = $this->db->query("SELECT * FROM tb_dosen a LEFT JOIN tb_unit b ON a.`idunit`=b.`idunit` WHERE a.`email` ='$email'")->getResult();
        if (count($cek_nip_dosen) > 0) {
            session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
                    <span class="alert-inner--text"><strong>Gagal!</strong> NIP sudah terdaftar pada sistem. (Terdapat pada program studi ' . $cek_email_dosen[0]->namaunit . ')</span>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>');
            return redirect()->back()->withInput();
        } elseif (count($cek_email_dosen) > 0) {
            session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
            <span class="alert-inner--text"><strong>Gagal!</strong> email sudah terdaftar pada sistem. (Terdapat pada program studi ' . $cek_email_dosen[0]->namaunit . ')</span>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>');
            return redirect()->back()->withInput();
        } else {
            $execute = $this->db->query('INSERT INTO tb_dosen (nip,nidn,nama,gelardepan,gelarbelakang,jk,idunit,email,page) VALUES ("' . $nip . '","' . $nidn . '","' . $nama . '","' . $gelardepan . '","' . $gelarbelakang . '","' . $jk . '","' . $idunit . '","' . $email . '","")');
            if ($execute) {
                $dataid = $this->db->query("SELECT * FROM tb_users WHERE id='$nip' limit 1")->getResult();
                if (count($dataid) > 0 && $dataid[0]->email != $email) {
                    $this->db->query("UPDATE tb_users SET email='$email',idunit='$idunit' WHERE id='$nip';");
                }
                $dataemail = $this->db->query("SELECT * FROM tb_users WHERE email='$email' limit 1")->getResult();
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
                    $this->db->query("UPDATE tb_users SET id='$nip',idunit='$idunit' WHERE id='" . $dataemail[0]->id . "'");
                }
                $id_dosen = $this->db->query("SELECT * FROM tb_dosen WHERE nip='$nip' AND email='" . $email . "' ORDER BY id_dosen DESC limit 1")->getResult()[0]->id_dosen;
                $this->db->query("DELETE FROM tb_dosen WHERE nip='$nip' AND id_dosen!='$id_dosen'");
                $cekdosenemail = $this->db->query('SELECT * FROM tb_dosen WHERE email="' . $email . '" AND id_dosen!="' . $id_dosen . '"')->getResult();
                foreach ($cekdosenemail as $key) {
                    $this->db->query("DELETE FROM tb_dosen WHERE id_dosen='$key->id_dosen'");
                }
                $jumlah_p1 = count($this->db->query("SELECT * FROM tb_pengajuan_pembimbing WHERE nip = '$nip' AND sebagai = '1' AND status_pengajuan='diterima'")->getResult());
                $jumlah_p2 = count($this->db->query("SELECT * FROM tb_pengajuan_pembimbing WHERE nip = '$nip' AND sebagai = '2' AND status_pengajuan='diterima'")->getResult());
                $data_jum_bimbingan_p1 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip = '$nip' AND sebagai = 'pembimbing 1'")->getResult();
                $data_jum_bimbingan_p2 = $this->db->query("SELECT * FROM tb_jumlah_pembimbing WHERE nip = '$nip' AND sebagai = 'pembimbing 2'")->getResult();
                foreach ($data_jum_bimbingan_p1 as $kp1) {
                    if ($kp1->jumlah == $jumlah_p1) {
                        $this->db->query("DELETE FROM tb_jumlah_pembimbing WHERE nip='$nip' AND sebagai='pembimbing 1' AND id_jumlah_pembimbing!='" . $kp1->id_jumlah_pembimbing . "'");
                        break;
                    }
                }
                foreach ($data_jum_bimbingan_p2 as $kp2) {
                    if ($kp2->jumlah == $jumlah_p2) {
                        $this->db->query("DELETE FROM tb_jumlah_pembimbing WHERE nip='$nip' AND sebagai='pembimbing 2' AND id_jumlah_pembimbing!='" . $kp2->id_jumlah_pembimbing . "'");
                        break;
                    }
                }
                session()->setFlashdata("message", '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
                <span class="alert-inner--text"><strong>Sukses!</strong> Data dosen berhasil ditambahkan.</span>
                <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>');
                return redirect()->back()->withInput();
            } else {
                session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
                    <span class="alert-inner--text"><strong>Gagal!</strong> proses tambah data dosen.</span>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>');
                return redirect()->back()->withInput();
            }
        }
    }
}
