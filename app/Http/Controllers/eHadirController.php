<?php

namespace App\Http\Controllers;

use App\Models\Aktiviti;
use App\Models\Kedatangan;
use App\Models\Urusetia;
use App\Models\Sesi;
use App\Models\jpjpStaff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use stdClass;

class eHadirController extends Controller
{
    public function daftar_kehadiran(Request $request)
    {

        $transid_aktiviti = $request->transid_aktiviti;
        // $transid_aktiviti = URL_3;
        $nokp = $request->nokp;
        $bahagian = $request->bahagian;
        $transid_sesi = $request->transid_sesi;
        // $user_id = $request->user_id;
        $user = User::where('nokp',$nokp)->first();
        // dd($transid_aktiviti);

        // need to return url
        

        $tarikh = date("Y-m-d");
        $masa = date("H:i:s");

        // dd($request->data);

        $dataaktiviti = DB::select("select * from aktivitis where transid_aktiviti = '$transid_aktiviti' and ('$tarikh' between tarikh_mula and tarikh_tamat)");

        $obj = new stdClass();

        if (count($dataaktiviti) > 0) {
            $datasesi = DB::select("select * from sesis where transid_aktiviti = '$transid_aktiviti' and ('$masa' between DATE_SUB(masa_mula, INTERVAL 1 HOUR) and masa_tamat)");
            // dd($datasesi);
            if (count($datasesi) > 0) {
                $kedatangan = DB::select("select * from kedatangans where nokp = '$nokp' and transid_aktiviti = '$transid_aktiviti'");
                if (count($kedatangan) > 0) {
                    $response[] = array(
                        "status" => "1",
                        "msg" => "Telah mendaftar",
                    );
                    $obj->kod = 1;
                    $obj->msg = "Telah Mendaftar";
                } else {
                    if ($nokp == "" || $transid_aktiviti == "") {
                        $obj->kod = 2;
                        $obj->msg = "Sila pastikan anda scan QR Kod yang betul.";
                    } else {
                        $transid_sesi = $datasesi[0]->transid_sesi;
                        $aktiviti_id = $dataaktiviti[0]->id;

                        Kedatangan::create([
                            'nokp' => $nokp,
                            'transid_aktiviti' => $transid_aktiviti,
                            'kodbahagian' => $bahagian,
                            'transid_sesi' => $transid_sesi,
                            'aktiviti_id' => $aktiviti_id,
                            // 'user_id' => $user_id,
                            'user_id' => $user->id,
                        ]);

                        $response[] = array(
                            "nama_aktiviti" => $dataaktiviti[0]->nama_aktiviti,
                            "lokasi" => $dataaktiviti[0]->lokasi,
                            "tarikh" => $dataaktiviti[0]->tarikh_mula . "-" . $dataaktiviti[0]->tarikh_tamat,
                            "masa" => $datasesi[0]->masa_mula . "-" . $datasesi[0]->masa_tamat,
                        );

                        $obj->status = 0;
                        $obj->msg = "Pendaftaran Berjaya";
                        $obj->data = $response;
                    }
                }
            } else {
                $obj->status = "1";
                $obj->msg = "Sila daftar pada masa yang telah di tetapkan";
            }
        } else {
            $obj->status = "1";
            $obj->msg = "Sila daftar pada tarikh yang telah di tetapkan";
        }

        return json_encode($obj);
    }

    // public function daftar_kehadiran2(Request $request)
    // {

    //     $transid_aktiviti = $request->transid_aktiviti;
    //     // $transid_aktiviti = URL_3;
    //     $nokp = $request->nokp;
    //     $bahagian = $request->bahagian;
    //     $transid_sesi = $request->transid_sesi;
    //     // $user_id = $request->user_id;
    //     $user = User::where('nokp',$nokp)->first();
    //     // dd($transid_aktiviti);

    //     // need to return url
        

    //     $tarikh = date("Y-m-d");
    //     $masa = date("H:i:s");

    //     // dd($request->data);

    //     $dataaktiviti = DB::select("select * from aktivitis where transid_aktiviti = '$transid_aktiviti' and ('$tarikh' between tarikh_mula and tarikh_tamat)");

    //     $obj = new stdClass();

    //     if (count($dataaktiviti) > 0) {
    //         $datasesi = DB::select("select * from sesis where transid_aktiviti = '$transid_aktiviti' and ('$masa' between DATE_SUB(masa_mula, INTERVAL 1 HOUR) and masa_tamat)");
    //         // dd($datasesi);
    //         if (count($datasesi) > 0) {
    //             $kedatangan = DB::select("select * from kedatangans where nokp = '$nokp' and transid_aktiviti = '$transid_aktiviti'");
    //             if (count($kedatangan) > 0) {
    //                 $response[] = array(
    //                     "status" => "1",
    //                     "msg" => "Telah mendaftar",
    //                 );
    //                 $obj->kod = 1;
    //                 $obj->msg = "Telah Mendaftar";
    //             } else {
    //                 if ($nokp == "" || $transid_aktiviti == "") {
    //                     $obj->kod = 2;
    //                     $obj->msg = "Sila pastikan anda scan QR Kod yang betul.";
    //                 } else {
    //                     $transid_sesi = $datasesi[0]->transid_sesi;
    //                     $aktiviti_id = $dataaktiviti[0]->id;

    //                     $data = jpjpStaff::with('bahagian')->where('nokp',$nokp)->get();

    //                     if (count($data) == 1) {
    //                         $bahagian = $data[0]['bahagian'];

    //                         Kedatangan::create([
    //                             'nokp' => $nokp,
    //                             'transid_aktiviti' => $transid_aktiviti,
    //                             'kodbahagian' => $bahagian,
    //                             'transid_sesi' => $transid_sesi,
    //                             'aktiviti_id' => $aktiviti_id,
    //                             // 'user_id' => $user_id,
    //                             'user_id' => $user->id,
    //                         ]);
    //                         User::find($user->id)->update([
    //                             'staff_id' => $data[0]->id,
    //                             'namabahagian' => $data[0]['bahagian'],
    //                         ]);
    
    //                         $obj->status = 0;
    //                         $obj->msg = "Pendaftaran Berjaya";
    //                         $obj->data = $response;
    //                         $obj->response[] = array(
    //                             "nama_aktiviti" => $dataaktiviti[0]->nama_aktiviti,
    //                             "lokasi" => $dataaktiviti[0]->lokasi,
    //                             "tarikh" => $dataaktiviti[0]->tarikh_mula . "-" . $dataaktiviti[0]->tarikh_tamat,
    //                             "masa" => $datasesi[0]->masa_mula . "-" . $datasesi[0]->masa_tamat,
    //                         );
                        
