<?php
/**
 * Created by PhpStorm.
 * User: Kaya Ota
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
    $curl = curl_init($url);
    //sett up curl's options using option array
    $options = array(
    CURLOPT_HEADER => false,
    CURLOPT_HTTPGET => true,
    CURLOPT_RETURNTRANSFER => true
    );
    // set up options to curl
    curl_setopt_array($curl, $options);
    //exec curl
    $result = curl_exec($curl);
    //close cURL session and release the connection
    curl_close($curl);

    return $result;
}
/*
 * function: construct a string html-table form
 * @param $xml = well-formed xml string
 * @return well-formed-html-table string
 * */
function form_html_table($xml)
{
    // inserting a CSS format for the table.
    ?>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        caption{
            font-size: 30px;
        }
    </style>

    <?php
   // $table = '<div id="result">';
    $table = '<table style=\"width:100%;\" id="result">'
        .'<caption>Result of '.$_GET['company'].' '.'</caption>';
    $table .= '<tr>
        <th>Symbol</th>
        <th>Name</th>
        <th>Exchange</th>
        <th>Additional</th>
    </tr>';


    foreach ($xml->LookupResult as $item)
    {
        //$href = '\"?get_moreInfo='.$item->Symbol."\"";
        $href = '"?get_moreInfo='.$item->Symbol."\"";
        $table .= "<tr>
            <th>".$item->Symbol." </th>".
            "<th>".$item->Name."</th>".
            "<th>".$item->Exchange."</th>".
            "<th>".
            '<a href='.$href.'> More Info</a>'.
            "</th>";
        //  echo $item->Symbol."<br>";

    }
    $table .= "</table>";

    //echo $table;
    return $table;

}

/**
 *function: make_table_by_Json
 * precondition : $json is not NULL  AND the status of response is "SUCCESS"
 *@param : $json is a quote information json from Market on Demand
 * @return : well-formed html string
 */
function make_table_by_Json($json)
{
    ?>
    <!-- CSS for HTML Table-->
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        caption{
            font-size: 30px;
        }
    </style>

    <?php
   // $table = '<div id="result">';
    $table = '<table style=\"width:100%;\" id="result">'
        .'<caption>For Additional Information </caption>';
    $table .= '<tr>
        <th>Description</th>
        <th>Data</th>
    </tr>';
    $table .= ' <tr>
        <th>Name</th>
        <th>'. $json["Name"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>Symbol</th>
        <th>'. $json["Symbol"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>Last Price</th>
        <th>'. $json["LastPrice"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>Change</th>
        <th>'. $json["Change"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>Change Percent</th>
        <th>'. $json["ChangePercent"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>TimeStamp</th>
        <th>'. $json["Timestamp"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>Market Cap</th>
        <th>'. $json["MarketCap"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>Volume</th>
        <th>'. $json["Volume"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>Change YID</th>
        <th>'. $json["ChangeYTD"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>Change Percent YID</th>
        <th>'. $json["ChangePercentYTD"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>High</th>
        <th>'. $json["High"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>Low</th>
        <th>'. $json["Low"] . '</th>
    </tr>';
    $table .= ' <tr>
        <th>Open</th>
        <th>'. $json["Open"] . '</th>
    </tr>';
    //$table .= "</div>";

    return $table;

}//make_table_by_Json
/**
 * main
 */
if(isset($_GET['get_moreInfo']))
{
    //CASE: moreInfo is clicked
    $request_comp = $_GET["get_moreInfo"];
    $query = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=".$request_comp;
    echo $query."<br>";
    $quote = call_lookup_stockAPI($query);
    //var_dump($result);
    $quote_json = json_decode($quote, true);
    //echo $quote;
    if($quote_json["Status"] === "SUCCESS")
    {
        echo "Retuned Status" .$quote_json["Status"]."<br>";
        $table_format = make_table_by_Json($quote_json);
        echo $table_format;
    ?>

    <script>
       document.getElementById("result").innerHTML="<?= $table_format ?>";
    </script>
    <?php
    }//if($quote_json["status"])
    else{
        //in the case: the query for more Info fails
        echo "<h1>Unable to get more information</h1>";
    }








}//if(isset($_get["get_moreInfo"]))
else{
    if(isset($_GET["company"]) )
    {
        if ($_GET["company"] != "")
        {
            $comp_name = $_GET["company"];
            //echo $comp_name . " is a company name <br>";
            $lookup_url = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=".$comp_name;
            echo "<p id='result'>Request ed URL: ".$lookup_url."<br> </p>";
            $result = call_lookup_stockAPI($lookup_url);
            //echo "<br>----- Result ----- <br>";
            //echo $result;
            $xml = new SimpleXMLElement($result);

            if($xml != null)
            {
                //succeeded to parse xml with SimpleXMLElement
                $result = form_html_table($xml);

                echo $result;//showing table
                ?>
                    <script>
                        document.getElementsByClassName("outcome").innerHTML  = null;
                       //document.getElementById("result").innerHTML="<?= $result; ?>";
                       //var res = document.getElementById("result");
                       //res.innerHTML = "";
                       //res.parentNode.appendChild()

                    </script>
                <?php

            }
            else
            {
                echo "xml_lookup_data is null";
            }

        }
        else
        {//missing input = company name
            ?>

            <script>
                alert("Please Enter a company name OR its symbol");
            </script>
            <?php
        }

    }//if(isset())

}//else(isset($_get['get_moreInfo']))

?>


<!--------HTML---------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock Search</title>

    <link rel="stylesheet" type="text/css" href="index.css">

</head>
<body>
<div class="container">

    <form action="stock.php" method="get" class="stock-form">
        Company Name Or Symbol:
        <input type="text" name="company">
        <br>
        <input type="submit" name="search" value="Search">
        <input type="button" name="clear" value="Clear" onclick="clear_table();">

    </form>
</div>

<div id="result" class="outcome">

</div>
<script>
    function clear_table()
    {
        //function clear() is reserved, so cannot use
        var res = document.getElementById("result");
        res.innerHTML = "";
        res.parentNode.removeChild(res);
        //document.getElementById("result").innerHTML = "    "
       // document.getElementsByTagName("table").innerHTML = null;
        //console.log(document.getElementById("result"));

    }

</script>
</body>
</html>
<!------End of HTML ------------------------------------------------------------------------------------------>

