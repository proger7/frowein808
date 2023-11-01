<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/newsl_modul.php";
$modul = new newsl_modul();
$fields = array(
    array("Input","ID","id"),
    array("StatusSend","Status","status"),
    array("Date","Datum","letter_date"),
    array("Input","Betreff","letter_subject"),
    );
$buttons = array("Preview","Send","Copy","Edit","Delete");
$extrabuttons = array("Lang" => TRUE);
echo $modul->listTable($fields,FALSE,$buttons,$extrabuttons)
?>