    //                     }
    //                 }
    //             }
    //         } else {
    //             $obj->status = "1";
    //             $obj->msg = "Sila daftar pada masa yang telah di tetapkan";
    //         }
    //     } else {
    //         $obj->status = "1";
    //         $obj->msg = "Sila daftar pada tarikh yang telah di tetapkan";
    //     }

    //     return json_encode($obj);
    // }

    // public function senarai_aktiviti_hadir(Request $request)
    // {
    //     $nokp = $request->nokp;
    //     // dd($nokp);
    //     $sql = "select b.*, a.nokp,(select MAX(c.id_aktiviti) from urusetias c where c.urusetia = a.nokp 
    //     and c.id_aktiviti = a.aktiviti_id) as isurusetia from kedatangans a, aktivitis b 
    //     where a.aktiviti_id = b.id and a.nokp = '$nokp'";
    //     $result = DB::select($sql);
    //     // return json_encode($result);
    //     return response()->json($result);        

    // }

    // public function senarai_aktiviti_hadir(Request $request)
    // {
    //     $nokp = $request->nokp;
    //     $sql = "select b.*, a.nokp,(select MAX(c.id_aktiviti) from urusetias c where c.urusetia = a.nokp 
    //     and c.id_aktiviti = a.aktiviti_id) as isurusetia from kedatangans a, aktivitis b 
    //     where a.aktiviti_id = b.id and a.nokp = '$nokp'";
    //     $result = DB::select($sql);
        
    //     foreach ($result as $aktiviti) {
    //         $sesi = Sesi::where('transid_aktiviti',$aktiviti->transid_aktiviti)->get();
    //         $sesi1 = Sesi::where('transid_sesi', $aktiviti->transid_sesi)->first();
    //         $newResult = collect($aktiviti);
    //         $newResult['sesi'] = $sesi;

    //         $lastResult[] = $newResult;
    //     }
    //     // return json_encode($result);
    //     return response()->json($lastResult);        

    // }

    public function senarai_aktiviti_hadir(Request $request)
    {
        $transid_sesi = $request->transid_sesi;
        $nokp = $request->nokp;
        $sql = "select b.*, a.nokp,(select MAX(c.id_aktiviti) from urusetias c where c.urusetia = a.nokp 
        and c.id_aktiviti = a.aktiviti_id) as isurusetia from kedatangans a, aktivitis b 
        where a.aktiviti_id = b.id and a.nokp = '$nokp'";
        $result = DB::select($sql);

        // dd($result);
        
        foreach ($result as $aktiviti) {
            $sesi = Sesi::where('transid_aktiviti',$aktiviti->transid_aktiviti)->first();//where('transid_sesi', $transid_sesi)->first();
            // $sesi1 = Sesi::where('transid_sesi', $aktiviti->transid_sesi)->first();
            $newResult = collect($aktiviti);
            // $newResult['sesi'] = $sesi;
            $newResult['masa_mula'] = $sesi->masa_mula ?? " ";
            $newResult['masa_tamat'] = $sesi->masa_tamat ?? " ";

            $lastResult[] = $newResult;

        }

