<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\PetiMasuk;
use App\Models\Ref;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use stdClass;

class JpjMobileApiController extends Controller
{
    public function semakstatusbank()
    {
        $dataObj = new stdClass();
        $soapUrl = "http://172.18.3.121:9080/jpj-revamp-svc-pvr-ws/mobile_public";

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:mob="http://www.jpj.gov.my/mobile_public/">
                                <soapenv:Header/>
                                <soapenv:Body>
                                    <mob:listBankFPX>
                                        <in></in>
                                    </mob:listBankFPX>
                                </soapenv:Body>
                            </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/mobile_public/",
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
        curl_close($ch);
        // dd($response);
        $doc = new \DOMDocument();
        $doc->loadXML($response);
        $bil = $doc->getElementsByTagName('response')->length;
        // echo "Bil:".$bil;
        $i = 0;
        // $bil = 5;
        while ($i < $bil) {
            $bankCode = $doc->getElementsByTagName('bankCode')->item($i)->nodeValue;
            $bankToken = $doc->getElementsByTagName('bankToken')->item($i)->nodeValue;
            $bankName = $doc->getElementsByTagName('bankName')->item($i)->nodeValue;
            $bankStatus = $doc->getElementsByTagName('bankStatus')->item($i)->nodeValue;

            $bank[] = array(
                'bankCode' => $bankCode,
                'bankToken' => $bankToken,
                'bankName' => $bankName,
                'bankStatus' => $bankStatus
            );
            $i++;
        }

        $dataObj->bankList = $bank;
        return response()->json($dataObj);
    }

    public function semaksaman(Request $req) //check balik
    {
        $userObj = new Stdclass();
        $nokp = $req->nokp;

        // Penduduk Tetap Malaysia
        if ($req->kategori == 0) {$kategori = 0;}
        // Orang Awam Malaysia
        else if ($req->kategori == 1) {$kategori = 1;}
        // Anggota Polis
        else if ($req->kategori == 2) {$kategori = 2;}
        // Anggota Tentera
        else if ($req->kategori == 3) {$kategori = 3;}
        // Syarikat/Pertubuhan
        else if ($req->kategori == 4) {$kategori = 4;}
        // Syarikat/Pertubuhan
        else if ($req->kategori == 5) {$kategori = 5;}
        // Bukan Warganegara Malaysia
        else if ($req->kategori == 6) {$kategori = 9;}

        $nokenderaan = $req->nokenderaan;
        $nokp2 = $nokp;
        $ver = $req->versi;
        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/enf_summon_inq";

        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:enf="http://www.gov.jpj.org/enf_summon_inq/">
                            <soapenv:Header/>
                                <soapenv:Body>
                                <enf:browseSummonByIdno>
                                    <!--Optional:-->
                                    <header>
                                        <module>?</module>
                                        <channel>?</channel>
                                        <agency>?</agency>
                                        <branch>?</branch>
                                        <pcid>?</pcid>
                                        <userId>?</userId>
                                        <transCode>?</transCode>
                                        <lang>my</lang>
                                    </header>
                                    <!--Optional:-->
                                    <id>' . $nokp . '</id>
                                    <!--Optional:-->
                                    <idCat>' . $kategori . '</idCat>
                                </enf:browseSummonByIdno>
                                </soapenv:Body>
                            </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/enf_summon_inq/",
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

        $doc = new \DOMDocument();
        $doc->loadXML($response);

        $bil = $doc->getElementsByTagName('summon')->length;
        $i = 0;
        // $name = $doc->getElementsByTagName('name')->item(0)->nodeValue;
        $respSta = $doc->getElementsByTagName('respSta')->item($i)->nodeValue;
        $respMsg = $doc->getElementsByTagName('respMsg')->item($i)->nodeValue;

        $userObj->noic = $nokp;
        $userObj->status = $respSta;
        $userObj->status_message = $respMsg;
        if ($respSta != 01) {
            while ($i < $bil) {

                $noticeId = $doc->getElementsByTagName('noticeId')->item($i)->nodeValue;
                $amountPaid = $doc->getElementsByTagName('amountPaid')->item($i)->nodeValue;
                $blacklistDate = $doc->getElementsByTagName('blacklistDate')->item($i)->nodeValue;
                $caseId = $doc->getElementsByTagName('caseId')->item($i)->nodeValue;
                $categoryInd = $doc->getElementsByTagName('categoryInd')->item($i)->nodeValue;
                $compoundOfficer = $doc->getElementsByTagName('compoundOfficer')->item($i)->nodeValue;
                $courtCode = $doc->getElementsByTagName('courtCode')->item($i)->nodeValue;
                $courtId = $doc->getElementsByTagName('courtId')->item($i)->nodeValue;
                $createBranch = $doc->getElementsByTagName('createBranch')->item($i)->nodeValue;
                $createDate = $doc->getElementsByTagName('createDate')->item($i)->nodeValue;
                $createUser = $doc->getElementsByTagName('createUser')->item($i)->nodeValue;
                $effectiveDate = $doc->getElementsByTagName('effectiveDate')->item($i)->nodeValue;
                $kejaraInd = $doc->getElementsByTagName('kejaraInd')->item($i)->nodeValue;
                $lastPaymentDate = $doc->getElementsByTagName('lastPaymentDate')->item($i)->nodeValue;
                $noticeDate = $doc->getElementsByTagName('noticeDate')->item($i)->nodeValue;
                $noticeType = $doc->getElementsByTagName('noticeType')->item($i)->nodeValue;
                $offAmount = $doc->getElementsByTagName('offAmount')->item($i)->nodeValue;
                $offCategory = $doc->getElementsByTagName('offCategory')->item($i)->nodeValue;
                $offSection = $doc->getElementsByTagName('offSection')->item($i)->nodeValue;
                $offStatus = $doc->getElementsByTagName('offStatus')->item($i)->nodeValue;
                $offType = $doc->getElementsByTagName('offType')->item($i)->nodeValue;
                $offType = strstr($offType, '- ');
                $offType = substr($offType, 2);
                // dd($offType);
                $offenceCtr = $doc->getElementsByTagName('offenceCtr')->item($i)->nodeValue;
                $refNo = $doc->getElementsByTagName('refNo')->item($i)->nodeValue;
                $settleDate = $doc->getElementsByTagName('settleDate')->item($i)->nodeValue;
                $status = $doc->getElementsByTagName('status')->item($i)->nodeValue;
                $sysInd = $doc->getElementsByTagName('sysInd')->item($i)->nodeValue;
                $trialDate = $doc->getElementsByTagName('trialDate')->item($i)->nodeValue;
                $trialTime = $doc->getElementsByTagName('trialTime')->item($i)->nodeValue;
                $updateBranch = $doc->getElementsByTagName('updateBranch')->item($i)->nodeValue;
                $updateDate = $doc->getElementsByTagName('updateDate')->item($i)->nodeValue;
                $updateUser = $doc->getElementsByTagName('updateUser')->item($i)->nodeValue;
                $vehicleId = $doc->getElementsByTagName('vehicleId')->item($i)->nodeValue;
                $year = $doc->getElementsByTagName('year')->item($i)->nodeValue;


                $k[] = array(
                    // "name"=>$nama,
                    // "regno"=>$regno,
                    "notisId" => $noticeId,
                    "amountPaid" => $amountPaid,
                    "blacklistDate" => $blacklistDate,
                    "categoryInd" => $categoryInd,
                    "compoundOfficer" => $compoundOfficer,
                    "courtCode" => $courtCode,
                    "courtId" => $courtId,
                    "createBranch" => $createBranch,
                    "createDate" => $createDate,
                    "createUser" => $createUser,
                    "effectiveDate" => $effectiveDate,
                    "kejaraInd" => $kejaraInd,
                    "lastPaymentDate" => $lastPaymentDate,
                    "noticeDate" => $noticeDate,
                    "noticeType" => $noticeType,
                    "offAmount" => $offAmount,
                    "offCategory" => $offCategory,
                    "offSection" => $offSection,
                    "offStatus" => $offStatus,
                    "offType" => $offType,
                    "offenceCtr" => $offenceCtr,
                    "refNo" => $refNo,
                    "settleDate" => $settleDate,
                    "status" => $status,
                    "sysInd" => $sysInd,
                    "trialDate" => $trialDate,
                    "trialTime" => $trialTime,
                    "updateBranch" => $updateBranch,
                    "updateDate" => $updateDate,
                    "updateUser" => $updateUser,
                    "vehicleId" => $vehicleId,
                    "year" => $year,
                );
                $i++;
                $doc1 = "";
                $userObj->saman = $k;
            }
        }

        return response()->json($userObj);
    }

