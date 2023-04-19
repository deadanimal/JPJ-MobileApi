<?php

namespace App\Http\Services;

class LkmService
{
    public function getLkmTempohPembaharuan()
    {
        $result = array(
            [
                'display_text' => "6 bulan",
                'value' => 6
            ],
            [
                'display_text' => "12 bulan",
                'value' => 12
            ],
        );

        return $result;
    }

    public function getLkmMaklumatKenderaan($request)
    {

        $module = $request->module;
        $channel = $request->channel;
        $agency = $request->agency;
        $branch = $request->branch;
        $pcid = $request->pcid;
        $userId = $request->userId;
        $transCode = $request->transCode;
        $currDate = $request->currDate;
        $currTime = $request->currTime;
        $deviceId = $request->deviceId;
        $regnNo = $request->regnNo;
        $idNo = $request->idNo;
        $idCategory = $request->idCategory;

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:vel="http://www.gov.jpj.org/vel_lkm_renewal/">
        <soapenv:Header/>
        <soapenv:Body>
           <vel:InquiryLkmRenewal>
              <!--Optional:-->
              <header>
                 <module>' . $module . '</module>
                 <channel>' . $channel . '</channel>
                 <agency>' . $agency . 'v</agency>
                 <branch>' . $branch . '</branch>
                 <pcid>' . $pcid . '</pcid>
                 <userId>' . $userId . '</userId>
                 <transCode>' . $transCode . '</transCode>
                 <currDate>' . $currDate . '</currDate>
                 <currTime>' . $currTime . '</currTime>
                 <deviceId>' . $deviceId . '</deviceId>
              </header>
              <!--Optional:-->
              <regnNo>' . $regnNo . '</regnNo>
              <!--Optional:-->
              <idNo>' . $idNo . '</idNo>
              <!--Optional:-->
              <idCategory>' . $idCategory . '</idCategory>
           </vel:InquiryLkmRenewal>
        </soapenv:Body>
     </soapenv:Envelope>';


        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/vel_lkm_renewal/",
            "Content-length: " . strlen($xml_post_string),
        );

        $url = "http://10.180.5.38:9081/jpj-revamp-svc-pvr-ws/vel_lkm_renewal";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


        $response = curl_exec($ch);
        curl_close($ch);

        $doc = new \DOMDocument();


        $doc->loadXML($response);

        $soapUrl2 = "http://10.180.5.38:9081/jpj-revamp-svc-pvr-ws/vel_lkm_renewal";

        $xml_post_string2 = '<?xml version="1.0" encoding="utf-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:vel="http://www.gov.jpj.org/vel_lkm_renewal/">
        <soapenv:Header/>
        <soapenv:Body>
           <vel:InquiryLkmRenewalAmt>
              <!--Optional:-->
              <header>
                 <module>' . $module . '</module>
                 <channel>' . $channel . '</channel>
                 <agency>' . $agency . '</agency>
                 <branch>' . $branch . '</branch>
                 <pcid>' . $pcid . '</pcid>
                 <userId>' . $userId . '</userId>
                 <transCode>' . $transCode . '</transCode>
                 <currDate>' . $currDate . '</currDate>
                 <currTime>' . $currTime . '</currTime>
                 <deviceId>' . $deviceId . '</deviceId>
              </header>
              <!--Optional:-->
              <regnNo>' . $regnNo . '</regnNo>
              <!--Optional:-->
              <idNo>' . $idNo . '</idNo>
              <!--Optional:-->
              <idCategory>' . $idCategory . '</idCategory>
              <lkmDuration>6</lkmDuration>
           </vel:InquiryLkmRenewalAmt>
        </soapenv:Body>
     </soapenv:Envelope>';