        // return json_encode($result);
        return response()->json($lastResult);        

    }

    


    public function senarai_aktiviti(Request $request)
    {
        $nokp = $request->nokp;
        // dd($nokp);

        $list = DB::select("select a.*, b.urusetia from aktivitis a, urusetias b where a.id = b.id_aktiviti and b.urusetia = '$nokp' order by a.tarikh_mula desc");
        // dd($list);

        $obj = new Stdclass();

        if (!$list  ) {
            return [
                'code' => 404,
                'message' => 'Tiada rekod'
            ];
        };

        foreach ($list as $val) {
            $id_aktiviti = $val->id;
            // dd('masuk1');

            $list_urusetia = DB::select("select a.*,b.nama,b.namabahagian,b.nokp from urusetias a, users b where a.urusetia = b.nokp and  id_aktiviti = '$id_aktiviti' order by b.nama");
            unset($urusetia);
            foreach ($list_urusetia as $valurusetia) {
                $urusetia[] = array(
                    "nokp" => $valurusetia->urusetia,
                    "nama" => $valurusetia->nama,
                    "namabahagian" => $valurusetia->namabahagian,
                );
                // dd($urusetia);
            }
            $transid_aktiviti = $val->transid_aktiviti;
            // dd('masuk2');

            $sesidata = DB::select('select * from sesis where transid_aktiviti = ?', [$transid_aktiviti]);
            unset($sesi);
            foreach ($sesidata as $val21) {
                $sesi[] = array(
                    "sesi" => $val21->sesi,
                    "transid_sesi" =>$val21->transid_sesi,
                    "masa_mula" => $val21->masa_mula,
                    "masa_tamat" => $val21->masa_tamat,
                );
                // dd($sesi);
            }
            $aktivitiDb = Aktiviti::find($val->id);
            // dd($aktivitiDb);
            if ($aktivitiDb){
                $user = User::find($aktivitiDb->create_by);
            }
            // dd($user);
            $aktiviti[] = array(
                "id" => $val->id,
                "bilangan_hari" => $val->bilangan_hari,
                "bilangan_sesi" => $val->bilangan_sesi,
                "transid_aktiviti" => $transid_aktiviti,
                "nama_aktiviti" => $val->nama_aktiviti,
                "tarikh_mula" => $val->tarikh_mula,
                "tarikh_tamat" => $val->tarikh_tamat,
                "latitude" => $val->latitude,
                "longitude" => $val->longitude,
                "keterangan" => $val->keterangan,
                "masa_sesi" => $sesi ?? null,
                "lokasi" => $val->lokasi,
                "urusetia" => $val->urusetia,
                "user" => $user ?? null,
            );
            // dd($aktiviti);


        }
        $obj->aktiviti = $aktiviti;
        // dd($obj);
        // return json_encode($obj);
        return response()->json($obj);        

        // dd($obj);
        

    }

    public function senarai_urusetia1(Request $request)
    {
        $id_aktiviti = $request->id_aktiviti;
        $sql = "select a.*,b.nama,b.namabahagian,b.nokp from urusetias a, users b where a.urusetia = b.nokp and  id_aktiviti = '$id_aktiviti' order by b.nama";
        $list = DB::select($sql);
        echo json_encode($list);
    }

    public function tambah_urusetia(Request $request)
    {
        $nokp = $request->nokp;
        $id_aktiviti = $request->id_aktiviti;
        $transid_aktiviti = $request->transid_aktiviti;
        $create_by = User::where('nokp',$nokp)->first();
        $staff = jpjpStaff::where('nokp',$nokp)->first();
        if (!$create_by) {
            return [
                'code'=>404,
                'message'=>'ID tidak wujud|ID not exist'
            ];
        }
        if (!$staff) {
            return [
                'code'=>404,
                'message'=>'ID kakitangan sahaja dibenarkan|Only staff ID is allowed'
            ];
         }
        $cond = "";
        if ($nokp != "") {
            $cond = " and urusetia = '$nokp' ";
        }
        $sql = "select a.*,b.nama,b.namabahagian from urusetias a, users b where a.urusetia = b.nokp and  a.id_aktiviti = '$id_aktiviti' and a.urusetia = '$nokp' order by b.nama";
        // dd($sql);

        $list = DB::select($sql);
        // dd($list);

        $obj = new Stdclass();

        $bil = count($list);
        // dd($bil);
        if ($bil > 0) {
            $obj->kod = 1;
            $obj->message = "Telah mendaftar sebagai urusetia..";
        } else {
            if ($nokp != "") {
                // dd('masuk');
                // $this->apiModel->insertUrusetia($id_aktiviti, $nokp);
                // $create_by = 0;
                // $sql = "insert into urusetias (id_aktiviti,urusetia,create_by) values ('$id_aktiviti','$nokp','$create_by')";
                Urusetia::create([
                    'transid_aktiviti' => $transid_aktiviti ?? '',
                    'id_aktiviti' => $id_aktiviti ?? '',
                    'urusetia' => $nokp ?? '',
                    'create_by' => $create_by->id,
                    // 'create_by' => $create_by ?? '',
                ]);

                $obj->kod = 0;
                $obj->message = "Pendaftaran sebagai urusetia berjaya." . $bil;
            } else {
                $obj->kod = 1;
                $obj->message = "Sila masukkan No Kad Pengenalan";
            }

        }
        echo json_encode($obj);
    }

    // public function senarai_kehadiran(Request $request)
    // {
    //     $id_aktiviti = $request->id_aktiviti;
    //     // dd($id_aktiviti);
    //     $sql = "select b.* from kedatangans a, users b where a.nokp = b.nokp and a.aktiviti_id = '$id_aktiviti'";
    //     // $sql = "select a.* from users b, kedatangans a where a.nokp = b.nokp and a.aktiviti_id = '$id_aktiviti'";

    //     // dd($sql);
    //     $list = DB::select($sql);
    //     echo json_encode($list);
    // }

    public function senarai_kehadiran(Request $request)
    {
        $id_aktiviti = $request->id_aktiviti;
        $sql2 = Kedatangan::with('user')->where('aktiviti_id', '=', $id_aktiviti)->get();
        
        return response()->json($sql2);
    }


    // asli
    public function daftar_manual(Request $request)
    {
        $nokp = $request->nokp;
        $id_aktiviti = $request->id_aktiviti;
        $jenis = $request->jenis_pendaftaran;
        $bahagian = $request->bahgian;
        $transid_aktiviti = $request->transid_aktiviti;
        $transid_sesi = $request->transid_sesi;
        $user = User::where('nokp',$nokp)->first();
        // $latitude = Aktiviti::where('latitude',$latitude)->first();
        // dd($user);
        $response = "";

        // if (!$user) {
        //     return [
        //         'code' => 404,
        //         'message' => 'User nokp ' . $nokp. ' Tidak wujud ',
        //     ];
        // };
        // dd($user);


        $sql1 = "select * from kedatangans where nokp = '$nokp' and transid_aktiviti = '$transid_aktiviti'";
        $kedatangan = DB::select($sql1);
        // dd($kedatangan);

        $obj = new stdClass();


        if (count($kedatangan) > 0) {
            $obj->kod = 1;
            $obj->message = "Telah Mendaftar";
        } else {

            $data = jpjpStaff::with('bahagian')->where('nokp',$nokp)->get();
            // dd($data);
            // return $data[0]['bahagian'];
            // $user = User::find($user->id)->update([
            //     'player_id' => $data[0]->id,
            // ]);

            // return $data[0]->id;

            // return $user;

            if (count($data) == 1) {
                $bahagian = $data[0]['bahagian'];
                Kedatangan::create([
                    // 'user' => $request->user,
                    'user_id' => $user->id,
                    'nokp' => $nokp,
                    'transid_aktiviti' => $transid_aktiviti,
                    'kodbahagian' => $bahagian,
                    'transid_sesi' => $transid_sesi,
                    'aktiviti_id' => $id_aktiviti,
                    // 'latitude' => $latitude,

                ]);
                User::find($user->id)->update([
                    'staff_id' => $data[0]->id,
                    'namabahagian' => $data[0]['bahagian'],
                ]);

                $obj->kod = 0;
                $obj->message = "Pendaftaran Berjaya.";
                $obj->nama = $data[0]['nama'];
                $obj->nokp = $nokp;
                $obj->bahagian = $data[0]['bahagian'];

            } else {
                $obj->kod = 2;
                $obj->message = "No Mykad Tidak Sah.";
            }
            // dd($data);
        }
        echo json_encode($obj);
    }

    // buat baru utk daftar_manual nk checking tarikh dan masa.
    public function daftar_manual2(Request $request)
    {
        $nokp = $request->nokp;
        $id_aktiviti = $request->id_aktiviti;
        $jenis = $request->jenis_pendaftaran;
        $bahagian = $request->bahgian;
        $transid_aktiviti = $request->transid_aktiviti;
        $transid_sesi = $request->transid_sesi;
        $user = User::where('nokp',$nokp)->first();
        // $latitude = Aktiviti::where('latitude',$latitude)->first();
        // dd($user);
        // $response = "";

        // if (!$user) {
        //     return [
        //         'code' => 404,
        //         'message' => 'User nokp ' . $nokp. ' Tidak wujud ',
        //     ];
        // };
        // dd($user);


        $tarikh = date("Y-m-d");
        $masa = date("H:i:s");

        $dataaktiviti = DB::select("select * from aktivitis where transid_aktiviti = '$transid_aktiviti' and ('$tarikh' between tarikh_mula and tarikh_tamat)");

        $obj = new stdClass();

        if (count($dataaktiviti) > 0 ) {
            $datasesi = DB::select("select * from sesis where transid_aktiviti = '$transid_aktiviti' and ('$masa' between DATE_SUB(masa_mula, INTERVAL 1 HOUR) and masa_tamat)");
            if (count($datasesi) > 0 ) {
                $kedatangan = DB::select("select * from kedatangans where nokp = '$nokp' and transid_aktiviti = '$transid_aktiviti'");
                if (count($kedatangan) > 0) {
                    $obj->kod = 1;
                    $obj->message = "Telah Mendaftar";
                } else {
        
                    $data = jpjpStaff::with('bahagian')->where('nokp',$nokp)->get();
                    // dd($data);
                    // return $data[0]['bahagian'];
                    // $user = User::find($user->id)->update([
                    //     'player_id' => $data[0]->id,
                    // ]);
        
                    // return $data[0]->id;
        
                    // return $user;
        
                    if (count($data) == 1) {
                        
                        $bahagian = $data[0]['bahagian'];
                        Kedatangan::create([
                            // 'user' => $request->user,
                            'user_id' => $user->id,
                            'nokp' => $nokp,
                            'transid_aktiviti' => $transid_aktiviti,
                            'kodbahagian' => $bahagian,
                            'transid_sesi' => $transid_sesi,
                            'aktiviti_id' => $id_aktiviti,
                            // 'latitude' => $latitude,
        
                        ]);
                        User::find($user->id)->update([
                            'staff_id' => $data[0]->id,
                            'namabahagian' => $data[0]['bahagian'],
                        ]);

                        // Aktiviti::find($transid_aktiviti->transid_aktivit)->update([
                        //     'transid_sesi' => $datasesi[0]->$transid_sesi,
                        //     'masa_mula' => $datasesi[0]->$masa_mula,
                        //     'masa_tamat' => $datasesi[0]->$masa_tamat,
                        // ]);

                        // dd($transid_aktiviti);
        
                        $obj->kod = 0;
                        $obj->message = "Pendaftaran Berjaya.";
                        $obj->nama = $data[0]['nama'];
                        $obj->nokp = $nokp;
                        $obj->bahagian = $data[0]['bahagian'];
        
                    } else {
                        $obj->kod = 2;
                        $obj->message = "No Mykad Tidak Sah.";
                    }
                    // dd($data);
                }
            } else {
                $obj->status = "1";
                $obj->msg = "Sila daftar pada masa yang telah di tetapkan";
            }
        } else {
            $obj->status = "1";
            $obj->msg = "Sila daftar pada tarikh yang telah di tetapkan";
        }
        
        echo json_encode($obj);
    }

    public function daftarQR(Request $request)
    {
        $nokp = request('nokp');
        $data = jpjpStaff::with('bahagian')->where('nokp',$nokp)->get();
        // dd($data);

        $obj = new stdClass();
        $bil = count($data);
        if ($bil == 0 || $nokp == "") {
            $obj->kod = 1;
            $obj->message = "No Mykad tiada dalam rekod.";
        } else {
            $obj->kod = 0;
            $obj->message = "Penjanaan Kod QR berjaya.";
            $obj->nama = $data[0]['nama'];
            $obj->bahagian = $data[0]['bahagian'];
            $obj->namabahagian = $data[0]['keterangan'];
            $obj->nokp = $data[0]['nokp'];
        }
        echo json_encode($obj);
    }

    public function tambah_aktiviti(Request $request)
    {
        $keterangan = $request->keterangan;
        $nama = $request->nama;
        $nokp = $request->nokp;
        $bilangan_hari = $request->bilangan_hari;
        $bilangan_sesi = $request->bilangan_sesi;
        $tarikh_mula = $request->tarikh_mula;
        $tarikh_tamat = $request->tarikh_tamat;
        $lokasi = $request->lokasi;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $masa_mula = $request->masa_mula;
        $masa_tamat = $request->masa_tamat;
        $create_by = User::where('nokp',$nokp)->first();
        // dd($create_by->id);

        if (!$create_by) {
            return [
                'code' => 404,
                'message' => 'User nokp ' . $nokp. ' Tidak wujud ',
            ];
        };
        // dd($request->all);

            if ($bilangan_hari == "1") {
                $tarikh_tamat = $tarikh_mula;
            }

            $i = 0;
            $transid_aktiviti = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999);


        $obj = new stdClass();
        // $create_by = $request->uid;
        // $nokp = $request->nokp;

        // if ($bilangan_hari == "1") {
        //     $transid_aktiviti = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999);
        // }

        Aktiviti::create([
            'transid_aktiviti' => $transid_aktiviti,
            'nama_aktiviti' => $nama,
            'tarikh_mula' => $tarikh_mula,
            'tarikh_tamat' => $tarikh_tamat,
            'masa_mula' => $masa_mula,
            'masa_tamat' => $masa_tamat,
            'lokasi' => $lokasi,
            'keterangan' => $keterangan,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'bilangan_sesi' => $bilangan_sesi,
            'bilangan_hari' =>$bilangan_hari,
            'create_by' => $create_by->id,
            'nokp' => $nokp,
        ]);

        $aktiviti = Aktiviti::where('transid_aktiviti', '=' ,$transid_aktiviti)->first();
        $id_aktiviti = $aktiviti['id'];

        Urusetia::create([
            'transid_aktiviti' => $transid_aktiviti,
            'id_aktiviti' => $id_aktiviti,
            'urusetia' => $nokp,
            'create_by' => $create_by->id,
        ]);
     
        if ($bilangan_sesi == "1") {
            $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "1";
            $sesi = "1";
            $masa_mula = $request->masa_mula1;
            $masa_tamat = $request->masa_tamat1;

            Sesi::create([
                'transid_aktiviti' => $transid_aktiviti,
                'transid_sesi' => $transid_sesi,
                'sesi' => $sesi,
                'masa_mula' => $masa_mula,
                'masa_tamat' => $masa_tamat,
                'aktiviti_id' => $id_aktiviti,
                'status_aktif' => '1',
            ]);


        } elseif ($bilangan_sesi == "2") {
            $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "1";
            $sesi = "1";
            $masa_mula = $request->masa_mula1;
            $masa_tamat = $request->masa_tamat1;
            Sesi::create([
                'transid_aktiviti' => $transid_aktiviti,
                'transid_sesi' => $transid_sesi,
                'sesi' => $sesi,
                'masa_mula' => $masa_mula,
                'masa_tamat' => $masa_tamat,
                'aktiviti_id' => $id_aktiviti,
                'status_aktif' => '1',
            ]);

            $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "2";
            $sesi = "2";
            $masa_mula = $request->masa_mula2;
            $masa_tamat = $request->masa_tamat2;
            Sesi::create([
                'transid_aktiviti' => $transid_aktiviti,
                'transid_sesi' => $transid_sesi,
                'sesi' => $sesi,
                'masa_mula' => $masa_mula,
                'masa_tamat' => $masa_tamat,
                'aktiviti_id' => $id_aktiviti,
                'status_aktif' => '1',
            ]);

        } elseif ($bilangan_sesi == "3") {
            $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "1";
            $sesi = "1";
            $masa_mula = $request->masa_mula1;
            $masa_tamat = $request->masa_tamat1;
            Sesi::create([
                'transid_aktiviti' => $transid_aktiviti,
                'transid_sesi' => $transid_sesi,
                'sesi' => $sesi,
                'masa_mula' => $masa_mula,
                'masa_tamat' => $masa_tamat,
                'aktiviti_id' => $id_aktiviti,
                'status_aktif' => '1',
            ]);

            $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "2";
            $sesi = "2";
            $masa_mula = $request->masa_mula2;
            $masa_tamat = $request->masa_tamat2;
            Sesi::create([
                'transid_aktiviti' => $transid_aktiviti,
                'transid_sesi' => $transid_sesi,
                'sesi' => $sesi,
                'masa_mula' => $masa_mula,
                'masa_tamat' => $masa_tamat,
                'aktiviti_id' => $id_aktiviti,
                'status_aktif' => '1',
            ]);

            $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "3";
            $sesi = "3";
            $masa_mula = $request->masa_mula3;
            $masa_tamat = $request->masa_tamat3;
            Sesi::create([
                'transid_aktiviti' => $transid_aktiviti,
                'transid_sesi' => $transid_sesi,
                'sesi' => $sesi,
                'masa_mula' => $masa_mula,
                'masa_tamat' => $masa_tamat,
                'aktiviti_id' => $id_aktiviti,
                'status_aktif' => '1',
            ]);
        }

        $obj->kod = 0;
        $obj->message = "Aktiviti baru telah disimpan";
        echo json_encode($obj);
    }

    public function kemaskini_aktiviti2(Request $request)
    {
        $keterangan = $request->keterangan;
        $nama = $request->nama;
        $nokp = $request->nokp;
        $bilangan_hari = $request->bilangan_hari;
        $bilangan_sesi = $request->bilangan_sesi;
        $tarikh_mula = $request->tarikh_mula;
        $tarikh_tamat = $request->tarikh_tamat;
        $lokasi = $request->lokasi;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $masa_mula = $request->masa_mula;
        $masa_tamat = $request->masa_tamat;
        $transid_aktiviti = $request->transid_aktiviti;
        $id_aktiviti = $request->id_aktiviti;

       

        
        $msesi = Sesi::where('aktiviti_id', '=' ,$id_aktiviti)->get();
        if ( count($request->sesi) < count($msesi) ) {
            return [
                        'code' => 404,
                        'message' => ' Bilangan Sesi dihantar kurang dari dalam database ',
                    ];
        }

        $create_by = User::where('nokp',$nokp)->first();
        if (!$create_by) {
            return [
                'code' => 404,
                'message' => 'User nokp ' . $nokp. ' Tidak wujud ',
            ];
        };

        if ($bilangan_hari == 1) {
            $tarikh_tamat = $tarikh_mula;
        }

        $aktiviti = Aktiviti::find($id_aktiviti);
        if (!$aktiviti) {
            return [
                'code' => 404,
                'message' => ' Aktiviti ID:' . $id_aktiviti. 'Tidak Wujud ',
            ];
        };
        if (!$transid_aktiviti) {
            $transid_aktiviti =  $aktiviti->transid_aktiviti;
        }

        $aktiviti->update([
            'transid_aktiviti' => $transid_aktiviti ?? $aktiviti->transid_aktiviti,
            'nama_aktiviti' => $nama ?? $aktiviti->nama_aktiviti,
            'tarikh_mula' => $tarikh_mula ?? $aktiviti->tarikh_mula,
            'tarikh_tamat' => $tarikh_tamat ?? $aktiviti->tarikh_tamat,
            'masa_mula' => $masa_mula ?? $aktiviti->masa_mula,
            'masa_tamat' => $masa_tamat ?? $aktiviti->masa_tamat,
            'lokasi' => $lokasi ?? $aktiviti->lokasi,
            'keterangan' => $keterangan ?? $aktiviti->keterangan,
            'latitude' => $latitude ?? $aktiviti->latitude,
            'longitude' => $longitude ?? $aktiviti->longitude,
            'bilangan_sesi' => $bilangan_sesi ?? $aktiviti->bilangan_sesi,
            'bilangan_hari' => $bilangan_hari ?? $aktiviti->bilangan_hari,
            'create_by' => $create_by->id ?? $aktiviti->create_by,
            'nokp' => $nokp ?? $aktiviti->nokp,
        ]);

        $urusetia = Urusetia::where('id_aktiviti', '=' ,$id_aktiviti)->first();
        if ($urusetia) {
            $urusetia->update([
                'transid_aktiviti' => $transid_aktiviti ?? $urusetia->transid_aktiviti,
                'urusetia' => $nokp ?? $urusetia->urusetia,
                'create_by' => $$create_by->id ?? $urusetia->create_by,
            ]);
        };


        foreach ($msesi as $key => $sesis) {
            $sesis->update([
                'masa_mula' => $request->sesi[$key]['masa_mula'] ?? $sesis->masa_mula,
                'masa_tamat' => $request->sesi[$key]['masa_tamat'] ?? $sesis->masa_tamat,
                'status_aktif' => 1,
            ]);
        }


        if ( count($request->sesi) > count($msesi)) {
            $toCreate = count($request->sesi) - count($msesi);
            $latest_sesi = count($msesi);
            for ($i=0; $i < $toCreate; $i++) { 
                $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "1";
                Sesi::create([
                    'transid_aktiviti' => $transid_aktiviti ,
                    'transid_sesi' => $transid_sesi,
                    'sesi' => $latest_sesi+1,
                    'masa_mula' => $request->sesi[$latest_sesi]['masa_mula'],
                    'masa_tamat' => $request->sesi[$latest_sesi]['masa_akhir'],
                    'aktiviti_id' => $id_aktiviti,
                    'status_aktif' => 1,
                ]);
                $latest_sesi++;
            }
        }

        return [
            'kod' => 0,
            'message' =>  "Aktiviti baru telah dikemaskini",
        ];
    }

    
    // public function kemaskini_aktiviti(Request $request)
    // {
    //     $keterangan = $request->keterangan;
    //     $nama = $request->nama;
    //     $nokp = $request->nokp;
    //     $bilangan_hari = $request->bilangan_hari;
    //     $bilangan_sesi = $request->bilangan_sesi;
    //     $tarikh_mula = $request->tarikh_mula;
    //     $tarikh_tamat = $request->tarikh_tamat;
    //     $lokasi = $request->lokasi;
    //     $latitude = $request->latitude;
    //     $longitude = $request->longitude;
    //     $masa_mula = $request->masa_mula;
    //     $masa_tamat = $request->masa_tamat;
    //     $transid_aktiviti = $request->transid_aktiviti;
    //     $id_aktiviti = $request->id_aktiviti;
    //     $create_by = User::where('nokp',$nokp)->first();
    //     // dd($create_by);
    //     if (!$create_by) {
    //         return [
    //             'code' => 404,
    //             'message' => 'User nokp ' . $nokp. ' Tidak wujud ',
    //         ];
    //     };

    //         if ($bilangan_hari == "1") {
    //             $tarikh_tamat = $tarikh_mula;
    //         }

    //         $i = 0;


    //     $obj = new stdClass();
    //     // $create_by = $request->uid;
    //     // $nokp = $request->nokp;

    //     $aktiviti = Aktiviti::find($id_aktiviti);
    //     if (!$aktiviti) {
    //         return [
    //             'code' => 404,
    //             'message' => ' Aktiviti ID:' . $id_aktiviti. 'Tidak Wujud ',
    //         ];
    //     };
    //     // dd($aktiviti);
    //     $aktiviti->update([
    //         'transid_aktiviti' => $transid_aktiviti ?? $aktiviti->transid_aktiviti,
    //         'nama_aktiviti' => $nama ?? $aktiviti->nama_aktiviti,
    //         'tarikh_mula' => $tarikh_mula ?? $aktiviti->tarikh_mula,
    //         'tarikh_tamat' => $tarikh_tamat ?? $aktiviti->tarikh_tamat,
    //         'masa_mula' => $masa_mula ?? $aktiviti->masa_mula,
    //         'masa_tamat' => $masa_tamat ?? $aktiviti->masa_tamat,
    //         'lokasi' => $lokasi ?? $aktiviti->lokasi,
    //         'keterangan' => $keterangan ?? $aktiviti->keterangan,
    //         'latitude' => $latitude ?? $aktiviti->latitude,
    //         'longitude' => $longitude ?? $aktiviti->longitude,
    //         'bilangan_sesi' => $bilangan_sesi ?? $aktiviti->bilangan_sesi,
    //         'bilangan_hari' => $bilangan_hari ?? $aktiviti->bilangan_hari,
    //         'create_by' => $create_by->id ?? $aktiviti->create_by,
    //         'nokp' => $nokp ?? $aktiviti->nokp,
    //     ]);

    //     $urusetia = Urusetia::where('id_aktiviti', '=' ,$id_aktiviti)->first();
    //     if ($urusetia) {
    //         $urusetia->update([
    //             'transid_aktiviti' => $transid_aktiviti ?? $urusetia->transid_aktiviti,
    //             'urusetia' => $nokp ?? $urusetia->urusetia,
    //             'create_by' => $$create_by->id ?? $urusetia->create_by,
    //         ]);
    //     };
     
    //     if ($bilangan_sesi == "1") {
    //         $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "1";
    //         $sesi = "1";
    //         $masa_mula = $request->masa_mula1;
    //         $masa_tamat = $request->masa_tamat1;

    //         $msesi = Sesi::where('aktiviti_id', '=' ,$id_aktiviti)->first();
    //         if ($msesi) {
    //             $msesi->update([
    //                 'transid_aktiviti' => $transid_aktiviti ?? $msesi->transid_aktiviti,
    //                 'transid_sesi' => $transid_sesi ?? $msesi->transid_sesi,
    //                 'sesi' => $sesi ?? $msesi->sesi,
    //                 'masa_mula' => $masa_mula ?? $msesi->masa_mula,
    //                 'masa_tamat' => $masa_tamat ?? $msesi->masa_tamat,
    //                 'aktiviti_id' => $id_aktiviti ?? $msesi->aktiviti_id,
    //                 'status_aktif' => '1' ?? $msesi->status_aktif,
    //             ]);
    //         }


            

    //     } elseif ($bilangan_sesi == "2") {
    //         $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "1";
    //         $sesi = "1";
    //         $masa_mula = $request->masa_mula1;
    //         $masa_tamat = $request->masa_tamat1;

    //         $msesi = Sesi::where('aktiviti_id', '=' ,$id_aktiviti)->first();
    //         if ($msesi) {
    //             $msesi->update([
    //                 'transid_aktiviti' => $transid_aktiviti ?? $msesi->transid_aktiviti,
    //                 'transid_sesi' => $transid_sesi ?? $msesi->transid_sesi,
    //                 'sesi' => $sesi ?? $msesi->sesi,
    //                 'masa_mula' => $masa_mula ?? $msesi->masa_mula,
    //                 'masa_tamat' => $masa_tamat ?? $msesi->masa_tamat,
    //                 'aktiviti_id' => $id_aktiviti ?? $msesi->aktiviti_id,
    //                 'status_aktif' => '1' ?? $msesi->status_aktif,
    //             ]);
    //         }

    //         $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "2";
    //         $sesi = "2";
    //         $masa_mula = $request->masa_mula2;
    //         $masa_tamat = $request->masa_tamat2;

    //         $msesi = Sesi::where('aktiviti_id', '=' ,$id_aktiviti)->first();
    //         if ($sesi) {
    //             $msesi->update([
    //                 'transid_aktiviti' => $transid_aktiviti ?? $msesi->transid_aktiviti,
    //                 'transid_sesi' => $transid_sesi ?? $msesi->transid_sesi,
    //                 'sesi' => $sesi ?? $msesi->sesi,
    //                 'masa_mula' => $masa_mula ?? $msesi->masa_mula,
    //                 'masa_tamat' => $masa_tamat ?? $msesi->masa_tamat,
    //                 'aktiviti_id' => $id_aktiviti ?? $msesi->aktiviti_id,
    //                 'status_aktif' => '1' ?? $msesi->status_aktif,
    //             ]);
    //         }
            

    //     } elseif ($bilangan_sesi == "3") {
    //         $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "1";
    //         $sesi = "1";
    //         $masa_mula = $request->masa_mula1;
    //         $masa_tamat = $request->masa_tamat1;

    //         $msesi = Sesi::where('aktiviti_id', '=' ,$id_aktiviti)->first();
    //         if ($msesi) {
    //             $msesi->update([
    //                 'transid_aktiviti' => $transid_aktiviti ?? $msesi->transid_aktiviti,
    //                 'transid_sesi' => $transid_sesi ?? $msesi->transid_sesi,
    //                 'sesi' => $sesi ?? $msesi->sesi,
    //                 'masa_mula' => $masa_mula ?? $msesi->masa_mula,
    //                 'masa_tamat' => $masa_tamat ?? $msesi->masa_tamat,
    //                 'aktiviti_id' => $id_aktiviti ?? $msesi->aktiviti_id,
    //                 'status_aktif' => '1' ?? $msesi->status_aktif,
    //             ]);
    //         }
           

    //         $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "2";
    //         $sesi = "2";
    //         $masa_mula = $request->masa_mula2;
    //         $masa_tamat = $request->masa_tamat2;

    //         $msesi = Sesi::where('aktiviti_id', '=' ,$id_aktiviti)->first();
    //         if ($msesi) {
    //             $msesi->update([
    //                 'transid_aktiviti' => $transid_aktiviti ?? $msesi->transid_aktiviti,
    //                 'transid_sesi' => $transid_sesi ?? $msesi->transid_sesi,
    //                 'sesi' => $sesi ?? $msesi->sesi,
    //                 'masa_mula' => $masa_mula ?? $msesi->masa_mula,
    //                 'masa_tamat' => $masa_tamat ?? $msesi->masa_tamat,
    //                 'aktiviti_id' => $id_aktiviti ?? $msesi->aktiviti_id,
    //                 'status_aktif' => '1' ?? $msesi->status_aktif,
    //             ]);
    //         }
           

    //         $transid_sesi = strtotime(date("Y-m-d H:i:s")) . rand(10000, 99999) . "3";
    //         $sesi = "3";
    //         $masa_mula = $request->masa_mula3;
    //         $masa_tamat = $request->masa_tamat3;

    //         $msesi = Sesi::where('aktiviti_id', '=' ,$id_aktiviti)->first();
    //         if ($msesi) {
    //             $msesi->update([
    //                 'transid_aktiviti' => $transid_aktiviti ?? $msesi->transid_aktiviti,
    //                 'transid_sesi' => $transid_sesi ?? $msesi->transid_sesi,
    //                 'sesi' => $sesi ?? $msesi->sesi,
    //                 'masa_mula' => $masa_mula ?? $msesi->masa_mula,
    //                 'masa_tamat' => $masa_tamat ?? $msesi->masa_tamat,
    //                 'aktiviti_id' => $id_aktiviti ?? $msesi->aktiviti_id,
    //                 'status_aktif' => '1' ?? $msesi->status_aktif,
    //             ]);
    //         }
            
    //     }

    //     $obj->kod = 0;
    //     $obj->message = "Aktiviti baru telah dikemaskini";
    //     echo json_encode($obj);

    // }

    // public function padam_urusetia(Aktiviti $aktiviti)
    // {
    //     $id_aktiviti = $aktiviti->id;
    //     $sesi = Sesi::where('aktiviti_id',$id_aktiviti)->delete();
    //     $urusetia = Urusetia::where('id_aktiviti',$id_aktiviti)->delete();
    //     $deletedAktiviti = $aktiviti->delete();

    //     if ($deletedAktiviti) {

    //         $output['aktiviti'] = 'Aktiviti has been deleted';
    //         if ($sesi) {
    //            $output['sesi'] = 'Sesi has been deleted';
    //         }
    //         if ($urusetia) {
    //            $output['urusetia'] = 'Urusetia has been deleted';
    //         }

    //         return response()->json($output, 200);
    //     }
    // }
    public function padam_urusetia(Request $request)
    {
        $id_aktiviti = $request->id;
        
        $aktiviti = Aktiviti::find($id_aktiviti);
        if (!$aktiviti) {
            return [
                'code' => 404,
                'message' => ' Aktiviti Tidak Dijumpai ',
            ];
        };
        $sesi = Sesi::where('aktiviti_id',$id_aktiviti)->delete();
        $urusetia = Urusetia::where('id_aktiviti',$id_aktiviti)->delete();
        $deletedAktiviti = $aktiviti->delete();

        if ($deletedAktiviti) {

            $output['aktiviti'] = 'Aktiviti has been deleted';
            if ($sesi) {
               $output['sesi'] = 'Sesi has been deleted';
            }
            if ($urusetia) {
               $output['urusetia'] = 'Urusetia has been deleted';
            }

            return response()->json($output, 200);
        }
    }

    public function padam_kehadiran(Request $request)
    {
        $id_kedatangan = $request->id;
        // dd($id_kedatangan);

        $id_kedatangan = Kedatangan::find($id_kedatangan);
        if (!$id_kedatangan) {
            return [
                'code' => 404,
                'message' => ' Kedatangan Tidak Dijumpai ',
            ];
        }
        // dd($id_kedatangan);
        $delete_kedatangan = $id_kedatangan->delete();

        if ($delete_kedatangan) {

            $output['id_kedatangan'] = 'kehadiran has been deleted';

            return response()->json($output, 200);
        }
    }

    public function padam_urusetia2(Request $request)
    {
        $id_urusetia = $request->id;
        // dd($id_kedatangan);

        $id_urusetia = Urusetia::find($id_urusetia);
        if (!$id_urusetia) {
            return [
                'code' => 404,
                'message' => ' urusetia Tidak Dijumpai ',
            ];
        }
        $delete_urusetia2 = $id_urusetia->delete();

        if ($delete_urusetia2) {

            $output['id_urusetia'] = 'urusetia has been deleted';

            return response()->json($output, 200);
        }
    }
    
    public function aktiviti_byid(Request $request)
    {
        $id = $request->id;

        $list = DB::select("select a.*, b.urusetia from aktivitis a, urusetias b where a.id = '$id' and a.id = b.id_aktiviti order by a.tarikh_mula desc");

        $obj = new Stdclass();

        if (!$list  ) {
            return [
                'code' => 404,
                'message' => 'Tiada rekod'
            ];
        };

        foreach ($list as $val) {
            $id_aktiviti = $val->id;

            $list_urusetia = DB::select("select a.*,b.nama,b.namabahagian,b.nokp from urusetias a, users b where a.urusetia = b.nokp and  id_aktiviti = '$id_aktiviti' order by b.nama");
            unset($urusetia);
            foreach ($list_urusetia as $valurusetia) {
                $urusetia[] = array(
                    "nokp" => $valurusetia->urusetia,
                    "nama" => $valurusetia->nama,
                    "namabahagian" => $valurusetia->namabahagian,
                );
            }
            $transid_aktiviti = $val->transid_aktiviti;
            $sesidata = DB::select('select * from sesis where transid_aktiviti = ?', [$transid_aktiviti]);
            unset($sesi);
            foreach ($sesidata as $val21) {
                $sesi[] = array(
                    "sesi" => $val21->sesi,
                    "transid_sesi" => $val21->transid_sesi,
                    "masa_mula" => $val21->masa_mula,
                    "masa_tamat" => $val21->masa_tamat,
                );
            }
            $aktivitiDb = Aktiviti::find($val->id);
            if ($aktivitiDb){
                $user = User::find($aktivitiDb->create_by);
            }
            $aktiviti[] = array(
                "id" => $val->id,
                "bilangan_hari" => $val->bilangan_hari,
                "bilangan_sesi" => $val->bilangan_sesi,
                "transid_aktiviti" => $val->transid_aktiviti,
                "nama_aktiviti" => $val->nama_aktiviti,
                "tarikh_mula" => $val->tarikh_mula,
                "tarikh_tamat" => $val->tarikh_tamat,
                "latitude" => $val->latitude,
                "longitude" => $val->longitude,
                "keterangan" => $val->keterangan,
                "masa_sesi" => $sesi ?? null,
                "lokasi" => $val->lokasi,
                "urusetia" => $val->urusetia,
                "user" => $user ?? null,
            );
        }
        $obj->aktiviti = $aktiviti;
        // return json_encode($obj);
        return response()->json($obj);        
  
              
    }

    

    public function aktiviti_by_transid(Request $request)
    {
        $transid = $request->transid_aktiviti;

        $list = DB::select("select a.*, b.urusetia from aktivitis a, urusetias b where a.transid_aktiviti = '$transid' and a.transid_aktiviti = b.transid_aktiviti order by a.tarikh_mula desc");


        $obj = new Stdclass();

        if (!$list  ) {
            return [
                'code' => 404,
                'message' => 'Tiada rekod'
            ];
        };

        foreach ($list as $val) {
            $id_aktiviti = $val->id;

            $list_urusetia = DB::select("select a.*,b.nama,b.namabahagian,b.nokp from urusetias a, users b where a.urusetia = b.nokp and  id_aktiviti = '$id_aktiviti' order by b.nama");
            unset($urusetia);
            foreach ($list_urusetia as $valurusetia) {
                $urusetia[] = array(
                    "nokp" => $valurusetia->urusetia,
                    "nama" => $valurusetia->nama,
                    "namabahagian" => $valurusetia->namabahagian,
                );
            }
            $transid_aktiviti = $val->transid_aktiviti;
            $sesidata = DB::select('select * from sesis where transid_aktiviti = ?', [$transid_aktiviti]);
            unset($sesi);
            foreach ($sesidata as $val21) {
                $sesi[] = array(
                    "transid_sesi" => $val21->transid_sesi,
                    "sesi" => $val21->sesi,
                    "masa_mula" => $val21->masa_mula,
                    "masa_tamat" => $val21->masa_tamat,
                );
            }
            $aktivitiDb = Aktiviti::find($val->id);
            if ($aktivitiDb){
                $user = User::find($aktivitiDb->create_by);
            }
            $aktiviti[] = array(
                "id" => $val->id,
                "bilangan_hari" => $val->bilangan_hari,
                "bilangan_sesi" => $val->bilangan_sesi,
                "transid_aktiviti" => $transid_aktiviti,
                "nama_aktiviti" => $val->nama_aktiviti,
                "tarikh_mula" => $val->tarikh_mula,
                "tarikh_tamat" => $val->tarikh_tamat,
                "latitude" => $val->latitude,
                "longitude" => $val->longitude,
                "keterangan" => $val->keterangan,
                "masa_sesi" => $sesi ?? null,
                "lokasi" => $val->lokasi,
                "urusetia" => $val->urusetia,
                "user" => $user ?? null,
            );
        }
        $obj->aktiviti = $aktiviti;
        // return json_encode($obj);
        return response()->json($obj);        
    }

    // saja test utk daftar
    // function daftar(Request $request)
    // {
    //     // $contents = file_get_contents("php://input");
    //     // $data = json_decode($contents);
    //     $nokp = $request->nokp;
    //     $bahagian = $request->bahagian;
    //     $id_aktiviti = $request->id_aktiviti;
    //     $jenis = $request->jenis_pendaftaran;
    //     $transid_aktiviti = $request->transid_aktiviti;
    //     $transid_sesi = $request->transid_sesi;
    //     // $response= "";
    //     // dd($nokp);

    //     // $kedatangan = $this->apiModel->getKedatangan($nokp,$id_aktiviti);
    //     $kedatangan = DB::select("select * from kedatangans where nokp = '$nokp' and transid_aktiviti = '$transid_aktiviti'");
    //     // dd($kedatangan);

    //     $obj = new stdClass();

    //     if(count($kedatangan) > 0) {
    //         $response[] = array(
    //             "kod" => "1",
    //             "message" => "Telah mendaftar"
    //         );
    //         $obj->kod = 1;
    //         $obj->message = "Telah Mendaftar";    
    //     }else{
    //         if($nokp == "" || $id_aktiviti == "" || $bahagian == ""){
    //             $obj->kod = 2;
    //             $obj->message = "Sila pastikan anda scan QR Kod yang betul.";
    //         }else{
    //             // $this->apiModel->insertKedatangan($nokp,$bahagian,$id_aktiviti);
    //             $sql = DB::select("insert into kedatangans (nokp,transid_aktiviti,kodbahagian,transid_sesi,aktiviti_id) values ('$nokp','$transid_aktiviti','$bahagian','$transid_sesi','$id_aktiviti')");
    //             $response[] = array(
    //                 "kod" => "0",
    //                 "message" => "Pendaftaran berjaya"
    //                 );
    //             $obj->kod = 0;
    //             $obj->message = "Pendaftaran Berjaya";
    //         }
    //     }
    //     // dd($obj);
        
    //     if($jenis == "manual"){
    //         $maklumat_pengguna = jpjpStaff::with('bahagian')->where('nokp',$nokp)->get();
    //         $obj->nama = $maklumat_pengguna[0]['nama'];
    //     }
    //     echo json_encode($obj);        
    // }

    // testing utk daftar_manual
    // function daftar2(){
    //     // $contents = file_get_contents("php://input");
    //     // $data = json_decode($contents);
    //     $nokp = $request->nokp;
    //     $id_aktiviti = $request->id_aktiviti;
    //     $jenis = $request->jenis_pendaftaran;
    //     $transid_aktiviti = $request->transid_aktiviti;
    //     $transid_sesi = $request->transid_sesi;
    //     // $response= "";
    //     $kedatangan = DB::select("select * from kedatangans where nokp = '$nokp' and transid_aktiviti = '$transid_aktiviti'");

    //     $obj = new stdClass();
        
    //     if(count($kedatangan)>0){
    //         $obj->kod =1;
    //         $obj->message = "Telah Mendaftar.";    
    //     }
    //     else{
    //         if($nokp == "" || $id_aktiviti == ""){
    //             $obj->kod = 2;
    //             $obj->message = "Sila pastikan anda scan QR Kod yang betul";
    //         }else{
    //             $data = $this->apiModel->getUser($nokp);
    //             $bahagian = $data[0]['bahagian'];

    //             $this->apiModel->insertKedatangan($nokp,$bahagian,$transid_aktiviti,$transid_sesi,$id_aktiviti);
                
    //             $obj->kod = 0;
    //             $obj->message = "Pendaftaran Berjaya.";
    //             $obj->nama = $data[0]['nama'];
    //             $obj->nokp = $nokp;
    //             $obj->bahagian = $data[0]['namabahagian'];
                
    //         }
    //     }
        
    //     if($jenis == "manual"){
    //         $maklumat_pengguna = $this->apiModel->getUser($nokp);
    //         $obj->nama = $maklumat_pengguna[0]['nama'];
    //     }
    //     echo json_encode($obj);        
    // }

}

