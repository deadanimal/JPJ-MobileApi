<?php

namespace App\Console;

use App\Models\MaklumatKenderaan;
use App\Models\Notification;
use App\Models\StatusLesen;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            //call schedl1
            $this->sendnotification();
        })->dailyAt('22:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    // function

    public function sendMessage($ids, $msg, $ids_to)
    {
        $ids = explode(",", $ids);
        $content = array(
            "en" => $msg
        );

        $fields = array(
            'app_id' => $ids_to,
            'include_player_ids' => $ids,
            'data' => array("foo" => "bar"),
            'contents' => $content
        );


        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function sendnotification()
    {
        try{
            $data="";
            $tarikh = date("Ymd");
            $masa = date("His");
            $ids_to = "4a419a80-c178-4752-8107-585d3b21154c";
            
            $stmt = User::where('onesignal_id', '!=', '')->get();
            foreach ($stmt as $row) {
                $nokp = $row['nokp'];
                $ids  = $row['onesignal_id'];
                $tarikh = date("Y-m-d");
                $tarikh_hantar =  date("Y-m-d H:i:s");
                //lesen
                $stmt1 = StatusLesen::where('nokp', $nokp)->get();
                foreach ($stmt1 as $row1) {
                    $tarikh_tamat = $row1['tarikh_tamat'];
                    $date1=date_create($tarikh);
                    $date2=date_create($tarikh_tamat);
                    $diff=date_diff($date1,$date2);
                    $bil_hari = $diff->format("%R%a");
                    $jenis_lesen = $row1['jenis_lesen'];
                    if($bil_hari == 30){
                        $msg = "Lesen memandu anda (".$jenis_lesen.") akan tamat pada ".$tarikh_tamat." Sila perbaharui lesen anda sebelum ".$tarikh_tamat.". Sekian, terima kasih. ".$tarikh_hantar;
                        $response = $this->sendMessage($ids, $msg,$ids_to);
                        $tajuk = "Status Lesen Memandu";
                        $penerima = $nokp;
                        $jenis_noti = 3;
                        $perkara = $msg;

                        $stmt2 = new Notification();
                        $stmt2->tajuk = $tajuk;
                        $stmt2->perkara = $perkara;
                        $stmt2->penerima = $penerima;
                        $stmt2->jenis_noti = $jenis_noti;
                        $stmt2->onesignal_id = $ids;
                        $stmt2->tarikh_hantar = $tarikh;
                        $stmt2->save();
                    }
    
                    if($bil_hari == 7){
                        $msg = "Lesen memandu anda (".$jenis_lesen.") akan tamat pada ".$tarikh_tamat." Sila perbaharui lesen anda sebelum ".$tarikh_tamat.". Sekian, terima kasih. ".$tarikh_hantar;
                        $response = $this->sendMessage($ids, $msg,$ids_to);
                        $tajuk = "Status Lesen Memandu";
                        $penerima = $nokp;
                        $jenis_noti = 3;
                        $perkara = $msg;

                        $stmt2 = new Notification();
                        $stmt2->tajuk = $tajuk;
                        $stmt2->perkara = $perkara;
                        $stmt2->penerima = $penerima;
                        $stmt2->jenis_noti = $jenis_noti;
                        $stmt2->onesignal_id = $ids;
                        $stmt2->tarikh_hantar = $tarikh;
                        $stmt2->save();
                    }
    
                    if($bil_hari == 1){
                        $msg = "Lesen memandu anda (".$jenis_lesen.") akan tamat pada ".$tarikh_tamat." Sila perbaharui lesen anda sebelum ".$tarikh_tamat.". Sekian, terima kasih. ".$tarikh_hantar;
                        $response = $this->sendMessage($ids, $msg,$ids_to);
                        $tajuk = "Status Lesen Memandu";
                        $penerima = $nokp;
                        $jenis_noti = 3;
                        $perkara = $msg;

                        $stmt2 = new Notification();
                        $stmt2->tajuk = $tajuk;
                        $stmt2->perkara = $perkara;
                        $stmt2->penerima = $penerima;
                        $stmt2->jenis_noti = $jenis_noti;
                        $stmt2->onesignal_id = $ids;
                        $stmt2->tarikh_hantar = $tarikh;
                        $stmt2->save();
                    }
    
                    // if($bil_hari > 10){
                    //     $msg = "Test Lesen memandu anda (".$jenis_lesen.") akan tamat pada ".$tarikh_tamat." Sila perbaharui lesen anda sebelum ".$tarikh_tamat.". Sekian, terima kasih. ".$tarikh_hantar;
                    //     $response = sendMessage($ids, $msg,$ids_to);
                    //     $tajuk = "Status Lesen Memandu";
                    //     $penerima = $nokp;
                    //     $jenis_noti = 3;
                    //     $perkara = $msg;
                    //     $sql2 = "insert into notifications (tajuk,perkara,penerima,jenis_noti,onesignal_id,tarikh_hantar) values ('$tajuk','$perkara','$penerima','$jenis_noti','$ids','$tarikh')";
                    //     $stmt2 = $db->prepare($sql2);
                    //     $stmt2->execute();
                    // }
                }// lesen
    
                //roadtax

                $stmt3 = MaklumatKenderaan::where("nokp", $nokp)->get();
                foreach ($stmt3 as $row3) {
                    $tarikh_tamat = $row3['tarikh_tamat'];
                    $date1=date_create($tarikh);
                    $date2=date_create($tarikh_tamat);
                    $diff=date_diff($date1,$date2);
                    $bil_hari = $diff->format("%R%a");
                    $no_kenderaan = $row3['no_kenderaan'];
    
                    if($bil_hari == 30){
                        $msg = "Cukai Jalan kenderaan anda (".$no_kenderaan.") akan tamat pada ".$tarikh_tamat." Sila perbaharui cukai jalan kenderaan anda sebelum ".$tarikh_tamat.". Sekian, terima kasih. ".$tarikh_hantar;
                        $response = $this->sendMessage($ids, $msg,$ids_to);
                        $tajuk = "Status Lesen Memandu";
                        $penerima = $nokp;
                        $jenis_noti = 3;
                        $perkara = $msg;

                        $stmt4 = new Notification();
                        $stmt4->tajuk = $tajuk;
                        $stmt4->perkara = $perkara;
                        $stmt4->penerima = $penerima;
                        $stmt4->jenis_noti = $jenis_noti;
                        $stmt4->onesignal_id = $ids;
                        $stmt4->tarikh_hantar = $tarikh;
                        $stmt4->save();
                    }
    
                    if($bil_hari <= 7 && $bil_hari > 0){
                        $msg = "Cukai Jalan kenderaan anda (".$no_kenderaan.") akan tamat pada ".$tarikh_tamat." Sila perbaharui cukai jalan kenderaan anda sebelum ".$tarikh_tamat.". Sekian, terima kasih. ".$tarikh_hantar;
                        $response = $this->sendMessage($ids, $msg,$ids_to);
                        $tajuk = "Status Lesen Memandu";
                        $penerima = $nokp;
                        $jenis_noti = 3;
                        $perkara = $msg;

                        $stmt4 = new Notification();
                        $stmt4->tajuk = $tajuk;
                        $stmt4->perkara = $perkara;
                        $stmt4->penerima = $penerima;
                        $stmt4->jenis_noti = $jenis_noti;
                        $stmt4->onesignal_id = $ids;
                        $stmt4->tarikh_hantar = $tarikh;
                        $stmt4->save();
                    }
    
                    // if($bil_hari > 5){
                    //     $msg = "test Cukai Jalan kenderaan anda (".$no_kenderaan.") akan tamat pada ".$tarikh_tamat." Sila perbaharui cukai jalan kenderaan anda sebelum ".$tarikh_tamat.". Sekian, terima kasih. ".$tarikh_hantar;
                    //     $response = sendMessage($ids, $msg,$ids_to);
                    //     $tajuk = "Status Lesen Memandu";
                    //     $penerima = $nokp;
                    //     $jenis_noti = 3;
                    //     $perkara = $msg;
                    //     $sql4= "insert into notifications (tajuk,perkara,penerima,jenis_noti,onesignal_id,tarikh_hantar) values ('$tajuk','$perkara','$penerima','$jenis_noti','$ids','$tarikh')";
                    //     $stmt4 = $db->prepare($sql4);
                    //     $stmt4->execute();
                    // }
                }
            }
    
            // $sql  = "update aduan set status_aduan = '5' where status_aduan = '2' AND ((DATEDIFF(NOW(),create_date)) > 30)";
            // $stmt = $db->prepare($sql);
            // $stmt->execute();
            
        }catch(\Throwable $th){
            echo "Error: " . $th->getMessage();
        }
    }
}
