<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/categories_modul.php";
$modul = new categories_modul();
$fields = array(
    array("Status","Status","status"),
    array("Input","Name","name")
    );
$buttons = array("Order","Edit","Delete","Status");
echo $modul->listTable($fields,FALSE,$buttons)
?>
