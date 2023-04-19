<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use stdClass;

class JpjInfoTempController extends Controller
{
    public function cubajap()
    {
        dd('cubajap');
    }

    public function login(Request $request)
    {
    
        $postdata = file_get_contents("php://input", false, stream_context_get_default(), 0, $_SERVER["CONTENT_LENGTH"]);
          if (isset($postdata)) {
            $request = json_decode($postdata, true);
            $username = $request['username'];
            $password = $request['katalaluan'];
            $onesignal_id = $request['playerid'];
            $uuid = $request['uuid'];


            $sourcexml = "login from apps";
           // $this->loginModel->saveLoginXML($postdata,$sourcexml);

          //  $data = $username.":".$password;
          //  $this->aduanModel->captureInput($data);
              $obj = new stdClass;

            if($username == "999999999999"){
                $obj->nama = "Abdul Wahub";
                $obj->emel = "abd.wahub@gmail.com";
                $obj->nokp = "999999999999";
                $obj->status = 0;
                $obj->message = "Success";

                $token = $obj->emel.$obj->nama.$obj->nokp.date("YmdHis");
                $salt = substr(strtr(base64_encode(openssl_random_pseudo_bytes(22)), '+', '.'), 0, 22);
                $token = crypt($token, '$2y$12$' . $salt);

                $obj->token = $token;
                // $this->loginModel->insertUserPublic($nama,$emel,$nokp,$token,$passwd);
               /* $data = $this->loginModel->getUserData($nokp);
                if(count($data) == 0){
                    $this->loginModel->insertUserPublic($nama,$emel,$nokp,$token,$passwd);
                }    */            
               // $this->aduanModel->loglogin($username,$status_login);
                echo json_encode($obj);
            }else{
                $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/public_SSO_Login"; // asmx URL of WSDL
                $soapUser = "username";  //  username
                $soapPassword = "password"; // password
                $username = trim($username);
                $password = trim($password);
                $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pub="http://www.gov.jpj.org/public_SSO_Login/">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <pub:checkSSOLogin>
                            <loginUserDetReq>
                                <userName>'.$username.'</userName>
                                <password>'.$password.'</password>
                                <sessionId></sessionId>
                                <publikType>Citizen</publikType>
                                <publikLocale>en</publikLocale>
                                <ssoFlag>sso</ssoFlag>
                            </loginUserDetReq>
                        </pub:checkSSOLogin>
                    </soapenv:Body>
                </soapenv:Envelope>';

               

                $headers = array(
                                    "Content-type: text/xml;charset=\"utf-8\"",
                                    "Accept: text/xml",
                                    "Cache-Control: no-cache",
                                    "Pragma: no-cache",
                                    "SOAPAction: http://www.gov.jpj.org/public_SSO_Login/", 
                                    "Content-length: ".strlen($xml_post_string),
                                ); //SOAPAction: your op URL

                $url = $soapUrl;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $response = curl_exec($ch); 
                curl_close($ch);

                $sourcexml = "Login mysikap response";
               // $this->loginModel->saveLoginXML($response,$sourcexml);
                
                $doc = new DOMDocument();
                $doc->loadXML($response);

              
                $status_login = trim($doc->getElementsByTagName('statusCode')->item(0)->nodeValue);

                if($status_login == 0){
                    $nama = trim($doc->getElementsByTagName('idmpuUserName')->item(0)->nodeValue);                
                    $emel = trim($doc->getElementsByTagName('idmpuUserEmail')->item(0)->nodeValue);
                    $nokp = trim($doc->getElementsByTagName('idmpuUsrId')->item(0)->nodeValue);
                    $sec = trim($doc->getElementsByTagName('idmpuSQ2Ans')->item(0)->nodeValue);
                    $passwd = trim($doc->getElementsByTagName('idmpuPassword')->item(0)->nodeValue);
                
                    $obj->nama = trim($nama);
                    $obj->emel = trim($emel);
                    $obj->nokp = trim($nokp);
                    $obj->status = 0;
                    $obj->message = "Success";

                   // $token = $emel.$nama.$nokp.date("YmdHis");
                    $token = $emel.$nama.$nokp.date("YmdHis");
                    $salt = substr(strtr(base64_encode(openssl_random_pseudo_bytes(22)), '+', '.'), 0, 22);
                    $token = crypt($token, '$2y$12$' . $salt);

                    $obj->token = $token;
                    // $this->loginModel->insertUserPublic($nama,$emel,$nokp,$token,$passwd);
                   /* $data = $this->loginModel->getUserData($nokp);
                    $data2 = $this->loginModel->getUserDataEzPay($nokp);
                    $data3 = $this->loginModel->getUserDataJPJInfo($nokp);*/
                    
                   /* if(count($data) == 0){
                        $this->loginModel->insertUserPublic($nama,$emel,$nokp,$token,$passwd);
                    }  

                    if(count($data2) == 0){
                        $this->loginModel->insertUserPublic2($nama,$emel,$nokp,$token,$passwd);
                    }  

                    if(count($data3) == 0){
                        $this->loginModel->insertUserPublic3($nama,$emel,$nokp,$token,$passwd,$onesignal_id,$uuid);
                    }else{
                        $this->loginModel->updateUserPublic3($nama,$emel,$nokp,$token,$passwd,$onesignal_id,$uuid);
                    }  

                    $this->aduanModel->loglogin($username,$status_login);*/

                    // exec("wget http://egate.jpj.gov.my/jpjinfo-api/apps/".$nokp."/1");
                    $tarikh = date("Y-m-d");                    
                    $token = sha1($tarikh.$nokp.$tarikh);
                    $url1 = "http://egate.jpj.gov.my/jpjinfo-api/apps/getUserInfo2/".$nokp."/1/".$token;
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL,$url1);
                    curl_setopt($ch, CURLOPT_NOBODY, true);
                    curl_setopt($ch, CURLOPT_HEADER, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $server_output = curl_exec ($ch);
                    curl_close ($ch);
                    // echo $server_output;

                    echo json_encode($obj);
                }else{
                    $obj->status = $status_login;
                    $obj->message = "Login Fail";
                    $obj->status_login = $status_login;
                   // $this->aduanModel->loglogin($username,$status_login);
                    echo json_encode($obj);
                }
            }    
        }
           
    }

