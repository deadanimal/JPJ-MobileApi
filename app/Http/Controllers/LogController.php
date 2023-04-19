<?php

namespace App\Http\Controllers;

use App\Models\Datalog;
use App\Models\Log;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;

class LogController extends Controller
{
    public static function insertLog($ip, $services, $function, $ref, $agent, $hostname)
    {
        $log = new Log();
        $log->ip = $ip;
        $log->services = $services;
        $log->function = $function;
        $log->ref = $ref;
        $log->agent = $agent;
        $log->hostname = $hostname;
        $log->save();
    }

    public static function insertDatalog($jenis, $jenis_data, $ip, $services, $function, $soapUrl, $data)
    {
        $datalog = new Datalog();
        $datalog->jenis = $jenis;
        $datalog->jenis_data = $jenis_data;
        $datalog->ip = $ip;
        $datalog->services = $services;
        $datalog->function = $function;
        $datalog->soapurl = $soapUrl;
        $datalog->data = $data;
        $datalog->save();
    }

    public function nfs(Request $request)
    {
        $file = $request->file('theFile');
        $name = $request->file('theFile')->getClientOriginalName();
        $result = Storage::disk('sftp')->putFileAs('/aduantrafikdb/client_share', $file, $name);
        return $result;
    }

    public function semakIdAwam(Request $request)
    {
        $nokp = $request->nokp;
        // $function = "semakIdAwam";
        // $service = "Semak ID Awam";
        // $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['REMOTE_ADDR'];
        // $ref = $_SERVER['HTTP_REFERER'];
        // $agent = $_SERVER['HTTP_USER_AGENT'];
        // $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        // LogController::insertLog($ip, $service, $function, '', $agent, $host_name);

        $jenis = 1;
        $jenis_data = "JSON";
        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/ebid_ws";
        $data = json_encode($request->all());
        // LogController::insertDatalog($jenis, $jenis_data, $ip, 'services', $function, $soapUrl, $data);

        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/ebid_ws";
        $soapUser = "username";  //  username
        $soapPassword = "password"; // password
        $xml_post_string = '
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ebid="http://www.jpj.gov.my/ebid_ws/">
                        <soapenv:Header/>
                        <soapenv:Body>
                            <ebid:findOwnerById>
                                <!--Optional:-->
                                <header>
                                    <module>?</module>
                                    <channel>?</channel>
                                    <agency>?</agency>
                                    <branch>?</branch>
                                    <pcid>?</pcid>
                                    <userId>?</userId>
                                    <transCode>?</transCode>
                                    <currDate>?</currDate>
                                    <currTime>?</currTime>
                                    <deviceId>?</deviceId>
                                </header>
                                <!--Optional:-->
                                <id>'.$nokp.'</id>
                            </ebid:findOwnerById>
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
        // return response()->json($response);
        curl_close($ch);

        $doc1 = new DOMDocument();
        $doc1->loadXML($response);

        $response_status = $doc1->getElementsByTagName('respSta')->item(0)->nodeValue;
        $response_msg = $doc1->getElementsByTagName('respMsg')->item(0)->nodeValue;
        // dd($userID);

        if ($response_status == 00) {

            $refNo = $doc1->getElementsByTagName('refNo')->item(0)->nodeValue;
            $ownerId = $doc1->getElementsByTagName('ownerId')->item(0)->nodeValue;
            $name = $doc1->getElementsByTagName('name')->item(0)->nodeValue;
            $category = $doc1->getElementsByTagName('category')->item(0)->nodeValue;
            $birthDate = $doc1->getElementsByTagName('birthDate')->item(0)->nodeValue;
            $sex = $doc1->getElementsByTagName('sex')->item(0)->nodeValue;
            $address1 = $doc1->getElementsByTagName('address1')->item(0)->nodeValue;
            $address2 = $doc1->getElementsByTagName('address2')->item(0)->nodeValue;
            $address3 = $doc1->getElementsByTagName('address3')->item(0)->nodeValue;
            $stateCode = $doc1->getElementsByTagName('stateCode')->item(0)->nodeValue;
            $cityCode = $doc1->getElementsByTagName('cityCode')->item(0)->nodeValue;
            $postcode = $doc1->getElementsByTagName('postcode')->item(0)->nodeValue;
            $status = $doc1->getElementsByTagName('status')->item(0)->nodeValue;
            $isFromCRS = $doc1->getElementsByTagName('isFromCRS')->item(0)->nodeValue;
            
        }

        $obj = new stdClass;
        $obj->status = $response_status;
        $obj->message = $response_msg;
        if ($response_status == 00) {
            $obj->refNo = $refNo;
            $obj->ownerId = $ownerId;
            $obj->name = $name;
            $obj->category = $category;
            $obj->birthDate = $birthDate;
            $obj->sex = $sex;
            $obj->address1 = $address1;
            $obj->address2 = $address2;
            $obj->address3 = $address3;
            $obj->stateCode = $stateCode;
            $obj->cityCode = $cityCode;
            $obj->postcode = $postcode;

            $obj->status = $status;
            $obj->isFromCRS = $isFromCRS;
            $obj->postcode = $postcode;
        }

        $jenis = 3;
        $jenis_data = "XML";
        // LogController::insertDatalog($jenis, $jenis_data, $ip, 'services', $function, $soapUrl, $raw);

        $jenis = 4;
        $jenis_data = "JSON";
        // LogController::insertDatalog($jenis, $jenis_data, $ip, 'services', $function, $soapUrl, json_encode($response));

        return response()->json($obj);
    }
}
