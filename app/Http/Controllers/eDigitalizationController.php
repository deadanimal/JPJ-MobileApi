<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use stdClass;
use Carbon\Carbon;
use DateTime;

class eDigitalizationController extends Controller
{

    public function semakeLMM(Request $request)
    {
        //return 'a';
        $nokp = $request->nokp;
       // $nokp = '700729075064';
       //  $nokp = '710615045202';
        //  $nokp = '780813015550';

     
        $today = Carbon::now()->format('d-m-Y');
      
   

       // $nokp = '850505115005';
        $kategori = $request->kategori;

        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/elmm_ws";

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                     <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:elmm="http://www.gov.jpj.org/elmm_ws/">
                           <soapenv:Header/>
                           <soapenv:Body>
                              <elmm:inquiryDetail>
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
                                 <ownerId>' . $nokp . '</ownerId>
                                 <!--Optional:-->
                                 <ownerCat>' . $kategori . '</ownerCat>
                              </elmm:inquiryDetail>
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
         //dd($doc);       


       $soapUrl2 = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/elkm_Inquiry";

              $xml_post_string2 = '<?xml version="1.0" encoding="utf-8"?>
                                      <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:elkm="http://gateway.jpj.gov.my/elkm_Inquiry/">
                                       <soapenv:Header/>
                                       <soapenv:Body>
                                          <elkm:inquiryListVelRequest>
                                             <ownerId>' . $nokp . '</ownerId>
                                             <ownerCategory>' . $kategori . '</ownerCategory>
                                          </elkm:inquiryListVelRequest>
                                       </soapenv:Body>
                                    </soapenv:Envelope>'; // data from the form, e.g. some ID number

                                      
        $headers2 = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/lic_appeal_expired_drivinglicense/",
            "Content-length: " . strlen($xml_post_string2),
        ); //SOAPAction: your op URL

        $url2 = $soapUrl2;

