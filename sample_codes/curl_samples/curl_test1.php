<?php
/*
 * Created by PhpStorm.
 * User: kaya
 * Date: 3/26/2017
 * Time: 2:41 PM
 * Reference: http://takuya-1st.hatenablog.jp/entry/2014/07/27/093053
 */

//$url = "http://www.yahoo.co.jp";
$url = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=APPL";

$curl = curl_init($url); // 初期化！

$options = array(           // オプション配列
    //HEADER
    CURLOPT_HTTPHEADER => array(
        'accept: application/xml'
    ),
    //Method
    CURLOPT_HTTPGET => true,//GET
    CURLINFO_CONTENT_TYPE => 'application/xml',
);

//set options
curl_setopt_array($curl, $options); /// オプション値を設定
echo curl_setopt_array($curl, $options);
// request
$result = curl_exec($curl); // リクエスト実行
//print

echo "<h1>result </h1>";
echo $result;
?>