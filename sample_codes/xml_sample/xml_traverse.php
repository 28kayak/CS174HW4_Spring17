<?php
/**
 * Created by PhpStorm.
 * User: kaya
 * Date: 4/4/2017
 * Time: 8:04 PM
 */
$xml=simplexml_load_file("books.xml") or die("Error: Cannot create object");
echo $xml->book[0]->title . "<br>";
echo $xml->book[1]->title;
foreach ($xml->book as $item)
{
    echo "Book title is ".$item->title."<br>";
}

?>

