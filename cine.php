<?php
//Auto Regis CinePoint With US Number
		// Headers
		$headers = array();
		$headers[] = 'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImNpbmVwb2ludCIsInBhc3N3b3JkIjoiJSVjaW5lcG9pbnQlJSIsImlhdCI6MTU2ODUyNjg5NywiZXhwIjoxNjY4NTI2Nzk3LCJzdWIiOiJjaW5lcG9pbnQuY29tIn0.1YYyV4PgosN5zJUjDkwAH0wbgqHiTq2Jiu1SPklCB-I';
		$headers[] = 'Content-Type: application/json';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'User-Agent: okhttp/3.12.1';
//
        $test = file_get_contents('https://api.randomuser.me');
preg_match('/"first":"(.*?)",/',$test,$first);
echo "AUTO REGIS CINEPOINT NUMBER US  \n";
echo "MMEK JEMBOT TOLKON  \n";
echo " Refferall lo anjinx : ";
$reff = trim(fgets(STDIN));
echo "Masukkan Nomorlo mek : ";
$nomor = trim(fgets(STDIN));

$bodyceknope = '{"country_id": "yJrb28JeWL","mobile_number": "'.$nomor.'"}';
$ceknope = curl('https://api.cinepoint.id/user/check-mobile-number',$bodyceknope,$headers);

$jsceknope = json_decode($ceknope[0]);
if($jsceknope->data->detail->exist == 1 ){
	print_r($jsceknope);
	die("Nomor Udah Di Pake /n");
} else {
$getotp = curl('https://api.cinepoint.id/otp/request',$bodyceknope,$headers);
$jsgetotp = json_decode($getotp[0]);
if($jsgetotp->meta->message == "OTP sent."){
	echo "OTP : ";
	$otp = trim(fgets(STDIN));
	$verifotp = curl('https://api.cinepoint.id/otp/verify','{"country_id": "yJrb28JeWL","mobile_number": "'.$nomor.'","otp": "'.$otp.'"}',$headers);
	$jsverifotp = json_decode($verifotp[0]);
	if($jsverifotp->data->detail->success == 1){

	echo "Status : ";
	$pesan = $jsverifotp->data->detail->success;
	echo $pesan;
	echo "\n";
	$token = $jsverifotp->data->detail->token;
	echo $token;
	$bodyregister = '{  "country_id": "yJrb28JeWL",  "debug": false,  "device_id": "a56e2aed1337'.rand(100,999).'ac",  "first_name": "'.$first[1].'",  "gender": "female",  "last_name": "alif",  "mobile_number": "'.$nomor.'",  "referral_id": "'.$reff.'",  "token": "'.$token.'",  "username": "'.$first[1].'ali'.rand(100,999).'"}';
	$bodyregis2 = '{  "country_id": "yJrb28JeWL",  "debug": false,  "device_id": "a56e2aed1337'.rand(100,999).'ac",  "first_name": "'.$first[1].'",  "gender": "male",  "last_name": "ali'.$first[1].'p",  "mobile_number": "'.$nomor.'",  "referral_id": "'.$reff.'",  "registration_id": "flkP-bNTYwI:APA'.rand(10,99).'bHLTcqPTiL6wOLpws-lnlWgyjh--l_g7G3-Y23Da9eWKUCm8k9lvEgk_dPM3bR9xVY0x2_UDa6WEjMMKpr4uhbQMsgPA0ebssr8T-iXfxn7Xwi_T'.rand(50,90).'rJMyAECcNtT37K'.rand(20,30).'Li'.rand(1,9).'Ix",  "token": "'.$token.'",  "username": "'.$first[1].'alipi'.rand(100,999).'"}';
	$register = curl('https://api.cinepoint.id/user', $bodyregis2, $headers);
	$jsregister = json_decode($register[0]);
	if($jsregister->data->detail->status == "active"){
		echo "SUKSES REGIS DENGAN REFF ".$reff." \n";
		} else {
			echo "Gagal \n";
			}
} else {
	print_r($jsverifotp);
}
} else {
	print_r($jsgetotp);
}
}






function curl($url, $fields = null, $headers = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($fields !== null) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }
        if ($headers !== null) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $result   = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return array(
            $result,
            $httpcode
        );
	}
