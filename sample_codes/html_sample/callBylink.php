<?php
/**
 * Created by PhpStorm.
 * User: kaya
 * Date: 4/9/2017
 * Time: 8:40 PM
 */

    //check if the set variable exists
    if (isset($_GET['search']))
    {
        echo $_GET['search'];
        search($_GET['search']);
    }

    function Search($res)
    {
        //real search code goes here
        echo $res;
    }


?>

<a href="?search=15">Search</a>