    public function pendaftaran(Request $req)
    {

        $nama = $req->nama;
        $alamat = $req->alamat;
        $nokp = $req->nokp;
        $emel = $req->emel;
        $katalaluan = $req->katalaluan;
        $telefon = $req->telefon;
        // Penduduk Tetap Malaysia
        if ($req->kategori == 0) {$kategori = 0;}
        // Orang Awam Malaysia
        else if ($req->kategori == 1) {$kategori = 1;}
        // Anggota Polis
        else if ($req->kategori == 2) {$kategori = 2;}
        // Anggota Tentera
        else if ($req->kategori == 3) {$kategori = 3;}
        // Syarikat/Pertubuhan
        else if ($req->kategori == 4) {$kategori = 4;}
        // Syarikat/Pertubuhan
        else if ($req->kategori == 5) {$kategori = 5;}
        // Bukan Warganegara Malaysia
        else if ($req->kategori == 6) {$kategori = 9;}

        $data = DB::table('pengguna')->where('nokp', $nokp)->first();

        if (count($data) > 0) {
            $msg = "Pendaftaran Gagal. No Kad Pengenalan telah wujud.";
        } else {
            $result = $this->appsModel->pendaftaran($nama, $alamat, $nokp, $emel, $katalaluan, $telefon, $kategori);

            $katalaluan1 = Hash::make($katalaluan);
            $sql = "insert into pengguna (nama,nokp,emel,katalaluan,telefon,kategori,katalaluan_text) values ('$nama','$nokp','$emel','$katalaluan1','$telefon','$kategori','$katalaluan')";

            $sql = "insert into users (nama,nokp,emel,katalaluan,telefon,kategori) values ('$nama','$nokp','$emel','$katalaluan1','$telefon','$kategori')";


            if ($result) {
                $msg = "Pendaftaran Berjaya 1";
            } else {
                $msg = "Pendaftaran Gagal 1";
            }
        }

        // $msg = "Pendataran ditutup sementara. Modul Pendaftaran dalam proses kemaskini.";
        $Obj = new stdClass;
        $Obj->msg = $msg;
        return response()->json($Obj);
    }

