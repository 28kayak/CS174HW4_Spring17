<?php
/**
 * Created by PhpStorm.
 * User: kaya
 * Date: 3/26/2017
 * Time: 2:57 PM
 * https://teratail.com/questions/29447
 */

function call_lookup_stockAPI($url)
{
    //initialize curl
    $curl = curl_init($url);
    //create an option array
    $options = array(
        //Header
        CURLOPT_HEADER => false,
            //array(
            //'accept: application/xml',
            //'Content-type: text/plain; charset=UTF-8'

        //),
        //method
        CURLOPT_HTTPGET => true,
        CURLINFO_CONTENT_TYPE => 'application/xml',
        CURLOPT_RETURNTRANSFER => true
    );
    $set = curl_setopt_array($curl, $options);
    if($set == true)
    {
        echo "setting up is ok <br>";
    }
    else{
        echo "setting up is not ok";
    }

   // echo  curl_setopt_array($curl, $options);
    $result = curl_exec($curl);
    if($result == true)
    {
        echo "result is true<br>";
        echo $result;// at this point, it is string-like
        echo "<br>";
        //$test = htmlspecialchars($result);
        //echo $test;
        $xml = simplexml_load_string($result);
       // $json = json_encode($xml);
       // $data = json_decode($json);
        echo "<br> show xml <br>";
        $list = $xml->getName();
        echo $xml->getName() ."<br>";
        echo $xml->LookupResult->Symbol ."<br>";
        $xml->asXML("test.xml");

        return $xml;

    }
    else{
        echo "result is false";
        $xml = "empty";
    }


    //$result = simplexml_load_string($result);
    //echo $result ."<br>";
    echo $xml;
    curl_close($curl);
    return $xml;
}//call_lookup_stockAPI


//echo "hello world<br>";
$uri = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=APPL";
$data = call_lookup_stockAPI($uri);
echo "<br>data <br>";

echo $data;

//echo "<pre>".$data."</pre>";
//$xml = new SimpleXMLElement($data);
//echo $xml;