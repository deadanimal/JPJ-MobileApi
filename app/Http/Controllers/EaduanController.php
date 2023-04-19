<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\BahanAduan;
use App\Models\Ref;
use App\Models\User;
use App\Models\MobileappsUser;
use App\Models\NoSiri;
use App\Models\Pengadu;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use stdClass;
use Illuminate\Support\Facades\Storage;

class EaduanController extends Controller
{
    public function simpan_aduan(Request $request)
    {
        $idkesalahan = $request->idkesalahan;
        $tarikh = $request->tarikh;
        $masa = $request->masa;
        $lokasi = $request->lokasi;
        $latitude = $request->latitude;
        $longitude = $request->longlitude;
        $nokenderaan = $request->nokenderaan;
        $catatan = $request->catatan;
        $status = 0;
        $userid = $request->pengadu;
        $negeri = strtoupper($request->negeri);
        $uuid = $request->device_id;
        $pautan = $request->pautan;
        $phone = $request->phone;
        $onesignal_id = null;

        $no = NoSiri::where('jenis', '1')->first();
        $no_siri = $no->no_siri + 1;
        $no->no_siri = $no_siri;
        $no->save();

        if ($negeri == strtoupper("Perlis")) {
            $kod_negeri = "09";
        } elseif ($negeri == strtoupper("Pulau Pinang")) {
            $kod_negeri = "07";
        } elseif ($negeri == strtoupper("Kedah")) {
            $kod_negeri = "02";
        } elseif ($negeri == strtoupper("Langkawi")) {
            $kod_negeri = "02";
        } elseif ($negeri == strtoupper("Perak")) {
            $kod_negeri = "08";
        } elseif ($negeri == strtoupper("Selangor")) {
            $kod_negeri = "10";
        } elseif ($negeri == strtoupper("Negeri Sembilan")) {
            $kod_negeri = "05";
        } elseif ($negeri == strtoupper("Melaka")) {
            $kod_negeri = "04";
        } elseif ($negeri == strtoupper("Johor")) {
            $kod_negeri = "01";
        } elseif ($negeri == strtoupper("Pahang")) {
            $kod_negeri = "06";
        } elseif ($negeri == strtoupper("Terengganu")) {
            $kod_negeri = "11";
        } elseif ($negeri == strtoupper("Kelantan")) {
            $kod_negeri = "03";
        } elseif ($negeri == strtoupper("Sabah")) {
            $kod_negeri = "12";
        } elseif ($negeri == strtoupper("Sarawak")) {
            $kod_negeri = "13";
        } elseif ($negeri == strtoupper("W.P Kuala Lumpur")) {
            $kod_negeri = "14";
        } elseif ($negeri == strtoupper("W.P Labuan")) {
            $kod_negeri = "15";
        } else {
            $kod_negeri = "16";
        }
		
		// date: 24/11
        // date: 25/11
        if ($idkesalahan == "1") {
            // redlight
            $idkesalahan = "1";
        } else if ($idkesalahan == "2") {
            // emergencyLane
            $idkesalahan = "4";
        } else if ($idkesalahan == "3") {
            // cutQueue
            $idkesalahan = "7";
        } else if ($idkesalahan == "4") {
            // leftOvertake
            $idkesalahan = "6";
        } else if ($idkesalahan == "5") {
            // doubleLine
            $idkesalahan = "2";
        } else if ($idkesalahan == "6") {
            // usingPhone
            $idkesalahan = "3";
        } else if ($idkesalahan == "7") {
            // fancyPlate
            $idkesalahan = "8";
        } else if ($idkesalahan == "8") {
            // darkTint
            $idkesalahan = "9";
        } else if ($idkesalahan == "9") {
            // seatBelt
            $idkesalahan = "5";
        }
		
        if ($userid != "") {
            // $update_date = date("Y-m-d H:i:s");
            $data = new Aduan;
            $data->no_aduan = $no_siri;
            $data->jenis_kesalahan = $idkesalahan;
            $data->tarikh_kesalahan = $tarikh;
            $data->masa_kesalahan = $masa;
            $data->lokasi_kesalahan = $lokasi;
            $data->latitude = $latitude;
            $data->longitude = $longitude;
            $data->no_kenderaan = $nokenderaan;
            $data->catatan = $catatan;
            $data->pengadu = $userid;
            $data->negeri = $negeri;
            $data->device_id = $uuid;
            $data->status_aduan = $status;
            $data->kod_negeri = $kod_negeri;
            $data->pautan = $pautan;
            $data->phone = $phone;
            $data->onesignal_id = $onesignal_id;

            if ($request->gambar) {

                $files = $request->file('gambar');
                $i = 0;

                foreach ($files as $key => $f) {
                    $file_name = array();
                    // check type file
                    $nama = $f->getClientOriginalName();
                    $jenis_file = $f->getClientOriginalExtension();

                    $nama_fail = $nama;

                    if ($jenis_file == 'png' || $jenis_file == 'jpg' || $jenis_file == 'jpeg') {
                        $jenis_media = "photo";
                    } elseif ($jenis_file == 'mp4' || $jenis_file == 'wma' || $jenis_file == 'wav' || $jenis_file == 'mov') {
                        $jenis_media = "video";
                    }

                    // upload
                    $file = $f;
                    $nama = $f->getClientOriginalName();

                    // Storage::disk('sftp')->putFileAs('/home/aduantrafikmobiles/' . $no_siri, $file, $nama);
                    // Storage::disk('sftp2')->putFileAs('/usr/share/nginx/html/jpj-api/storage/app/public/aduantrafikdb/client_share/' . $no_siri, $file, $nama);
                    Storage::disk('public')->putFileAs('/aduantrafikmobile/client_share/' . $no_siri, $file, $nama);
                    // dd('sini');
                    // upload banyak2
                    $bahan = new BahanAduan();
                    $bahan->name = $nama;
                    $bahan->path = '/aduantrafikdb/client_share/' . $no_siri . '/' . $nama;
                    $bahan->no_aduan = $no_siri;
                    $bahan->nokp = $userid;
                    $bahan->save();

                    array_push($file_name, $bahan);
                }
            } else {
                $file_name = 'File not available';
            }

            $file_up = BahanAduan::where('no_aduan', $no_siri)->get();
            $type = 'none';
            $nama_bahan = '';
            foreach ($file_up as $key => $fu) {
                $type_file = substr($fu->path, -3);
                // dd($type_file);
                if ($type_file == 'jpg' || 'jpeg' || 'png') {
                    $type_file = 'photo';
                } else {
                    $type_file = 'video';
                }
                if ($type == 'none') {
                    $type = $type_file;
                } else {
                    if ($type_file == $type) {
                        $type = $type;
                    } else {
                        $type = 'both';
                    }
                }

                $nama_bahan_temp = $fu->name . '|';
                $nama_bahan = $nama_bahan . $nama_bahan_temp;
            }
            $data->nama_fail = $nama_bahan;
            $data->jenis_media = $type;


            // create pengadu
            $soapUrl = "https://mobile.jpj.gov.my/jpj-revamp-svc-pvr-ws/idm_public_mobile_registration";
            $soapUser = "username";  //  username
            $soapPassword = "password"; // password
            $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:idm="http://www.example.org/idm_public_mobile_registration/">
            <soapenv:Header/>
            <soapenv:Body>
               <idm:findPublicUser>
                  <!--Optional:-->
                  <userId>' . $userid . '</userId>
               </idm:findPublicUser>
            </soapenv:Body>
         </soapenv:Envelope>';

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: http://www.example.org/idm_public_mobile_registration/",
                "Content-length: " . strlen($xml_post_string),
            ); //SOAPAction: your op URL

            $url = $soapUrl;
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch);
            // dd($response);
            curl_close($ch);

