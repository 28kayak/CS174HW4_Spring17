<?php
/**
 * Created by PhpStorm.
 * User: kaya
 * Date: 3/26/2017
 * Time: 1:16 PM
 */
$url = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=APPL";
//$url = "https://www.google.com/";
$curl = curl_init($url);
echo $curl;
curl_setopt($curl, CURLOPT_URL, $url );
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json;charset=utf-8"));
curl_setopt($curl, CURLOPT_HEADER, array() );
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
//curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
echo $curl;
$curl_response = curl_exec($curl);

echo "response :".$curl_response;
curl_close($curl)
?>