<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/group_modul.php";
$modul = new group_modul();
$fields = array(
    //array("Status","Status","status"),
    array("Input","Name","name"),
    //array("Input","Parent","parent")
    );
$buttons = array("Edit","Delete"/*,"Status"*/);
echo $modul->listTable($fields,FALSE,$buttons, false)
?>