            $doc1 = new DOMDocument();
            $doc1->loadXML($response);

            $response_status = $doc1->getElementsByTagName('respSta')->item(0)->nodeValue;
            $response_msg = $doc1->getElementsByTagName('respMsg')->item(0)->nodeValue;
            // dd($userID);

            if ($response_status == 00) {
                $userID = $doc1->getElementsByTagName('userID')->item(0)->nodeValue;
                $userName = $doc1->getElementsByTagName('userName')->item(0)->nodeValue;
                $userEmail = $doc1->getElementsByTagName('userEmail')->item(0)->nodeValue;
                $userPhone = $doc1->getElementsByTagName('userPhone')->item(0)->nodeValue;
                $userCat = $doc1->getElementsByTagName('userCat')->item(0)->nodeValue;

                $adu = new stdclass;
                $adu->status = $response_status;
                $adu->message = $response_msg;

                $adu->nokp = $userID;
                $adu->name = $userName;
                $adu->email = $userEmail;
                $adu->phone = $userPhone;
                $adu->category = $userCat;

                // check pengadu
                $reporter = Pengadu::where('username', $userID)->first();

                if ($reporter == null) {
                    $pengadu = new Pengadu();
                    $pengadu->username = $userid;
                    $pengadu->nama = $userName;
                    $pengadu->nokp = $userid;
                    $pengadu->emel = $userEmail;
                    $pengadu->telefon = $userPhone;
                    $pengadu->save();
                }


                $data->save();

                $response = new stdClass;
                $response->status = "saved";
                $response->status_save = $data;


                return response()->json($response);
            }