    public function semakan_tarikh_luput_lesen_kenderaan_motor(Request $request)
    {
        $nokp = $request->nokp;
        $noplate = $request->nokenderaan;

        if ($request->kategori == 0) {$kategori = 0;}
        // Orang Awam Malaysia
        else if ($request->kategori == 1) {$kategori = 1;}
        // Anggota Polis
        else if ($request->kategori == 2) {$kategori = 2;}
        // Anggota Tentera
        else if ($request->kategori == 3) {$kategori = 3;}
        // Syarikat/Pertubuhan
        else if ($request->kategori == 4) {$kategori = 4;}
        // Syarikat/Pertubuhan
        else if ($request->kategori == 5) {$kategori = 5;}
        // Bukan Warganegara Malaysia
        else if ($request->kategori == 6) {$kategori = 9;}

        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/lic_reg_drivingpermit_inq";

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:lic="http://www.gov.jpj.org/lic_reg_drivingpermit_inq/">
                                <soapenv:Header/>
                                <soapenv:Body>
                                <lic:vehicleLicInfoByvehRegno>
                                    <!--Optional:-->
                                    <reqInfo>
                                        <icno>' . $nokp . '</icno>
                                        <vehicleRegno>' . strtoupper($noplate) . '</vehicleRegno>
                                        <category>' . $kategori . '</category>
                                    </reqInfo>
                                </lic:vehicleLicInfoByvehRegno>
                                </soapenv:Body>
                            </soapenv:Envelope>';


        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/lic_reg_drivingpermit_inq/",
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

        $doc = new \DOMDocument();

        $doc->loadXML($response);
        // dd($doc);

        try {
            $nama = $doc->getElementsByTagName('name')->item(0)->nodeValue;
            $nokp = $doc->getElementsByTagName('icno')->item(0)->nodeValue;
            $kategori = $doc->getElementsByTagName('category')->item(0)->nodeValue;
            $bil = $doc->getElementsByTagName('vehLicInsurance')->length;
            $i = 0;


            $i = 0;
            while ($i < $bil) {
                $insurance = $doc->getElementsByTagName('vehLicInsurance')->item($i)->nodeValue;
                $dateOfCom = $doc->getElementsByTagName('dateOfCommencement')->item($i)->nodeValue;
                $expired = $doc->getElementsByTagName('expiryDate')->item($i)->nodeValue;
                $k[] = array("vehicle_insurance" => $insurance, "date_of_commencement" => $dateOfCom, "expired" => $expired);
                $i++;
            }

            $status_code = $doc->getElementsByTagName('statusCode')->item(0)->nodeValue;
            $status_msg = $doc->getElementsByTagName('statusMsg')->item(0)->nodeValue;
            $status[] = array("status_code" => $status_code, "status_message" => $status_msg);

            // $userObj->lesen = $k;
            // echo json_encode($userObj);
            return response()->json([
                'status' => $status_code,
                'user' => $nama,
                'nokp' => $nokp,
                'kategori' => $kategori,
                'bil' => $bil,
                'vehicle_info' => $k,
                'status' => $status,
            ]);
        } catch (\Throwable $th) {
            // $status[] = array("status_code" => 404, "status_message" => 'Invalid icno or category');
            // return response()->json($status);
            $status_code = $doc->getElementsByTagName('statusCode')->item(0)->nodeValue;
            $status_msg = $doc->getElementsByTagName('statusMsg')->item(0)->nodeValue;
            return response()->json([
                'status_code' => $status_code,
                'status_msg' => $status_msg
            ]);
        }
    }

    public function semakan_nombor_pendaftaran(Request $request)
    {
        $areaCode = strtoupper($request->areaCode);
        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/vel_inq_current_regn_number";

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:vel="http://www.gov.jpj.org/vel_inq_current_regn_number/">
                                <soapenv:Header/>
                                <soapenv:Body>
                                <vel:findLatestRegnNumberByAreaCode>
                                    <!--Optional:-->
                                    <areaCode>' . $areaCode . '</areaCode>
                                </vel:findLatestRegnNumberByAreaCode>
                                </soapenv:Body>
                                </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/vel_inq_current_regn_number/",
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

        curl_close($ch);

        $doc = new \DOMDocument();

        $doc->loadXML($response);
        // dd($doc);
        $areaName = $doc->getElementsByTagName('areaName')->item(0)->nodeValue;
        $regnNo = $doc->getElementsByTagName('regnNo')->item(0)->nodeValue;

        return response()->json([
            'status' => 200,
            'areaName' => $areaName,
            'regnNo' => $regnNo
        ]);
    }