        // PHP cURL  for https connection with auth
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch2, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch2, CURLOPT_POST, true);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $xml_post_string2); // the SOAP request
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);

        // converting
        $response2 = curl_exec($ch2);
        // return response()->json($response);
        curl_close($ch2);

        $doc2 = new \DOMDocument();

        $doc2->loadXML($response2);

      
        $soapUrl2 = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/lic_appeal_expired_drivinglicense";

        $xml_post_string3 = '<?xml version="1.0" encoding="utf-8"?>
                                     <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:lic="http://www.gov.jpj.org/lic_appeal_expired_drivinglicense/">
                                         <soapenv:Header/>
                                         <soapenv:Body> <lic:findDrivingLicenseExpDate> <icno>' . strtoupper($nokp) . '</icno>
                                         <category>' . $kategori . '</category>
                                         </lic:findDrivingLicenseExpDate>
                                         </soapenv:Body>
                                      </soapenv:Envelope>'; // data from the form, e.g. some ID number

        $headers3 = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/lic_appeal_expired_drivinglicense/",
            "Content-length: " . strlen($xml_post_string3),
        ); //SOAPAction: your op URL

        $url3 = $soapUrl2;

        // PHP cURL  for https connection with auth
        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch3, CURLOPT_URL, $url3);
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch3, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch3, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch3, CURLOPT_POST, true);
        curl_setopt($ch3, CURLOPT_POSTFIELDS, $xml_post_string3); // the SOAP request
        curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers3);

        // converting
        $response3 = curl_exec($ch3);
        // return response()->json($response);
        curl_close($ch3);

        $doc3 = new \DOMDocument();

        $doc3->loadXML($response3);
        // dd($doc);


        try {
            $status = $doc->getElementsByTagName('respSta')->item(0)->nodeValue;
            $message = $doc->getElementsByTagName('respMsg')->item(0)->nodeValue;
            $bil = $doc2->getElementsByTagName('vehicleMSLList')->length;
            $bil2 = $doc2->getElementsByTagName('vehicleList')->length;
            
            $count = (int)$bil+(int)$bil2;

             if($count>0)
            {
              $i = 0;
                  while ($i < $count) {
                      $nokenderaan = $doc2->getElementsByTagName('regNo')->item($i)->nodeValue;
                      $bodyType = $doc2->getElementsByTagName('bodyType')->item($i)->nodeValue;
                      $usageCode = $doc2->getElementsByTagName('usageCode')->item($i)->nodeValue;
                    if($usageCode=='AA')
                    {
                        $k[] = array("nokenderaan" => $nokenderaan,"jnsBody" => $bodyType,"kodKegunaan" => $usageCode);
                        $i++;

                    }elseif($usageCode=='AB')
                    {
                        $k[] = array("nokenderaan" => $nokenderaan,"jnsBody" => $bodyType,"kodKegunaan" => $usageCode);
                        $i++;

                    } elseif($usageCode=='AD')
                    {
                        $k[] = array("nokenderaan" => $nokenderaan,"jnsBody" => $bodyType,"kodKegunaan" => $usageCode);
                        $i++;

                    }/*elseif($usageCode=='AH')
                    {
                        $k[] = array("nokenderaan" => $nokenderaan,"jnsBody" => $bodyType,"kodKegunaan" => $usageCode);
                        $i++;

                    }*/elseif($usageCode=='IA')
                    {  
                        if($bodyType=='KOC')
                        {  $usageCode='AA';
                         }
                        elseif($bodyType=='MSL')
                        { $usageCode='AA';

                        }elseif($bodyType=='MSB')
                        { $usageCode='AA';

                        }elseif($bodyType=='TWR')
                        { $usageCode='AA';

                        }else{
                          $usageCode= $usageCode;
                        }
                            

                        $k[] = array("nokenderaan" => $nokenderaan,"jnsBody" => $bodyType,"kodKegunaan" => $usageCode);
                        $i++;

                    }else{

                        $i++;

                    }
                       
                  }
            }
            else
            {
                   $k =array();
            }

            


            if($status == 'GLB000000I')
            {
                $nationality = $doc->getElementsByTagName('ownerNationality')->item(0)->nodeValue;
                $refNo = $doc->getElementsByTagName('ownerRefNo')->item(0)->nodeValue;
                $nokp = $doc->getElementsByTagName('ownerICNo')->item(0)->nodeValue;
                $nama = $doc->getElementsByTagName('ownerName')->item(0)->nodeValue;
                
                $addres1 = $doc->getElementsByTagName('ownerAddress1')->item(0)->nodeValue;
                $addres2 = $doc->getElementsByTagName('ownerAddress2')->item(0)->nodeValue;
                $addres3 = $doc->getElementsByTagName('ownerAddress3')->item(0)->nodeValue;
                $postcode = $doc->getElementsByTagName('ownerPostcode')->item(0)->nodeValue;
                $city = $doc->getElementsByTagName('ownerCity')->item(0)->nodeValue;
                $state = $doc->getElementsByTagName('ownerState')->item(0)->nodeValue;
                
                $country = $doc->getElementsByTagName('ownerCountry')->item(0)->nodeValue;
                $oriimage = $doc->getElementsByTagName('ownerImage')->item(0)->nodeValue;
                $jenis_lesen = $doc->getElementsByTagName('licType')->item(0)->nodeValue;

                $classA = $doc->getElementsByTagName('licClassA')->item(0)->nodeValue;
            
                $classA1 = $doc->getElementsByTagName('licClassA1')->item(0)->nodeValue;
                $classB = $doc->getElementsByTagName('licClassB')->item(0)->nodeValue;
                $classC = $doc->getElementsByTagName('licClassC')->item(0)->nodeValue;
                $classD = $doc->getElementsByTagName('licClassD')->item(0)->nodeValue;
                $classE = $doc->getElementsByTagName('licClassE')->item(0)->nodeValue;
                $classF = $doc->getElementsByTagName('licClassF')->item(0)->nodeValue;
                $classG = $doc->getElementsByTagName('licClassG')->item(0)->nodeValue;
                $classH = $doc->getElementsByTagName('licClassH')->item(0)->nodeValue;
                $classI = $doc->getElementsByTagName('licClassI')->item(0)->nodeValue;
                $oriEffectiveDate = $doc->getElementsByTagName('licEffectiveDate')->item(0)->nodeValue;
                $oriExpiryDate = $doc->getElementsByTagName('licExpiryDate')->item(0)->nodeValue;     
          
                $EffectiveDate = str_replace('-', '/', $oriEffectiveDate);
                $ExpiryDate = str_replace('-', '/', $oriExpiryDate);   

                $image = $oriimage != ' ' ? base64_encode(pack('H*',$oriimage)) : '';

                //$kodqr = $doc->getElementsByTagName('qrImage')->item(0)->nodeValue; 
                $kodqr = "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";
               
                $kategori = $doc3->getElementsByTagName('category')->item(0)->nodeValue;
                $bil3 = $doc3->getElementsByTagName('licType')->length;
               
              
     
  
      //  $newdate = $nowDate->gt($otherDate);

                if($bil3>0)
                    {
                       $y = 0;

                        while ($y < $bil3) {
                            $lesen = $doc3->getElementsByTagName('licType')->item($y)->nodeValue;
                            $expired = $doc3->getElementsByTagName('expiryDate')->item($y)->nodeValue;
                            $kodlesen = substr($lesen,0,3);
                            $tr = str_replace('/','-',$expired);
                                                    
                            //$date1= date_create("11-01-2022");
                            $date1= date_create($tr);
                             $date2= date_create($today);
                             $rslt = date_diff($date1,$date2)->format('%a');

                               if($kodlesen <> 'CDL'){
                                  if($kodlesen <> 'PDL'){
                                    if($rslt<731)//display lesen valid for not more than 2 years before
                                      {
                                        $l[] = array("lesen" => $lesen, "tempoh_tamat" => $expired, "kod_lesen" => $kodlesen,"hari" =>$rslt);
                                      }
                                      else{
                                          $l =array();
                                      }
                                 //     }
                                    }
                                  }
                            $y++;
                        }
                    }
                else
                    {
                           $l =array();
                    }
               

  //$k[] = array("nokenderaan" => 'JALURGEMILANG1234');
                return response()->json([
                    'connStatus' => 200,
                    'user' => $nama,
                    'nokp' => $nokp,
                    'status' => $status, 
                    'message'   => $message, 
                    'nationality'   =>  $nationality, 
                    'refNo' =>  $refNo, 
                    'addres1' => $addres1, 
                    'addres2'   =>  $addres2, 
                    'addres3' => $addres3,
                    'postcode'  => $postcode, 
                    'city'  =>  $city, 
                    'state' => $state, 
                    'country' => $country, 
                    'image' => $image, 
                    'jenis_lesen' => $jenis_lesen, 
                    'classA'    =>  $classA, 
                    'classA1'   =>  $classA1, 
                    'classB'    =>  $classB, 
                    'classC'    =>  $classC, 
                    'classD'    =>  $classD, 
                    'classE'    =>  $classE, 
                    'classF'    =>  $classF, 
                    'classG'    =>  $classG,
                    'classH'    =>  $classH, 
                    'classI'    =>  $classI,
                    'EffectiveDate' =>  $EffectiveDate, 
                    'ExpiryDate'    =>  $ExpiryDate,    
                    'noplat'  =>  $k,
                    'kodqr'  =>  $kodqr,
                    'lesen' => $l,
                      
                   
                   
                ]);

            } else
              {
                return response()->json([
                    'connStatus' => 200,
                    'status' => $status, 
                    'message'   => $message, 
                     'noplat'  =>  $k,
                   ]);


              }
           

       
        } catch (\Throwable $th) {
            $icno = $doc->getElementsByTagName('ownerICNo')->item(0)->nodeValue;
           // $cat = $doc->getElementsByTagName('category')->item(0)->nodeValue;
            $statusMsg = $doc->getElementsByTagName('respMsg')->item(0)->nodeValue;
            $status = array("nokp" => $icno, "status_message" => $statusMsg,  "connStatus" => 400);

            return response()->json($status);
        }
    }