            $response = new stdClass;
            $response->status = "error";
            $response->status_save = "Data pengadu tidak dijumpai";


            return response()->json($response);
        }
    }

    public function upld_images(Request $request)
    {

        try {
            $check = $request->validate([
                'gambar' => 'mimes:jpeg,png,jpg,gif,mp3,mp4,wma',
            ]);
        } catch (\Throwable $th) {
            $resp = new stdClass;
            $resp->message = "File type not compatible";
            return response()->json($resp);
        }

        if ($request->gambar) {

            $nama = time() . '_' . $request->gambar . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('aduantrafikdb/client_share/'), $nama);
            $obj = new stdClass;
            $obj->upload = $request->gambar;
            $obj->type = $request->gambar->getClientOriginalExtension();
            $saiz = $request->gambar->getSize();
            $saiz = $saiz / 1024;
            $obj->size = $saiz . ' kb';
            $obj->file = 'aduantrafikdb/client_share' . $nama;

            // $disk = Storage::build([
            //     'driver' => 'sftp',
            //     'root' => '/',
            // ]);

            // $disk->put($nama, $request->gambar);
        } else {
            $obj = new stdClass;
            $obj->message = "Error";
        }

        return response()->json($obj);
    }

    public function get_status_aduan(Request $request)
    {
        $userid = $request->nokp;

        $data = Aduan::where('pengadu', $userid)->get();
        // dd($data);
        $senarai_aduan = [];
        foreach ($data as $key => $val) {
            $status = Ref::where('jenis', '2')->where('kod', $val['status_aduan'])->first()->keterangan;
            if ($val['jenis_kesalahan'] == 1) {
                $nama_kesalahan = "Gagal mematuhi lampu isyarat merah";
            } elseif ($val['jenis_kesalahan'] == 4) {
                $nama_kesalahan = "Memandu di lorong kecemasan";
            } elseif ($val['jenis_kesalahan'] == 7) {
                $nama_kesalahan = "Memotong barisan";
            } elseif ($val['jenis_kesalahan'] == 6) {
                $nama_kesalahan = "Memotong sebelah kiri";
            } elseif ($val['jenis_kesalahan'] == 2) {
                $nama_kesalahan = "Memotong garisan berkembar";
            } elseif ($val['jenis_kesalahan'] == 3) {
                $nama_kesalahan = "Menggunakan telefon bimbit semasa memandu";
            } elseif ($val['jenis_kesalahan'] == 8) {
                $nama_kesalahan = "No plat fancy";
            } elseif ($val['jenis_kesalahan'] == 9) {
                $nama_kesalahan = "Cermin gelap";
            } elseif ($val['jenis_kesalahan'] == 5) {
                $nama_kesalahan = "Tidak memakai tali pinggang keledar dan helmet";
            }

            $k = [
                "nokp_pengadu" => $val['pengadu'],
                "no_aduan" => $val['no_aduan'],
                "status" => $val['status_aduan'],
                "id" => $val['id'],
                "keterangan_status" => $status,
                "send_flag" => $val['send_flag'],
                "tarikh" => $val['tarikh_kesalahan'],
                "masa" => $val['masa_kesalahan'],
                "kesalahan" => $nama_kesalahan,
                "lokasi_kesalahan" => $val['lokasi_kesalahan'],
                "negeri" => $val['negeri'],
                "telefon" => $val['phone'],
                "longitude" => $val['longitude'],
                "latitude" => $val['latitude'],
                "no_kenderaan" => $val['no_kenderaan'],
                "pautan" => $val['pautan'],
                "catatan" => $val['catatan'],

            ];
            $id = $val['id'];
            array_push($senarai_aduan, $k);
        }
        // dd($data);

        // DB::select("select a.*,(select b.keterangan_apps from ref b where b.jenis = '2' and b.kod = a.status_aduan) as keterangan_status from aduan a where a.pengadu = '$userid' and a.send_flag <> '0'");
        // $data = DB::select("select a.*,(select b.keterangan_apps from ref b where b.jenis = '2' and b.kod = a.status_aduan) as keterangan_status from aduan a where a.pengadu = '$userid'");

        // DB::select("update aduan set send_flag = status_aduan where id = '$id'");
        return response()->json($senarai_aduan);
    }

    public function get_kemaskini_aduan($no_aduan)
    {
        $aduan = Aduan::where('no_aduan', $no_aduan)->first();
        $status = Ref::where('jenis', '2')->where('kod', $aduan['status_aduan'])->first()->keterangan;
        if ($aduan['jenis_kesalahan'] == 1) {
            $nama_kesalahan = "Gagal mematuhi lampu isyarat merah";
        } elseif ($aduan['jenis_kesalahan'] == 2) {
            $nama_kesalahan = "Memandu di lorong kecemasan";
        } elseif ($aduan['jenis_kesalahan'] == 3) {
            $nama_kesalahan = "Memotong barisan";
        } elseif ($aduan['jenis_kesalahan'] == 4) {
            $nama_kesalahan = "Memotong sebelah kiri";
        } elseif ($aduan['jenis_kesalahan'] == 5) {
            $nama_kesalahan = "Memotong garisan berkembar";
        } elseif ($aduan['jenis_kesalahan'] == 6) {
            $nama_kesalahan = "Menggunakan telefon bimbit semasa memandu";
        } elseif ($aduan['jenis_kesalahan'] == 7) {
            $nama_kesalahan = "No plat fancy";
        } elseif ($aduan['jenis_kesalahan'] == 8) {
            $nama_kesalahan = "Cermin gelap";
        } elseif ($aduan['jenis_kesalahan'] == 9) {
            $nama_kesalahan = "Tidak memakai tali pinggang keledar dan helmet";
        }
        $aduan['nama_kesalahan'] = $nama_kesalahan;
        $bahan = explode('|', $aduan['nama_fail']);
        $file_link = [];
        foreach ($bahan as $key => $b) {
            if ($b != '') {
                $link = 'https://myjpj.jpj.gov.my/aduantrafikmobile/client_share/' . $aduan['no_aduan'] . '/' . $b;
                array_push($file_link, $link);
            }
        }
        $aduan['link_bahan'] = $file_link;
        return response()->json($aduan);
    }

    public function kemaskini_aduan(Request $request, $no_aduan)
    {
        $idkesalahan = $request->idkesalahan;
        $tarikh = $request->tarikh;
        $masa = $request->masa;
        $lokasi = $request->lokasi;
        $latitude = $request->latitude;
        $longitude = $request->longlitude;
        $nokenderaan = $request->nokenderaan;
        $catatan = $request->catatan;
        $status = 3;
        $userid = $request->pengadu;
        $negeri = strtoupper($request->negeri);
        $uuid = $request->device_id;
        $pautan = $request->pautan;
        $phone = $request->phone;
        // $onesignal_id = '121';

        if ($negeri == strtoupper("Perlis")) {
            $kod_negeri = "09";
        } elseif ($negeri == strtoupper("Pulau Pinang")) {
            $kod_negeri = "07";
        } elseif ($negeri == strtoupper("Kedah")) {
            $kod_negeri = "02";
        } elseif ($negeri == strtoupper("Langkawi")) {
            $kod_negeri = "02";
        } elseif ($negeri == strtoupper("Perak")) {
            $kod_negeri = "08";
        } elseif ($negeri == strtoupper("Selangor")) {
            $kod_negeri = "10";
        } elseif ($negeri == strtoupper("Negeri Sembilan")) {
            $kod_negeri = "05";
        } elseif ($negeri == strtoupper("Melaka")) {
            $kod_negeri = "04";
        } elseif ($negeri == strtoupper("Johor")) {
            $kod_negeri = "01";
        } elseif ($negeri == strtoupper("Pahang")) {
            $kod_negeri = "06";
        } elseif ($negeri == strtoupper("Terengganu")) {
            $kod_negeri = "11";
        } elseif ($negeri == strtoupper("Kelantan")) {
            $kod_negeri = "03";
        } elseif ($negeri == strtoupper("Sabah")) {
            $kod_negeri = "12";
        } elseif ($negeri == strtoupper("Sarawak")) {
            $kod_negeri = "13";
        } elseif ($negeri == strtoupper("W.P Kuala Lumpur")) {
            $kod_negeri = "14";
        } elseif ($negeri == strtoupper("W.P Labuan")) {
            $kod_negeri = "15";
        } else {
            $kod_negeri = "16";
        }
		
		// date: 24/11
        // date: 25/11
        if ($idkesalahan == "1") {
            // redlight
            $idkesalahan = "1";
        } else if ($idkesalahan == "2") {
            // emergencyLane
            $idkesalahan = "4";
        } else if ($idkesalahan == "3") {
            // cutQueue
            $idkesalahan = "7";
        } else if ($idkesalahan == "4") {
            // leftOvertake
            $idkesalahan = "6";
        } else if ($idkesalahan == "5") {
            // doubleLine
            $idkesalahan = "2";
        } else if ($idkesalahan == "6") {
            // usingPhone
            $idkesalahan = "3";
        } else if ($idkesalahan == "7") {
            // fancyPlate
            $idkesalahan = "8";
        } else if ($idkesalahan == "8") {
            // darkTint
            $idkesalahan = "9";
        } else if ($idkesalahan == "9") {
            // seatBelt
            $idkesalahan = "5";
        }

        // $update_date = date("Y-m-d H:i:s");
        $data = Aduan::where('no_aduan', $no_aduan)->first();
        $data->jenis_kesalahan = $idkesalahan;
        $data->tarikh_kesalahan = $tarikh;
        $data->masa_kesalahan = $masa;
        $data->lokasi_kesalahan = $lokasi;
        $data->latitude = $latitude;
        $data->longitude = $longitude;
        $data->no_kenderaan = $nokenderaan;
        $data->catatan = $catatan;
        $data->pengadu = $userid;
        $data->negeri = $negeri;
        $data->device_id = $uuid;
        $data->status_aduan = $status;
        $data->kod_negeri = $kod_negeri;
        $data->pautan = $pautan;
        $data->phone = $phone;
        // $data->onesignal_id = $onesignal_id;

        if ($request->gambar) {

            $files = $request->file('gambar');
            $i = 0;

            foreach ($files as $key => $f) {
                $file_name = array();
                // check type file
                $nama = $f->getClientOriginalName();
                $jenis_file = $f->getClientOriginalExtension();

                $nama_fail = $nama;

                if ($jenis_file == 'png' || $jenis_file == 'jpg' || $jenis_file == 'jpeg') {
                    $jenis_media = "photo";
                } elseif ($jenis_file == 'mp4' || $jenis_file == 'wma' || $jenis_file == 'wav') {
                    $jenis_media = "video";
                }

                // upload
                $file = $f;
                $nama = $f->getClientOriginalName();

                Storage::disk('sftp')->putFileAs('/aduantrafikdb/client_share/' . $no_aduan, $file, $nama);
                // dd('sini');
                // upload banyak2
                $bahan = new BahanAduan();
                $bahan->name = $nama;
                $bahan->path = '/aduantrafikmobile/client_share/' . $no_aduan . '/' . $nama;
                $bahan->no_aduan = $no_aduan;
                $bahan->nokp = $userid;
                $bahan->save();

                array_push($file_name, $bahan);
            }
        } else {
            $file_name = 'File not available';
        }

        $file_up = BahanAduan::where('no_aduan', $no_aduan)->get();
        $type = 'none';
        $nama_bahan = '';
        foreach ($file_up as $key => $fu) {
            $type_file = substr($fu->path, -3);
            // dd($type_file);
            if ($type_file == 'jpg' || 'jpeg' || 'png') {
                $type_file = 'photo';
            } else {
                $type_file = 'video';
            }
            if ($type == null) {
                $type = $type_file;
            } else {
                if ($type_file == $type) {
                    $type = $type;
                } else {
                    $type = 'both';
                }
            }

            // $nama_bahan = $fu->name . '|';
            $nama_bahan_temp = $fu->name . '|';
            $nama_bahan = $nama_bahan . $nama_bahan_temp;
        }
        $data->nama_fail = $nama_bahan;
        $data->jenis_media = $type;

        $data->save();

        $response = new stdClass;
        $response->status = "updated";
        $response->status_save = $data;


        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $aduan = Aduan::where('no_aduan', $id)->first();

        try {
            $aduan->delete();

            $resp = new stdClass;
            $resp->status = "Successful deleted";
            return response()->json($resp);
        } catch (\Throwable $th) {
            $resp = new stdClass;
            $resp->status = "Error";
            return response()->json($resp);
        }
    }

    public function checksajo()
    {
        $idkesalahan = 1;
        $tarikh = "2022-01-01";
        $masa = "2:02";
        $lokasi = "Selayang";
        $latitude = "1";
        $longitude = "1";
        $nokenderaan = "BEX2820";
        $catatan = "CHeckSajo";
        $status = 1;
        $userid = "980410025195";
        $image = "";
        $negeri = "Selangor";
        $jenis_media = "";
        $uuid = "123";
        $pautan = "najhan.xyz";
        $video = "";
        $onesignal_id = null;

        if ($image != "" && $video == "") {
            $nama_fail = $image . "|";
            $jenis_media = "photo";
        } elseif ($video != "" && $image == "") {
            $nama_fail = $video . "|";
            $jenis_media = "video";
        } elseif ($video != "" && $image != "") {
            $nama_fail = $image . "|" . $video;
            $jenis_media = "both";
        } else {
            $nama_fail = "|";
            $jenis_media = "none";
        }


        // $no = NoSiri::where('jenis', '1')->get();
        // if (!$no->isEmpty()) {
        //     $no_siri = $no[0]['no_siri'];
        //     $no_siri++;
        // } else {
        //     # code...
        // }

        $no_siri = rand(100000, 999999);

        // DB::select("update no_siri set no_siri = '$no_siri' where jenis = '1'");

        // $idkesalahan = $_POST['idkesalahan'];
        // $tarikh = $_POST['tarikh'];
        // $masa = $_POST['masa'];
        // $lokasi = $_POST['lokasi'];
        // $latitude = $_POST['latitude'];
        // $longitude = $_POST['longlitude'];
        // $nokenderaan = $_POST['nokenderaan'];
        // $catatan = $_POST['catatan'];
        // $status = $_POST['status'];
        // $userid = $_POST['userId'];

        if ($negeri == "Perlis") {
            $kod_negeri = "09";
        } elseif ($negeri == "Pulau Pinang") {
            $kod_negeri = "07";
        } elseif ($negeri == "Kedah") {
            $kod_negeri = "02";
        } elseif ($negeri == "Perak") {
            $kod_negeri = "08";
        } elseif ($negeri == "Selangor") {
            $kod_negeri = "10";
        } elseif ($negeri == "Negeri Sembilan") {
            $kod_negeri = "05";
        } elseif ($negeri == "Melaka") {
            $kod_negeri = "04";
        } elseif ($negeri == "Johor") {
            $kod_negeri = "01";
        } elseif ($negeri == "Pahang") {
            $kod_negeri = "06";
        } elseif ($negeri == "Terengganu") {
            $kod_negeri = "11";
        } elseif ($negeri == "Kelantan") {
            $kod_negeri = "03";
        } elseif ($negeri == "Sabah") {
            $kod_negeri = "12";
        } elseif ($negeri == "Sarawak") {
            $kod_negeri = "13";
        } elseif ($negeri == "Wilayah Persekutuan Kuala Lumpur") {
            $kod_negeri = "14";
        } elseif ($negeri == "Wilayah Persekutuan Labuan") {
            $kod_negeri = "15";
        } else {
            $kod_negeri = "16";
        }
        if ($userid != "") {
            // $update_date = date("Y-m-d H:i:s");
            $data = new Aduan;
            $data->no_aduan = $no_siri;
            $data->jenis_kesalahan = $idkesalahan;
            $data->tarikh_kesalahan = $tarikh;
            $data->masa_kesalahan = $masa;
            $data->lokasi_kesalahan = $lokasi;
            $data->latitude = $latitude;
            $data->longitude = $longitude;
            $data->no_kenderaan = $nokenderaan;
            $data->catatan = $catatan;
            $data->pengadu = $userid;
            $data->nama_fail = $nama_fail;
            $data->negeri = $negeri;
            $data->jenis_media = $jenis_media;
            $data->device_id = $uuid;
            $data->kod_negeri = $kod_negeri;
            $data->pautan = $pautan;
            $data->onesignal_id = $onesignal_id;
            // dd($data->all(), $request->all());
            $data->save();
            // $bilpengadu = DB::select("select * from users where nokp = '$userid'");
            // if(count($pengadu) == 1){
            //     DB::select("update users set onesignal_id = '$onesignal_id' where nokp = '$userid'");
            // }
            dd('habis');
        }
    }

    public function page_up()
    {
        return view('test_upload');
    }

    public function tryvideo()
    {
        // $fileContents = Storage::disk('local')->get("/public/aduantrafikdb/client_share/10007526/attachement_vid_0.mp4");
        // dd($fileContents);
        // $response = Response::make($fileContents, 200);
        // $response->header('Content-Type', "video/mp4");
        // echo $response;

        $path = storage_path('app/public/aduantrafikdb/client_share/10007526/attachement_vid_0.mp4');

        if (!File::exists($path)) {
            abort(404);
        }

        $stream = new \App\Http\VideoStream($path);

        return response()->stream(function() use ($stream) {
            $stream->start();
        });
    }

    public function gambar($no_aduan, $nama_file)
    {
        // dd('try');
        // no aduan 10005775, nama file 1658654262165.jpg
        // $image = file_get_contents("/var/www/html/aduantrafikmobile/public/client_share/1637208487656.jpg");
        return response()->file('/usr/share/nginx/html/jpj-api/storage/app/public/aduantrafikmobile/client_share/'.$no_aduan.'/'.$nama_file);
        // return redirect('/storage/app/public/aduantrafikmobile/client_share/'.$no_aduan.'/'.$nama_file);
    }

    public function gambar2($nama_file)
    {
        return response()->file('/usr/share/nginx/html/jpj-api/storage/app/public/aduantrafikmobile/client_share/'.$nama_file);
    }
}