    public function semakan_status_permohonan_penubuhan_institut_memandu(Request $request)
    {
        $applicationNo = $request->applicationNo;

        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/lic_inquiry_application_permit";

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:lic="http://www.example.org/lic_inquiry_application_permit/">
                                <soapenv:Header/>
                                <soapenv:Body>
                                    <lic:inquiryPermitApplicationStatus>
                                        <!--Optional:-->
                                        <applicationNo>' . $applicationNo . '</applicationNo>
                                    </lic:inquiryPermitApplicationStatus>
                                </soapenv:Body>
                            </soapenv:Envelope>';


        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/lic_inquiry_application_permit/",
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

        $doc = new \DOMDocument();

        $doc->loadXML($response);

        $statusCode = $doc->getElementsByTagName('statusCode')->item(0)->nodeValue;
        $statusMsg = $doc->getElementsByTagName('statusMsg')->item(0)->nodeValue;
        $status = array("status_code" => $statusCode, "status_message" => $statusMsg);


        try {
            $application_id = $doc->getElementsByTagName('licpaApplId')->item(0)->nodeValue;
            $application_type = $doc->getElementsByTagName('licpaApplType')->item(0)->nodeValue;
            $current_stage = $doc->getElementsByTagName('licpaCurrentStage')->item(0)->nodeValue;
            $current_status = $doc->getElementsByTagName('licpaCurrentTxnStatus')->item(0)->nodeValue;
            $name = $doc->getElementsByTagName('licpaName')->item(0)->nodeValue;
            $entity_id = $doc->getElementsByTagName('licpaEntityId')->item(0)->nodeValue;

            return response()->json([
                'status' => 200,
                'statusCode' => $statusCode,
                'statusMsg' => $statusMsg,
                'application_id' => $application_id,
                'application_type' => $application_type,
                'current_stage' => $current_stage,
                'current_status' => $current_status,
                'name' => $name,
                'entity_id' => $entity_id,
            ]);
        } catch (\Throwable $th) {
            return response()->json($status);
        }
    }

    public function semakan_tarikh_luput_lesen_memandu(Request $request)
    {
        $nokp = $request->nokp;

        if ($request->kategori == 0) {$kategori = 0;}
        // Orang Awam Malaysia
        else if ($request->kategori == 1) {$kategori = 1;}
        // Anggota Polis
        else if ($request->kategori == 2) {$kategori = 2;}
        // Anggota Tentera
        else if ($request->kategori == 3) {$kategori = 3;}
        // Syarikat/Pertubuhan
        else if ($request->kategori == 4) {$kategori = 4;}
        // Syarikat/Pertubuhan
        else if ($request->kategori == 5) {$kategori = 5;}
        // Bukan Warganegara Malaysia
        else if ($request->kategori == 6) {$kategori = 9;}

        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/lic_appeal_expired_drivinglicense";

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                     <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:lic="http://www.gov.jpj.org/lic_appeal_expired_drivinglicense/">
                                         <soapenv:Header/>
                                         <soapenv:Body> <lic:findDrivingLicenseExpDate> <icno>' . strtoupper($nokp) . '</icno>
                                         <category>' . $kategori . '</category>
                                         </lic:findDrivingLicenseExpDate>
                                         </soapenv:Body>
                                      </soapenv:Envelope>'; // data from the form, e.g. some ID number

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/lic_appeal_expired_drivinglicense/",
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

        $doc = new \DOMDocument();

        $doc->loadXML($response);
        // dd($doc);

        try {
            $nama = $doc->getElementsByTagName('name')->item(0)->nodeValue;
            $nokp = $doc->getElementsByTagName('icno')->item(0)->nodeValue;
            $kategori = $doc->getElementsByTagName('category')->item(0)->nodeValue;
            $bil = $doc->getElementsByTagName('licType')->length;
            $i = 0;


            $i = 0;
            while ($i < $bil) {
                $jenis_lesen = $doc->getElementsByTagName('licType')->item($i)->nodeValue;
                $expired = $doc->getElementsByTagName('expiryDate')->item($i)->nodeValue;
                $k[] = array("jenis_lesen" => $jenis_lesen, "tempoh_tamat" => $expired);
                $i++;
            }

            return response()->json([
                'status' => 200,
                'user' => $nama,
                'nokp' => $nokp,
                'bil' => $bil,
                'lesen' => $k,
            ]);
        } catch (\Throwable $th) {
            $icno = $doc->getElementsByTagName('icno')->item(0)->nodeValue;
            $cat = $doc->getElementsByTagName('category')->item(0)->nodeValue;
            $statusMsg = $doc->getElementsByTagName('errorMsg')->item(0)->nodeValue;
            $status = array("nokp" => $icno, "kategori" => $cat, "status_message" => $statusMsg);

            return response()->json($status);
        }
    }

    public function semakan_status_senarai_hitam(Request $request)
    {
        $icno = $request->nokp;
        $vehicleRegno = $request->nokenderaan;
        $bltype = strtoupper($request->bltype);
        $blcat = strtoupper($request->blcat);

        if ($bltype == 'VEH') {
            if ($blcat == 'JPJ') {
                $blkListType = '1';
            } elseif ($blcat == 'AGENCY') {
                $blkListType = '3';
            }
        } elseif ($bltype == 'LIC') {
            $blkListType = '2';
        }

        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/enf_jpjblacklist_public";

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:enf="http://www.gov.jpj.org/enf_jpjblacklist_public/">
        <soapenv:Header/>
        <soapenv:Body>
           <enf:checkBlackListStatusInfo>
              <!--Optional:-->
              <icno>' . $icno . '</icno>
              <!--Optional:-->
              <vehicleRegno>' . $vehicleRegno . '</vehicleRegno>
              <!--Optional:-->
              <blkListType>' . $blkListType . '</blkListType>
           </enf:checkBlackListStatusInfo>
        </soapenv:Body>
     </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/enf_jpjblacklist_public/",
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

        $doc = new \DOMDocument();

        $doc->loadXML($response);
        // dd($doc);
        try {
            $vehicleBlackListStatus = $doc->getElementsByTagName('vehicleBlackListStatus')->item(0)->nodeValue;
            $licBlackListStatus = $doc->getElementsByTagName('licBlackListStatus')->item(0)->nodeValue;
            $agencyBlackListStatus = $doc->getElementsByTagName('agencyBlackListStatus')->item(0)->nodeValue;

            if ($agencyBlackListStatus != null && $agencyBlackListStatus == '1') {
                $message = 'Terdapat rekod senarai hitam pada nombor rujukan pemilik ini (Senarai Hitam PDRM).';
            } elseif ($licBlackListStatus != null && $licBlackListStatus == '1') {
                $message = 'Lesen telah disenarai hitam.';
            } elseif ($vehicleBlackListStatus != null && $vehicleBlackListStatus == '1') {
                $message = 'Kenderaan ini telah disenarai hitam.';
            } else {
                $message = 'Tiada rekod senarai hitam.';
            }
        } catch (\Throwable $th) {
            $message = 'Rekod Tidak Dijumpai.';
        }

        return response()->json([
            'status' => 200,
            'icno' => $icno,
            'vehicleRegno' => $vehicleRegno,
            'message' => $message
        ]);
    }

