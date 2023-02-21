<?php

namespace App\Controllers;

use TCPDF;
use App\Controllers\BaseController;

use App\Libraries\Access_API; // Import library
use Dompdf\Dompdf;
use Dompdf\Options;

class Welcome extends BaseController
{
  public function __construct()
  {
    $this->api = new Access_API();
    $this->db = \Config\Database::connect();
   }
   public function generate_password()
  {
    // set_time_limit(0);
    // ini_set('max_execution_time', '0');
    // ini_set('max_input_time', '0');
    // $data = $this->api->authorize("170441100045@student.trunojoyo.ac.id");
    // echo $data->code . '<br>';
    // echo $data->message . '<br>';
    // echo $data->data->ID . '<br>';
    $pass = 'password';
    echo password_hash($pass, PASSWORD_DEFAULT);
  }
  
  public function google()
  {
    // $db = db_connect();
    // $pQuery = $db->prepare(static function ($db) {
    //   return $db->query("SELECT * FROM tb_log where id_log=:a:");
    // });

    // Run the Query
    // print_r($pQuery->execute($a)->getResult());

    $auth = Session()->auth;
    if ($auth) {
      echo strlen($auth->id);
      echo sprintf("Data akun anda<br>ID: %s<br>Nama: %s<br>Email: %s<br><img src=\"%s\">", $auth->id, $auth->name, $auth->email, $auth->picture);
      echo "<br><a href=\"/logout\">Logout</a>";
      return;
    }
    echo "<a href=\"/redirect\">login</a>";
  }
  public function testapi(){
    set_time_limit(0);
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', '0');
        // $dataperwalian = $this->api->get_data_api("https://api.trunojoyo.ac.id:8212/siakad/v1/perwalian?page=1&take=100&nim=170441100123");
        // var_dump($dataperwalian[count($dataperwalian)-1]);
    // $data = $this->api->get_data_api("https://api.trunojoyo.ac.id:8212/siakad/v1/krs?page=1&take=1000&nim=170441100123");
//     $datamka = [];
//     $datanmka = [];
//     foreach ($data as $key){
//         $datamk = $this->api->get_data_api("https://api.trunojoyo.ac.id:8212/siakad/v1/matakuliah?page=1&take=100&idmk=".$key->idmk);
//         if($datamk[0]->namamk!='SKRIPSI'){
//           $a = array_search($datamk[0]->namamk, $datamka);
//           if($a==NULL){
//             array_push($datamka,$datamk[0]->namamk);
//             array_push($datanmka,$key->nhuruf);
//           }else{
//             $datanmka[$a]=$key->nhuruf;
//           }
//         }      
// }
// $datafix = [];
// for($i=0;$i<count($datamka);$i++){
//   $error = [
//     'namamk'=>$datamka[$i],
//     'nhuruf'=>$datanmka[$i]
//       ];
//       array_push($datafix,$error);
// }
//         $mkerror = [];
//     foreach ($datafix as $key){
//       if($key['nhuruf']=='E' || $key['nhuruf']=='D' || $key['nhuruf']==NULL){
//   $error = [
// 'namamk'=>$key['namamk'],
// 'nilai'=>$key['nhuruf']
//   ];
//   array_push($mkerror,$error);
// }
// }
// var_dump($mkerror);
}
}