public function semakeLKMold(Request $request)
    {
        //return 'a';
       $nokp = $request->nokp;
         // $nokp = '830622026110';
        $kategori = $request->kategori;
        $noplat = $request->noplat;

        $soapUrl = "http://10.180.5.38:9081/jpj-revamp-svc-pvr-ws/elkm_Inquiry";


        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                     <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:elkm="http://gateway.jpj.gov.my/elkm_Inquiry/">
                           <soapenv:Header/>
                           <soapenv:Body>
                              <elkm:inquiryDetailRequest>
                                 <in>' . $noplat . '~' . $nokp . '~' . $kategori . '</in>
                              </elkm:inquiryDetailRequest>
                           </soapenv:Body>
                        </soapenv:Envelope>';


                    
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
         //dd($doc);

        try {
             $user = $doc->getElementsByTagName('out')->item(0)->nodeValue;
             $d = explode("~",$user);

            $k[] = array(
                    // "name"=>$nama,
                    // "regno"=>$regno,
                    "response_code" => $d[0],
                    "nokp" =>  $d[1],
                    "nama" =>  $d[2],
                    "noKenderaan" =>  $d[3],
                    "effectiveDate" =>  $d[4],
                     "expiredDate" =>  $d[5],
                    "lkmAmount" =>  $d[6],
                     "kodTransaksi" =>  $d[7],
                    "kodKegunaan" =>  $d[8],
                     "bodyType" =>  $d[9],
                    "kodCaw" =>  $d[10],
                     "kodSekuriti" =>  $d[11],
                     "region" =>  $d[12],
                    "cc" =>  $d[13],
                     "jnsKegunaan" =>  $d[14],
                  
                   
                );

              
            return response()->json([
                'status' => 200,
                 'result' => $k, 

            ]);
            
        } catch (\Throwable $th) {
              $icno = "8888";
           // $cat = $doc->getElementsByTagName('category')->item(0)->nodeValue;
            $statusMsg = "TEST";
            $status = array("nokp" => $icno, "status_message" => $statusMsg, "status" => 400);

            return response()->json($status);
        }
    }


    public function ad()
    {
       return 'a';
    }
    
    public function semakeLKM(Request $request)
    {
        //return 'a';
       $nokp = $request->nokp;
    //    $nokp = '850505115005';
     // $nokp = '710615045202';
     // $nokp = '780813015550';
        $kategori = $request->kategori;
        $noplat = $request->noplat;
        /* if($noplat=='KDC6019')
             $nokp = '830622026110';
         else
             $nokp = '850505115005';*/

        $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/elkm_Inquiry";


        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                     <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:elkm="http://gateway.jpj.gov.my/elkm_Inquiry/">
                           <soapenv:Header/>
                           <soapenv:Body>
                              <elkm:inquiryDetailRequest>
                                <regnNo>' . $noplat . '</regnNo>
                                 <ownerId>' . $nokp . '</ownerId>
                                 <ownerCategory>' . $kategori . '</ownerCategory>
                              </elkm:inquiryDetailRequest>
                           </soapenv:Body>
                        </soapenv:Envelope>';


                    
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
         //dd($doc);

        //kodqr
        $xml_post_string2 = '<?xml version="1.0" encoding="utf-8"?>
                                     <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:elkm="http://gateway.jpj.gov.my/elkm_Inquiry/">
                                       <soapenv:Header/>
                                       <soapenv:Body>
                                          <elkm:inquiryQRRequest>
                                             <regnNo>' . $noplat . '</regnNo>
                                             <ownerId>' . $nokp . '</ownerId>
                                             <ownerCategory>' . $kategori . '</ownerCategory>
                                          </elkm:inquiryQRRequest>
                                       </soapenv:Body>
                                    </soapenv:Envelope>';


                    
        $headers2 = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/lic_appeal_expired_drivinglicense/",
            "Content-length: " . strlen($xml_post_string2),
        ); //SOAPAction: your op URL

       // $url2 = $soapUrl2;

        // PHP cURL  for https connection with auth
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch2, CURLOPT_URL, $url);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch2, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch2, CURLOPT_POST, true);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $xml_post_string2); // the SOAP request
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);

        // converting
        $response2 = curl_exec($ch2);
        // return response()->json($response);
        curl_close($ch);

        $doc2 = new \DOMDocument();

        $doc2->loadXML($response2);
   // dd($doc2);

        //maklumat insurans
         $xml_post_string3 = '<?xml version="1.0" encoding="utf-8"?>
                                     <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:elkm="http://gateway.jpj.gov.my/elkm_Inquiry/">
                                       <soapenv:Header/>
                                       <soapenv:Body>
                                          <elkm:inquiryInsuranceRequest>
                                             <ownerId>' . $nokp . '</ownerId>
                                             <ownerCategory>' . $kategori . '</ownerCategory>
                                             <regnNo>' . $noplat . '</regnNo>
                                          </elkm:inquiryInsuranceRequest>
                                       </soapenv:Body>
                                    </soapenv:Envelope>';


                    
        $headers3 = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/lic_appeal_expired_drivinglicense/",
            "Content-length: " . strlen($xml_post_string3),
        ); //SOAPAction: your op URL

       
        // PHP cURL  for https connection with auth
        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch3, CURLOPT_URL, $url);
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch3, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch3, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch3, CURLOPT_POST, true);
        curl_setopt($ch3, CURLOPT_POSTFIELDS, $xml_post_string3); // the SOAP request
        curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers3);

        // converting
        $response3 = curl_exec($ch3);
        // return response()->json($response);
        curl_close($ch3);

        $doc3 = new \DOMDocument();

        $doc3->loadXML($response3);
  //  dd($doc3);


        try {

              $status = $doc->getElementsByTagName('responseCode')->item(0)->nodeValue;
              $kodStatus = substr($status,0,10);
              if($kodStatus == 'GLB000000I')
              {
                        $nokp = $doc->getElementsByTagName('ownerId')->item(0)->nodeValue;
                        $nama = $doc->getElementsByTagName('ownerName')->item(0)->nodeValue;
                        $noKenderaan = $doc->getElementsByTagName('regnNo')->item(0)->nodeValue;
                        $effectiveDate = $doc->getElementsByTagName('effDate')->item(0)->nodeValue;
                        $expiryDate = $doc->getElementsByTagName('expDate')->item(0)->nodeValue;
                        $lkmAmount = $doc->getElementsByTagName('amount')->item(0)->nodeValue;
                        $kodTransaksi = $doc->getElementsByTagName('txnCode')->item(0)->nodeValue;
                        $kodKegunaan = $doc->getElementsByTagName('usage')->item(0)->nodeValue;
                        $bodyType = $doc->getElementsByTagName('bodyType')->item(0)->nodeValue;
                        $kodCaw = $doc->getElementsByTagName('branchCode')->item(0)->nodeValue;
                        $kodSekuriti = $doc->getElementsByTagName('securityCode')->item(0)->nodeValue;
                        if($doc->getElementsByTagName('regnArea')->item(0)->nodeValue=='10')
                          { $region='SEMENANJUNG';}
                        elseif($doc->getElementsByTagName('regnArea')->item(0)->nodeValue=='11')
                           { $region='LANGKAWI';}
                        elseif($doc->getElementsByTagName('regnArea')->item(0)->nodeValue=='20')
                           { $region='SABAH';}
                        elseif($doc->getElementsByTagName('regnArea')->item(0)->nodeValue=='30')
                           { $region='SARAWAK';}
                        else
                          { $region='Tidak Berkaitan';}


                        //$region = $doc->getElementsByTagName('regnArea')->item(0)->nodeValue;
                        $cc = $doc->getElementsByTagName('engineDisp')->item(0)->nodeValue;
                        $jnsKegunaan = $doc->getElementsByTagName('vehType')->item(0)->nodeValue;
                        $trhCetak = $doc->getElementsByTagName('printDate')->item(0)->nodeValue;
                       
                        
                        if(empty($doc->getElementsByTagName('operatorID')->item(0)->nodeValue))
                        {$operator = '';}
                      else
                       
                       {$operator = $doc->getElementsByTagName('operatorID')->item(0)->nodeValue;}

                       if(empty($doc->getElementsByTagName('bsnCode')->item(0)->nodeValue))
                    {$kodBSN = '';}
                      else
                       
                           {$kodBSN = $doc->getElementsByTagName('bsnCode')->item(0)->nodeValue;}
                  
                    if(empty($doc->getElementsByTagName('insurancePolicy1')->item(0)->nodeValue))
                    {
                      $ins1 = '';
                    }else{
                        $ins1 = $doc->getElementsByTagName('insurancePolicy1')->item(0)->nodeValue;
                    }

                    if(empty($doc->getElementsByTagName('insurancePolicy2')->item(0)->nodeValue))
                    {
                      $ins2 = '';
                    }else{
                        $ins2 = $doc->getElementsByTagName('insurancePolicy2')->item(0)->nodeValue;
                    }
                       

                       // $qrkod = $doc2->getElementsByTagName('qrImage')->item(0)->nodeValue;  
                      $qrkod = "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";

                        
                     //CODE YG BETUL UTK INSURANS
                     /*   $insResponseCode = $doc3->getElementsByTagName('responseCode')->item(0)->nodeValue;
                        if($insResponseCode == 'GLB000000I - Transaksi Berjaya')
                        {
                        $insCompanyCode = $doc3->getElementsByTagName('insCompanyCode')->item(0)->nodeValue;
                        $insCompanyName = $doc3->getElementsByTagName('insCompanyName')->item(0)->nodeValue;
                        $insEffectiveDate = $doc3->getElementsByTagName('insEffectiveDate')->item(0)->nodeValue;
                        $insExpiryDate = $doc3->getElementsByTagName('insExpiryDate')->item(0)->nodeValue;
                        }else
                        {
                          $insCompanyCode = '';
                          $insCompanyName = '';
                          $insEffectiveDate = '';
                          $insExpiryDate = '';

                        }*/
                      //  $user = $doc->getElementsByTagName('out')->item(0)->nodeValue;
                      //  $d = explode("~",$user);
                         $soapUrlI = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/lic_reg_drivingpermit_inq";

        $xml_post_stringI = '<?xml version="1.0" encoding="utf-8"?>
                            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:lic="http://www.gov.jpj.org/lic_reg_drivingpermit_inq/">
                                <soapenv:Header/>
                                <soapenv:Body>
                                <lic:vehicleLicInfoByvehRegno>
                                    <!--Optional:-->
                                    <reqInfo>
                                        <icno>' . $nokp . '</icno>
                                        <vehicleRegno>' . strtoupper($noplat) . '</vehicleRegno>
                                        <category>' . $kategori . '</category>
                                    </reqInfo>
                                </lic:vehicleLicInfoByvehRegno>
                                </soapenv:Body>
                            </soapenv:Envelope>';


        $headersI = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.gov.jpj.org/lic_reg_drivingpermit_inq/",
            "Content-length: " . strlen($xml_post_stringI),
        ); //SOAPAction: your op URL

        $urlI = $soapUrlI;

        // PHP cURL  for https connection with auth
        $chI = curl_init();
        curl_setopt($chI, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chI, CURLOPT_URL, $urlI);
        curl_setopt($chI, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chI, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($chI, CURLOPT_TIMEOUT, 10);
        curl_setopt($chI, CURLOPT_POST, true);
        curl_setopt($chI, CURLOPT_POSTFIELDS, $xml_post_stringI); // the SOAP request
        curl_setopt($chI, CURLOPT_HTTPHEADER, $headersI);

        // converting
        $responseI = curl_exec($chI);
        // return response()->json($response);

        curl_close($chI);

        $docI = new \DOMDocument();

        $docI->loadXML($responseI);
        // dd($doc);

      
          //  $bilI = $docI->getElementsByTagName('vehLicInsurance')->length;
          //  if($bilI>0){
          //  $s = 0;2021-11-18  18/12/2019

          //  while ($s < $bilI) {
        $insResponseCode = $docI->getElementsByTagName('statusCode')->item(0)->nodeValue;
                $insCompanyName = $docI->getElementsByTagName('vehLicInsurance')->item(0)->nodeValue;
                $startDate = $docI->getElementsByTagName('dateOfCommencement')->item(0)->nodeValue;
                $date1 = DateTime::createFromFormat('d/m/Y', $startDate);
                $insEffectiveDate = $date1->format('Y-m-d');

                $endDate = $docI->getElementsByTagName('expiryDate')->item(0)->nodeValue;
                  $date2 = DateTime::createFromFormat('d/m/Y', $endDate);
                $insExpiryDate = $date2->format('Y-m-d');
              
               

               // $k[] = array("vehicle_insurance" => $insurance, "date_of_commencement" => $dateOfCom, "expired" => $expired);
                $insCompanyCode='';

               // $s++;
         /*   }

          }else
                        {
                          $insCompanyCode = '';
                          $insCompanyName = '';
                          $insEffectiveDate = '';
                          $insExpiryDate = '';

                        }*/


                      $k[] = array(
                              // "name"=>$nama,
                              // "regno"=>$regno,
                              "response_code" => $status,
                              "nokp" =>  $nokp,
                              "nama" =>  $nama,
                              "noKenderaan" =>  $noKenderaan,
                              "effectiveDate" =>  $effectiveDate,
                               "expiredDate" =>  $expiryDate,
                              "lkmAmount" =>  $lkmAmount,
                               "kodTransaksi" =>  $kodTransaksi,
                              "kodKegunaan" =>  $kodKegunaan,
                               "bodyType" =>  $bodyType,
                              "kodCaw" =>  $kodCaw,
                               "kodSekuriti" =>  $kodSekuriti,
                               "region" =>  $region,
                              "cc" =>  $cc,
                              "jnsKegunaan" =>  $jnsKegunaan,
                              "qrkod" =>  $qrkod,
                              "insResponseCode" => $insResponseCode,
                              "insCompany" =>$insCompanyCode,
                              "insName" =>$insCompanyName,
                              "insEffectiveDate" =>  $insEffectiveDate,
                              "insExpiryDate" =>  $insExpiryDate,
                              "trhCetak" => $trhCetak,
                              "operator" => $operator,
                              "kodBSN" => $kodBSN,
                              "ins1" => $ins1,
                              "ins2" => $ins2,


                            
                             
                          );
                        

                      return response()->json([
                          'connStatus' => 200,
                           'result' => $k, 
                          // "response" => $response

                      ]);
              }else
              {
                   return response()->json([
                          'connStatus' => 200,
                           'result' => $status, 
                          // "response" => $response

                      ]);

              }
                      
        } catch (\Throwable $th) {
              $icno = "8888";
           // $cat = $doc->getElementsByTagName('category')->item(0)->nodeValue;
            $statusMsg = "TEST";
            $status = array("nokp" => $icno, "status_message" => $statusMsg, "connStatus" => 400, "response" => $response, "error" => print_r($th));

            return response()->json($status);
        }
    }


    /* public function ad(Request $request)
     {
        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subYear();
   
        print_r($currentDateTime);
        print_r($newDateTime);
        //return 'a';
     }*/

}
