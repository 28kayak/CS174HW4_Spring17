<?php
/**
 * Created by PhpStorm.
 * User: kaya
 * Date: 3/25/2017
 * Time: 12:48 AM
 */
if(isset($_GET["company"]) )
{
    if ($_GET["company"] != "")
    {
        $comp_name = $_GET["company"];
        echo $comp_name . "is a company name";
        //curl_exec();
    }
    else
    {
        echo "Please Enter the compnay name";
    }
}


?>

