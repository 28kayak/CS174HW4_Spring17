<?php
/**
 * Created by PhpStorm.
 * User: kaya
 * Date: 3/25/2017
 * Time: 12:48 AM
 */

/**
 * function: call lookup stock API
 * this function calls API from http://dev.markitondemand.com/MODApis/#interactive
 * whose function is Company Lookup API
 *
 * @param $url = URL to access to the Company Lookup API
 * @return well-formed xml String type
 */
function call_lookup_stockAPI($url)
{
    //initialize curl-object
    $curl = curl_init();
    //sett up curl's options using option array
    $options = array(
        //header => false, result of curl does not contain http-header
        CURLOPT_HEADER => false,
        CURLOPT_HTTPGET => true,
        CURLINFO_CONTENT_TYPE => 'application/xml',
        CURLOPT_RETURNTRANSFER => true
    );
    // set up options to curl
    curl_setopt_array($curl, $options);
    //exec curl
    $result = curl_exec($curl);
    //close cURL session and relese
    curl_close($curl);
    return $result;
}
function form_html_table()
{

}

/**
 * main
 */
if(isset($_GET["company"]) )
{
    if ($_GET["company"] != "")
    {
        $comp_name = $_GET["company"];
        echo $comp_name . "is a company name <br>";
        $lookup_url = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=".$comp_name;
        echo "URL: ".$lookup_url."<br>";








    }
    else
    {//missing input = company name
        ?>

        <script>
            alert("Please Enter a company name OR its symbol");
        </script>
<?php
    }
}


?>