    public function semakan_dimerit(Request $request)
    {
        $icno = $request->nokp;
        if ($request->kategori == 0) {$category = 0;}
        // Orang Awam Malaysia
        else if ($request->kategori == 1) {$category = 1;}
        // Anggota Polis
        else if ($request->kategori == 2) {$category = 2;}
        // Anggota Tentera
        else if ($request->kategori == 3) {$category = 3;}
        // Syarikat/Pertubuhan
        else if ($request->kategori == 4) {$category = 4;}
        // Syarikat/Pertubuhan
        else if ($request->kategori == 5) {$category = 5;}
        // Bukan Warganegara Malaysia
        else if ($request->kategori == 6) {$category = 9;}
        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/enf_inquiry_demerit";

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:enf="http://www.example.org/enf_inquiry_demerit/">
                                <soapenv:Header/>
                                <soapenv:Body>
                                <enf:inquiryDemeritPoint>
                                    <!--Optional:-->
                                    <icNo>' . $icno . '</icNo>
                                    <!--Optional:-->
                                    <category>' . $category . '</category>
                                </enf:inquiryDemeritPoint>
                                </soapenv:Body>
                            </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/enf_inquiry_demerit/",
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

        $doc = new \DOMDocument();

        $doc->loadXML($response);
        // dd($doc);
        try {
            $name = $doc->getElementsByTagName('name')->item(0)->nodeValue;
            $idNo = $doc->getElementsByTagName('idNo')->item(0)->nodeValue;
            $category = $doc->getElementsByTagName('category')->item(0)->nodeValue;
            $kejaraPoint = $doc->getElementsByTagName('kejaraPoint')->item(0)->nodeValue;

            return response()->json([
                'status' => 200,
                'name' => $name,
                'idNo' => $idNo,
                'category' => $category,
                'kejaraPoint' => $kejaraPoint
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'status_message' => "Record not found.",
            ]);
        }
    }

    public function semakan_pertukaran_lesen_memandu_luar_negara(Request $request)
    {
        $icno = $request->icno;
        $category = $request->category;

        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/lic_inq_con_foreign_lic";

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:lic="http://www.gov.jpj.org/lic_inq_con_foreign_lic/">
                                <soapenv:Header/>
                                <soapenv:Body>
                                <lic:findConversionLicInfo>
                                    <!--Optional:-->
                                    <icno>' . strtoupper($icno) . '</icno>
                                    <!--Optional:-->
                                    <category>' . $category . '</category>
                                </lic:findConversionLicInfo>
                                </soapenv:Body>
                            </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/lic_inq_con_foreign_lic/",
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

        $doc = new \DOMDocument();

        $doc->loadXML($response);

        try {
            $icno = $doc->getElementsByTagName('icno')->item(0)->nodeValue;
            $category = $doc->getElementsByTagName('category')->item(0)->nodeValue;
            $name = $doc->getElementsByTagName('name')->item(0)->nodeValue;

            $statusCode = $doc->getElementsByTagName('statusCode')->item(0)->nodeValue;
            $statusMsg = $doc->getElementsByTagName('statusMsg')->item(0)->nodeValue;

            $bil = $doc->getElementsByTagName('licType')->length;
            $i = 0;
            while ($i < $bil) {
                $licType = $doc->getElementsByTagName('licType')->item($i)->nodeValue;
                $licClass = $doc->getElementsByTagName('licClass')->item($i)->nodeValue;
                $applyDate = $doc->getElementsByTagName('applyDate')->item($i)->nodeValue;
                $approveDate = $doc->getElementsByTagName('approveDate')->item($i)->nodeValue;
                $expiryDate = $doc->getElementsByTagName('expiryDate')->item($i)->nodeValue;
                $appStatus = $doc->getElementsByTagName('appStatus')->item($i)->nodeValue;
                $applId = $doc->getElementsByTagName('applId')->item($i)->nodeValue;

                $applInfo[] = array(
                    "licType" => $licType,
                    "licClass" => $licClass,
                    "applyDate" => $applyDate,
                    "approveDate" => $approveDate,
                    "expiryDate" => $expiryDate,
                    "appStatus" => $appStatus,
                    "applId" => $applId,
                );

                $i++;
            }

            return response()->json([
                "icno" => $icno,
                "category" => $category,
                "name" => $name,
                "statusCode" => $statusCode,
                "statusMsg" => $statusMsg,
                "applInfo" => $applInfo,
            ]);
        } catch (\Throwable $th) {
            $statusCode = $doc->getElementsByTagName('statusCode')->item(0)->nodeValue;
            $statusMsg = $doc->getElementsByTagName('statusMsg')->item(0)->nodeValue;
            return response()->json([
                "statusCode" => $statusCode,
                "statusMsg" => $statusMsg,
            ]);
        }
    }

