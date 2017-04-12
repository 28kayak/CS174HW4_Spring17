<?php
/**
 * Created by PhpStorm.
 * User: Kaya Ota
 * Date: 3/25/2017
 * Time: 12:48 AM
 */
?>
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
    <input type="submit" name="search" value="Serach">Search</input>
    <input type="button" name="clear" value="clear" onclick="clear()">Clear</input>


</form>
</div>
<div id="result">

</div>
<script>
    function clear()
    {
        document.getElementById("result").innerHTML = "changed";
        console.log(document.getElementById("result"));


    }

</script>
</body>
</html>
<?php
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
        //header => false, result of curl does not contain http-header
        CURLOPT_HEADER => false,
        CURLOPT_HTTPGET => true,
        //CURLINFO_CONTENT_TYPE => 'application/xml',
        CURLOPT_RETURNTRANSFER => true
    );
    // set up options to curl
    curl_setopt_array($curl, $options);
    //exec curl
    $result = curl_exec($curl);
    //close cURL session and release the connection
    curl_close($curl);
    //$xml = simplexml_load_string($result);
    //echo "<br>-------result from function ------- <br>";
    //var_dump($xml);
    return $result;
}
/*
 * function: construct a string html-table form
 * @param $xml = well-formed xml string
 * @return
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
    </style>

    <?php
    $table = '<table style=\"width:100%;\">'
        .'<caption>Result of '.$_GET['company'].' '.'</caption>';
    $table .= '<tr>
        <th>Symbol</th>
        <th>Name</th>
        <th>Exchange</th>
        <th>Additional</th>
    </tr>';


    foreach ($xml->LookupResult as $item)
    {
        $table .= "<tr>
            <th>".$item->Symbol." </th>".
            "<th>".$item->Name."</th>".
            "<th>".$item->Exchange."</th>".
            //"<th> <a href=\"?get_moreInfo=\".$item->Symbol.'>More Info</a>';
            "<th>".
            '<a href="?get_moreInfo=AAPL"> More Info</a>'.
            "</th>";
      //  echo $item->Symbol."<br>";

    }
    $table .= "</table>";

    echo $table;
}
/**
 * this function is to check the result.
 * @param $xml = resultant xml from lookup API
 *
 */
function print_lookup($xml)
{
    foreach ($xml->LookupResult AS $item)
    {
        echo "Compnay name " .$item->Name ."<br>";
    }
}

/**
 * main
 */
if(isset($_GET['get_moreInfo']))
{
    $request_comp = $_GET["get_moreInfo"];
    $query = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=".$request_comp;
    echo $query."<br>";
    $result = call_lookup_stockAPI($query);
    echo $result;



}
else{
    if(isset($_GET["company"]) )
    {
        if ($_GET["company"] != "")
        {
            $comp_name = $_GET["company"];
            echo $comp_name . " is a company name <br>";
            $lookup_url = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=".$comp_name;
            echo "URL: ".$lookup_url."<br>";
            $result = call_lookup_stockAPI($lookup_url);
            echo "<br>----- Result ----- <br>";
            //echo $result;
            $xml = new SimpleXMLElement($result);
            form_html_table($xml);

            print_r($xml);

            if($xml != null)
            {






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

