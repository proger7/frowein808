<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/groupsl_modul.php";
$modul = new groupsl_modul();
$fields = array(
    array("Status","Status","status"),
    array("Input","Kategoriename","group_name"),
    );
$buttons = array("Edit","Copy","Delete","Status");
echo $modul->listTable($fields,FALSE,$buttons)
?>