    public function semakan_ujian_memandu(Request $request)
    {
        $icNo = $request->nokp;
        if ($request->kategori == 0) {$category = 0;}
        // Orang Awam Malaysia
        else if ($request->kategori == 1) {$category = 1;}
        // Anggota Polis
        else if ($request->kategori == 2) {$category = 2;}
        // Anggota Tentera
        else if ($request->kategori == 3) {$category = 3;}
        // Syarikat/Pertubuhan
        else if ($request->kategori == 4) {$category = 4;}
        // Syarikat/Pertubuhan
        else if ($request->kategori == 5) {$category = 5;}
        // Bukan Warganegara Malaysia
        else if ($request->kategori == 6) {$category = 9;}

        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/lic_inquiry_testresult";

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:lic="http://www.example.org/lic_inquiry_testresult/">
                                <soapenv:Header/>
                                <soapenv:Body>
                                <lic:inquiryTestResult>
                                    <!--Optional:-->
                                    <icNo>' . $icNo . '</icNo>
                                    <!--Optional:-->
                                    <category>' . $category . '</category>
                                </lic:inquiryTestResult>
                                </soapenv:Body>
                            </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/lic_inquiry_testresult/",
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

        $doc = new \DOMDocument();

        $doc->loadXML($response);
        // $icno = $doc->getElementsByTagName('icno')->item(0)->nodeValue;
        // $category = $doc->getElementsByTagName('category')->item(0)->nodeValue;
        // $name = $doc->getElementsByTagName('name')->item(0)->nodeValue;

        // $bil_theory = $doc->getElementsByTagName('theoryTestResultInfo')->length;
        // $i = 0;
        // while ($i < $bil_theory) {
        //     $testDate = $doc->getElementsByTagName('testDate')->item($i)->nodeValue;
        //     $testType = $doc->getElementsByTagName('testType')->item($i)->nodeValue;
        //     $testVenue = $doc->getElementsByTagName('testVenue')->item($i)->nodeValue;
        //     $testResult = $doc->getElementsByTagName('testResult')->item($i)->nodeValue;
        //     $theoryTestMarks = $doc->getElementsByTagName('theoryTestMarks')->item($i)->nodeValue;
        //     $overAllResult = $doc->getElementsByTagName('overAllResult')->item($i)->nodeValue;
        //     $expiryDate = $doc->getElementsByTagName('expiryDate')->item($i)->nodeValue;
        //     $statusVerification = $doc->getElementsByTagName('statusVerification')->item($i)->nodeValue;
        //     $testCode = $doc->getElementsByTagName('testCode')->item($i)->nodeValue;
        //     $licenseType = $doc->getElementsByTagName('licenseType')->item($i)->nodeValue;
        //     $classType = $doc->getElementsByTagName('classType')->item($i)->nodeValue;

        //     $theory_test[] = array(
        //         "testDate" => $testDate,
        //         "testType" => $testType,
        //         "testVenue" => $testVenue,
        //         "testResult" => $testResult,
        //         "theoryTestMarks" => $theoryTestMarks,
        //         "overAllResult" => $overAllResult,
        //         "expiryDate" => $expiryDate,
        //         "statusVerification" => $statusVerification,
        //         "testCode" => $testCode,
        //         "licenseType" => $licenseType,
        //         "classType" => $classType,
        //     );

        //     $i++;
        // }

        // $bil_prac = $doc->getElementsByTagName('practicalTestResultInfo')->length;
        // $j = 0;
        // while ($j < $bil_prac) {
        //     $testDate = $doc->getElementsByTagName('testDate')->item($j)->nodeValue;
        //     $testType = $doc->getElementsByTagName('testType')->item($j)->nodeValue;
        //     $licenseType = $doc->getElementsByTagName('licenseType')->item($j)->nodeValue;
        //     $licenseClass = $doc->getElementsByTagName('licenseClass')->item($j)->nodeValue;
        //     $usageCode = $doc->getElementsByTagName('usageCode')->item($j)->nodeValue;
        //     $testVenue = $doc->getElementsByTagName('testVenue')->item($j)->nodeValue;
        //     $overAllResult = $doc->getElementsByTagName('overAllResult')->item($j)->nodeValue;
        //     $expiryDate = $doc->getElementsByTagName('expiryDate')->item($j)->nodeValue;
        //     $testCode = $doc->getElementsByTagName('testCode')->item($j)->nodeValue;

        //     $practical_test[] = array(
        //         "testDate" => $testDate,
        //         "testType" => $testType,
        //         "licenseType" => $licenseType,
        //         "licenseClass" => $licenseClass,
        //         "usageCode" => $usageCode,
        //         "testVenue" => $testVenue,
        //         "overAllResult" => $overAllResult,
        //         "expiryDate" => $expiryDate,
        //         "testCode" => $testCode,
        //     );

        //     $j++;
        // }

        // return response()->json([
        //     'status' => 200,
        //     'icno' => $icno,
        //     'category' => $category,
        //     'name' => $name,
        //     'theory_test' => $theory_test,
        //     'practical_test' => $practical_test,
        // ]);

        try {
            $icno = $doc->getElementsByTagName('icno')->item(0)->nodeValue;
            $category = $doc->getElementsByTagName('category')->item(0)->nodeValue;
            $name = $doc->getElementsByTagName('name')->item(0)->nodeValue;

            $bil_theory = $doc->getElementsByTagName('theoryTestResultInfo')->length;
            $i = 0;
            while ($i < $bil_theory) {
                $testDate = $doc->getElementsByTagName('testDate')->item($i)->nodeValue;
                $testType = $doc->getElementsByTagName('testType')->item($i)->nodeValue;
                $testVenue = $doc->getElementsByTagName('testVenue')->item($i)->nodeValue;
                $testResult = $doc->getElementsByTagName('testResult')->item($i)->nodeValue;
                $theoryTestMarks = $doc->getElementsByTagName('theoryTestMarks')->item($i)->nodeValue;
                $overAllResult = $doc->getElementsByTagName('overAllResult')->item($i)->nodeValue;
                $expiryDate = $doc->getElementsByTagName('expiryDate')->item($i)->nodeValue;
                $statusVerification = $doc->getElementsByTagName('statusVerification')->item($i)->nodeValue;
                $testCode = $doc->getElementsByTagName('testCode')->item($i)->nodeValue;
                $licenseType = $doc->getElementsByTagName('licenseType')->item($i)->nodeValue;
                $classType = $doc->getElementsByTagName('classType')->item($i)->nodeValue;

                $theory_test[] = array(
                    "testDate" => $testDate,
                    "testType" => $testType,
                    "testVenue" => $testVenue,
                    "testResult" => $testResult,
                    "theoryTestMarks" => $theoryTestMarks,
                    "overAllResult" => $overAllResult,
                    "expiryDate" => $expiryDate,
                    "statusVerification" => $statusVerification,
                    "testCode" => $testCode,
                    "licenseType" => $licenseType,
                    "classType" => $classType,
                );

                $i++;
            }

            $bil_prac = $doc->getElementsByTagName('practicalTestResultInfo')->length;
            $j = 0;
            while ($j < $bil_prac) {
                $testDate = $doc->getElementsByTagName('testDate')->item($j)->nodeValue;
                $testType = $doc->getElementsByTagName('testType')->item($j)->nodeValue;
                $licenseType = $doc->getElementsByTagName('licenseType')->item($j)->nodeValue;
                $licenseClass = $doc->getElementsByTagName('licenseClass')->item($j)->nodeValue;
                $usageCode = $doc->getElementsByTagName('usageCode')->item($j)->nodeValue;
                $testVenue = $doc->getElementsByTagName('testVenue')->item($j)->nodeValue;
                $overAllResult = $doc->getElementsByTagName('overAllResult')->item($j)->nodeValue;
                $expiryDate = $doc->getElementsByTagName('expiryDate')->item($j)->nodeValue;
                $testCode = $doc->getElementsByTagName('testCode')->item($j)->nodeValue;

                $practical_test[] = array(
                    "testDate" => $testDate,
                    "testType" => $testType,
                    "licenseType" => $licenseType,
                    "licenseClass" => $licenseClass,
                    "usageCode" => $usageCode,
                    "testVenue" => $testVenue,
                    "overAllResult" => $overAllResult,
                    "expiryDate" => $expiryDate,
                    "testCode" => $testCode,
                );

                $j++;
            }

            return response()->json([
                'status' => 200,
                'icno' => $icno,
                'category' => $category,
                'name' => $name,
                'theory_test' => $theory_test,
                'practical_test' => $practical_test,
            ]);
        } catch (\Throwable $th) {

            $statusCode = $doc->getElementsByTagName('statusCode')->item(0)->nodeValue;
            $statusMsg = $doc->getElementsByTagName('statusMsg')->item(0)->nodeValue;
            return response()->json([
                'statusCode' => $statusCode,
                'statusMsg' => $statusMsg,
            ]);
        }
    }