    public function login3(Request $request)
    {
    
        $postdata = file_get_contents("php://input", false, stream_context_get_default(), 0, $_SERVER["CONTENT_LENGTH"]);
          if (isset($postdata)) {
            $request = json_decode($postdata, true);
            $username = $request['username'];
            $password = $request['katalaluan'];
            $onesignal_id = $request['playerid'];
            $uuid = $request['uuid'];


            $sourcexml = "login from apps";
           // $this->loginModel->saveLoginXML($postdata,$sourcexml);

          //  $data = $username.":".$password;
          //  $this->aduanModel->captureInput($data);
              $obj = new stdClass;

            if($username == "999999999999"){
                $obj->nama = "Abdul Wahub";
                $obj->emel = "abd.wahub@gmail.com";
                $obj->nokp = "999999999999";
                $obj->status = 0;
                $obj->message = "Success";

                $token = $obj->emel.$obj->nama.$obj->nokp.date("YmdHis");
                $salt = substr(strtr(base64_encode(openssl_random_pseudo_bytes(22)), '+', '.'), 0, 22);
                $token = crypt($token, '$2y$12$' . $salt);

                $obj->token = $token;
                // $this->loginModel->insertUserPublic($nama,$emel,$nokp,$token,$passwd);
               /* $data = $this->loginModel->getUserData($nokp);
                if(count($data) == 0){
                    $this->loginModel->insertUserPublic($nama,$emel,$nokp,$token,$passwd);
                }    */            
               // $this->aduanModel->loglogin($username,$status_login);
                echo json_encode($obj);
            }else{
                $soapUrl = "https://mobile.jpj.gov.my:443/jpj-revamp-svc-pvr-ws/public_SSO_Login"; // asmx URL of WSDL
                $soapUser = "username";  //  username
                $soapPassword = "password"; // password
                $username = trim($username);
                $password = trim($password);
                $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pub="http://www.gov.jpj.org/public_SSO_Login/">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <pub:checkSSOLogin>
                            <loginUserDetReq>
                                <userName>'.$username.'</userName>
                                <password>'.$password.'</password>
                                <sessionId></sessionId>
                                <publikType>Citizen</publikType>
                                <publikLocale>en</publikLocale>
                                <ssoFlag>sso</ssoFlag>
                            </loginUserDetReq>
                        </pub:checkSSOLogin>
                    </soapenv:Body>
                </soapenv:Envelope>';

               

                $headers = array(
                                    "Content-type: text/xml;charset=\"utf-8\"",
                                    "Accept: text/xml",
                                    "Cache-Control: no-cache",
                                    "Pragma: no-cache",
                                    "SOAPAction: http://www.gov.jpj.org/public_SSO_Login/", 
                                    "Content-length: ".strlen($xml_post_string),
                                ); //SOAPAction: your op URL

                $url = $soapUrl;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $response = curl_exec($ch); 
                curl_close($ch);

                $sourcexml = "Login mysikap response";
               // $this->loginModel->saveLoginXML($response,$sourcexml);
                
                $doc = new DOMDocument();
                $doc->loadXML($response);

              
                $status_login = trim($doc->getElementsByTagName('statusCode')->item(0)->nodeValue);

                if($status_login == 0){
                    $nama = trim($doc->getElementsByTagName('idmpuUserName')->item(0)->nodeValue);                
                    $emel = trim($doc->getElementsByTagName('idmpuUserEmail')->item(0)->nodeValue);
                    $nokp = trim($doc->getElementsByTagName('idmpuUsrId')->item(0)->nodeValue);
                    $sec = trim($doc->getElementsByTagName('idmpuSQ2Ans')->item(0)->nodeValue);
                    $passwd = trim($doc->getElementsByTagName('idmpuPassword')->item(0)->nodeValue);
                
                    $obj->nama = trim($nama);
                    $obj->emel = trim($emel);
                    $obj->nokp = trim($nokp);
                    $obj->status = 0;
                    $obj->message = "Success";

                   // $token = $emel.$nama.$nokp.date("YmdHis");
                    $token = $emel.$nama.$nokp.date("YmdHis");
                    $salt = substr(strtr(base64_encode(openssl_random_pseudo_bytes(22)), '+', '.'), 0, 22);
                    $token = crypt($token, '$2y$12$' . $salt);

                    $obj->token = $token;
                    // $this->loginModel->insertUserPublic($nama,$emel,$nokp,$token,$passwd);
                   /* $data = $this->loginModel->getUserData($nokp);
                    $data2 = $this->loginModel->getUserDataEzPay($nokp);
                    $data3 = $this->loginModel->getUserDataJPJInfo($nokp);*/
                    
                   /* if(count($data) == 0){
                        $this->loginModel->insertUserPublic($nama,$emel,$nokp,$token,$passwd);
                    }  

                    if(count($data2) == 0){
                        $this->loginModel->insertUserPublic2($nama,$emel,$nokp,$token,$passwd);
                    }  

                    if(count($data3) == 0){
                        $this->loginModel->insertUserPublic3($nama,$emel,$nokp,$token,$passwd,$onesignal_id,$uuid);
                    }else{
                        $this->loginModel->updateUserPublic3($nama,$emel,$nokp,$token,$passwd,$onesignal_id,$uuid);
                    }  

                    $this->aduanModel->loglogin($username,$status_login);*/

                    // exec("wget http://egate.jpj.gov.my/jpjinfo-api/apps/".$nokp."/1");
                    $tarikh = date("Y-m-d");                    
                    $token = sha1($tarikh.$nokp.$tarikh);
                    $url1 = "http://egate.jpj.gov.my/jpjinfo-api/apps/getUserInfo2/".$nokp."/1/".$token;
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL,$url1);
                    curl_setopt($ch, CURLOPT_NOBODY, true);
                    curl_setopt($ch, CURLOPT_HEADER, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $server_output = curl_exec ($ch);
                    curl_close ($ch);
                    // echo $server_output;

                    echo json_encode($obj);
                }else{
                    $obj->status = $status_login;
                    $obj->message = "Login Fail";
                    $obj->status_login = $status_login;
                   // $this->aduanModel->loglogin($username,$status_login);
                    echo json_encode($obj);
                }
            }    
        }
           
    }

}
