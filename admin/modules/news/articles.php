<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/articles_modul.php";
$modul = new articles_modul();
$fields = array(
        array("Status","Status","status"),
        // array("Status","Archiv","news_archiv"),
        array("Input","Titel","news_headline"),
    	array("Input","Tags","news_tags"),
    );
$buttons = array("Edit","Copy","Delete","Status");
$extrabuttons = array("Lang" => TRUE);
echo $modul->listTable($fields,FALSE,$buttons,$extrabuttons);
?>