    public function direktori_jpj($negeri)
    {
        $neg = Http::get('http://jpj-portal.prototype.com.my/wp-json/mo/v1/' . $negeri);
        $neg = json_decode($neg->body());

        $caw_neg = [];
        foreach ($neg as $i => $n) {
            try {
                $cawangan = $n->cawangan;
            } catch (\Throwable $th) {
                $cawangan = $n->unitbahagian;
            }

            $item = [
                "nama_cawangan" => $cawangan,
                "alamat_cawangan" => $n->alamat,
                "notelefon_cawangan" => $n->notelefon,
                "nofaks_cawangan" => $n->nofaks,
                "waktuperkhidmatan_cawangan" => $n->waktuperkhidmatan,
                "koordinat_cawangan" => $n->koordinat,
            ];
            array_push($caw_neg, $item);
        }

        $nama_neg = str_replace('_', ' ', $negeri);
        $nama_neg = ucfirst($nama_neg);

        return response()->json([
            'nama_negeri' => $nama_neg,
            'cawangan' => $caw_neg,
        ]);
    }

    public function direktori_jpj2()
    {
        $negeri_list = [
            'johor',
            'kedah',
            'kelantan',
            'melaka',
            'negeri_sembilan',
            'pahang',
            'perak',
            'perlis',
            'pulau_pinang',
            'selangor',
            'terengganu',
            'sabah',
            'sarawak',
            'kuala_lumpur',
            'putrajaya',
            'labuan'
        ];

        $negeri = [];

        foreach ($negeri_list as $key => $nl) {
            $neg = Http::get('http://jpj-portal.prototype.com.my/wp-json/mo/v1/' . $nl);
            $neg = json_decode($neg->body());

            $caw_neg = [];
            foreach ($neg as $i => $n) {
                try {
                    $cawangan = $n->cawangan;
                } catch (\Throwable $th) {
                    $cawangan = $n->unitbahagian;
                }

                $item = [
                    "nama_cawangan" => $cawangan,
                    "alamat_cawangan" => $n->alamat,
                    "notelefon_cawangan" => $n->notelefon,
                    "nofaks_cawangan" => $n->nofaks,
                    "waktuperkhidmatan_cawangan" => $n->waktuperkhidmatan,
                    "koordinat_cawangan" => $n->koordinat,
                ];
                array_push($caw_neg, $item);
            }

            $nama_neg = str_replace('_', ' ', $nl);
            $nama_neg = ucfirst($nama_neg);
            $neg_big = [
                'nama_negeri' => $nama_neg,
                'cawangan' => $caw_neg,
            ];

            array_push($negeri, $neg_big);
            // dd($negeri);
        }

        return response()->json($negeri);
    }

