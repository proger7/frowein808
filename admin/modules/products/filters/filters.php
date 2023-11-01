<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/filters_modul.php";
$modul = new filters_modul();
$fields = array(
    array("Status","Status","status"),
    array("Input","Value","name"),
    array("Input","Comment","comment")
    );
$buttons = array("Order","Edit","Delete","Status");
echo $modul->listTable($fields,FALSE,$buttons)
?>
