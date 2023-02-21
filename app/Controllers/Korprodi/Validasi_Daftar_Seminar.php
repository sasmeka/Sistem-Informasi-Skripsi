<?php

namespace App\Controllers\Korprodi;

use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library

class Validasi_Daftar_Seminar extends BaseController
{
    public function __construct()
    {
        $this->api = new Access_API();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') == 'mahasiswa') {
            return redirect()->to('/');
        }
        $id = session()->get('ses_id');
        $data_mhs = [];
        $data_mhs_bimbingan = $this->db->query("SELECT a.*,b.`nama` AS nama_mhs, b.`jk`, c.`namaunit`, d.* FROM tb_perizinan_sidang a LEFT JOIN tb_mahasiswa b ON b.`nim`=a.`nim` LEFT JOIN tb_unit c ON b.`idunit`=c.`idunit` LEFT JOIN tb_profil_tambahan d ON a.`nim`=d.`id` WHERE nip='$id' AND a.izin_sebagai='koordinator'")->getResult();
        foreach ($data_mhs_bimbingan as $key) {
            if ($key->image != NULL) {
                $image = $key->image;
            } else {
                $image = 'Profile_Default.png';
            }
            $data = [
                'nim' => $key->nim,
                'nama_mhs' => $key->nama_mhs,
                'jk' => $key->jk,
                'namaunit' => $key->namaunit,
                'image' => $image,
            ];
            array_push($data_mhs, $data);
        }
        $data = [
            'title' => 'Validasi Pendaftar Seminar Proposal',
            'db' => $this->db,
            'data_mhs_bimbingan' => $data_mhs,
        ];
        return view('Korprodi/validasi_daftar_seminar', $data);
    }
    public function validasi()
    {
        if (session()->get('ses_id') == '' || session()->get('ses_login') == 'mahasiswa') {
            return redirect()->to('/');
        }
        $nim = $this->request->getPost('nim');
        $status = $this->request->getPost('status');
        if ($status == 'disetujui') {
            $this->db->query("UPDATE tb_perizinan_sidang SET `status`='disetujui' WHERE nim='$nim' AND nip='" . session()->get('ses_id') . "' AND jenis_sidang='seminar proposal'");
        } elseif ($status == 'ditolak') {
            $this->db->query("UPDATE tb_perizinan_sidang SET `status`='ditolak' WHERE nim='$nim' AND nip='" . session()->get('ses_id') . "' AND jenis_sidang='seminar proposal'");
        } else {
            $this->db->query("UPDATE tb_perizinan_sidang SET `status`='menunggu' WHERE nim='$nim' AND nip='" . session()->get('ses_id') . "' AND jenis_sidang='seminar proposal'");
        }
        // echo "UPDATE tb_perizinan_sidang SET `status`='ditolak' WHERE nim='$nim' AND nip='" . session()->get('ses_id') . "' AND jenis_sidang='seminar_proposal'";
        return redirect()->to('/validasi_daftar_seminar_koor');
    }
}