    // public function store_noti(Request $request)
    // {
    //     $peti_masuk = new Notification($request->all());
    //     $peti_masuk->save();

    //     return response()->json($peti_masuk);
    // }

    // public function upd_noti(Request $request)
    // {
    //     $peti_masuk = Notification::where('id', $request->id)->first();
    //     $peti_masuk->read = $request->read;
    //     $peti_masuk->send = $request->send;
    //     $peti_masuk->status = $request->status;
    //     $peti_masuk->save();
    //     return response()->json($peti_masuk);
    // }

    public function getPetiMasuk(Request $req)
    {
        $nokp = $req->nokp;
        // $id = $req->id;

        $data = Notification::where('penerima', $nokp)->orderBy('id', 'desc')->get();

        if (!$data->isEmpty()) {
            foreach ($data as $val) :
                $id = $val['id'];
                $tajuk = $val['tajuk'];
                $perkara = $val['perkara'];
                $jenis_noti = $val['jenis_noti'];
                $create_date = $val['create_date'];
                $rujukan = $val['rujukan'];
                $read_status = $val['read_status'];
                $status = $val['status'];

                if ($jenis_noti == "1") {
                    $status_aduan = $val['status_aduan'];
                    if ($status_aduan == "2" || $status_aduan == "4") {
                        $m[] = array(
                            "id" => $id,
                            "tajuk" => $tajuk,
                            "perkara" => $perkara,
                            "jenis_noti" => $jenis_noti,
                            "create_date" => $create_date,
                            "read_status" => $read_status,
                            "status" => $status
                        );
                    }
                } else {
                    $m[] = array(
                        "id" => $id,
                        "tajuk" => $tajuk,
                        "perkara" => $perkara,
                        "jenis_noti" => $jenis_noti,
                        "create_date" => $create_date,
                        "read_status" => $read_status,
                        "status" => $status
                    );
                }

            endforeach;
        } else {
            $m = [];
        }
        $userObj = new stdClass;
        $userObj->petiMasuk = $m;
        return response()->json($userObj);
    }

    public function get_unread_noti(Request $req)
    {
        $nokp = $req->nokp;

        $data = Notification::where('penerima', $nokp)->where('read_status', 0)->orderBy('id', 'desc')->get();
        foreach ($data as $val) :
            $id = $val['id'];
            $tajuk = $val['tajuk'];
            $perkara = $val['perkara'];
            $jenis_noti = $val['jenis_noti'];
            $create_date = $val['create_date'];
            $rujukan = $val['rujukan'];

            if ($jenis_noti == "1") {
                $status_aduan = $val['status_aduan'];
                if ($status_aduan == "2" || $status_aduan == "4") {
                    $m[] = array(
                        "id" => $id,
                        "tajuk" => $tajuk,
                        "perkara" => $perkara,
                        "jenis_noti" => $jenis_noti,
                        "create_date" => $create_date
                    );
                }
            } else {
                $m[] = array(
                    "id" => $id,
                    "tajuk" => $tajuk,
                    "perkara" => $perkara,
                    "jenis_noti" => $jenis_noti,
                    "create_date" => $create_date
                );
            }

        endforeach;
        $userObj = new stdClass;
        $userObj->petiMasuk = $m;
        return response()->json($userObj);

        // jap
        $peti_masuk = new PetiMasuk($request->all());
        $peti_masuk->save();

        return response()->json($peti_masuk);
    }

    public function update_status_noti(Request $request)
    {
        $nokp = $request->nokp;
        $id_noti = $request->id_noti;
        $status = $request->status;

        $noti = Notification::where('id', $id_noti)->first();
        $noti->status = $status;
	if($status == 'read'){
		$noti->read_status = 1;
	}

        try {
            $noti->save();
            return response()->json([
                'status' => 'saved',
                'notification' => $noti
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'unsaved',
                'notification' => $noti
            ]);
        }
    }

    public function faq()
    {
        $pdf = '/usr/share/nginx/html/jpj-api/public/pdf/faq.pdf';
        return response()->file($pdf);
    }

    public function share()
    {
        $ref = Ref::where('jenis', '6')->first();
        return response()->json([
            'text_ms' => $ref->keterangan,
            'text_en' => $ref->keterangan,
            'link' => $ref->keterangan_apps
        ]);
    }
}