        $headers2 = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/vel_lkm_renewal/",
            "Content-length: " . strlen($xml_post_string2),
        );

        $url2 = $soapUrl2;


        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch2, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch2, CURLOPT_POST, true);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $xml_post_string2);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);

        $response2 = curl_exec($ch2);
        curl_close($ch2);

        $doc2 = new \DOMDocument();

        $doc2->loadXML($response2);

        try {
            $result = array(
                "status" => $doc->getElementsByTagName('respSta')->item(0)->nodeValue,
                "message" => $doc->getElementsByTagName('respMsg')->item(0)->nodeValue,
                "nokp" => $doc->getElementsByTagName('ownerId')->item(0)->nodeValue,
                "nama" =>  $doc->getElementsByTagName('ownerName')->item(0)->nodeValue,
                "noKenderaan" =>  $doc->getElementsByTagName('regnNo')->item(0)->nodeValue,
                "noCasis" =>  $doc->getElementsByTagName('chassisNo')->item(0)->nodeValue,
                "buatan" => $doc->getElementsByTagName('usage')->item(0)->nodeValue,
                "kuasaEnjin" => $doc->getElementsByTagName('engineDisp')->item(0)->nodeValue,
                "kegunaan" => $doc->getElementsByTagName('make')->item(0)->nodeValue,
                "modelKenderaan" => $doc->getElementsByTagName('model')->item(0)->nodeValue,
                "bodyType" => $doc->getElementsByTagName('bodyType')->item(0)->nodeValue,
                "enjinNo" => $doc->getElementsByTagName('engineNo')->item(0)->nodeValue,
                "jenisBahanBakar" => $doc->getElementsByTagName('fuelType')->item(0)->nodeValue,
                "noSiriVoc" => $doc->getElementsByTagName('vocSerialNo')->item(0)->nodeValue,
                "tarikhKuatKuasaLKM" => $doc->getElementsByTagName('lkmEffectiveDate')->item(0)->nodeValue,
                "tarikhLuputLKM" => $doc->getElementsByTagName('lkmExpiryDate')->item(0)->nodeValue,
                "pacuanEmpatRoda" => $doc->getElementsByTagName('fourWheelDrive')->item(0)->nodeValue,
                "kawasanIsytihar" => $doc2->getElementsByTagName('regArea')->item(0)->nodeValue,
            );
            return $result;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getLkmAmaunBayaran($request)
    {
        $module = $request->module;
        $channel = $request->channel;
        $agency = $request->agency;
        $branch = $request->branch;
        $pcid = $request->pcid;
        $userId = $request->userId;
        $transCode = $request->transCode;
        $currDate = $request->currDate;
        $currTime = $request->currTime;
        $deviceId = $request->deviceId;
        $regnNo = $request->regnNo;
        $idNo = $request->idNo;
        $idCategory = $request->idCategory;
        $lkmDuration = $request->lkmDuration;

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:vel="http://www.gov.jpj.org/vel_lkm_renewal/">
        <soapenv:Header/>
        <soapenv:Body>
           <vel:InquiryLkmRenewalAmt>
              <!--Optional:-->
              <header>
                 <module>' . $module . '</module>
                 <channel>' . $channel . '</channel>
                 <agency>' . $agency . '</agency>
                 <branch>' . $branch . '</branch>
                 <pcid>' . $pcid . '</pcid>
                 <userId>' . $userId . '</userId>
                 <transCode>' . $transCode . '</transCode>
                 <currDate>' . $currDate . '</currDate>
                 <currTime>' . $currTime . '</currTime>
                 <deviceId>' . $deviceId . '</deviceId>
              </header>
              <!--Optional:-->
              <regnNo>' . $regnNo . '</regnNo>
              <!--Optional:-->
              <idNo>' . $idNo . '</idNo>
              <!--Optional:-->
              <idCategory>' . $idCategory . '</idCategory>
              <lkmDuration>' . $lkmDuration . '</lkmDuration>
           </vel:InquiryLkmRenewalAmt>
        </soapenv:Body>
     </soapenv:Envelope>';


        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/vel_lkm_renewal/",
            "Content-length: " . strlen($xml_post_string),
        );

        $url = "http://10.180.5.38:9081/jpj-revamp-svc-pvr-ws/vel_lkm_renewal";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


        $response = curl_exec($ch);
        curl_close($ch);

        $doc = new \DOMDocument();


        $doc->loadXML($response);

        try {
            $result = array(
                "status" => $doc->getElementsByTagName('respSta')->item(0)->nodeValue,
                "message" => $doc->getElementsByTagName('respMsg')->item(0)->nodeValue,
                "tarikhMulaBaharu" => $doc->getElementsByTagName('lkmEffectiveDate')->item(0)->nodeValue,
                "tarikhAkhirBaharu" =>  $doc->getElementsByTagName('lkmExpiryDate')->item(0)->nodeValue,
                "jumlahAmaun" =>  $doc->getElementsByTagName('paymentAmt')->item(0)->nodeValue,
            );
            return $result;
        } catch (\Throwable $th) {
            return false;
        }

        return $result;
    }

    public function getModBayaran()
    {
        $result = array(
            [
                'display_text' => "Kad Kredit/Kad Debit",
                'value' => 1
            ],
        );

        return $result;
    }

    public function getJenisKad()
    {
        $result = array(
            [
                'display_text' => "Visa/Mastercard",
                'value' => 1
            ],
        );

        return $result;
    }
}
