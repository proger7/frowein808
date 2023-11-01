<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/domains_modul.php";
$modul = new domains_modul();
$fields = array(
    array("Status","Status","status"),
    array("Input","Titel","domain_name"),
    );
$buttons = array("Edit","Delete","Status");
echo $modul->listTable($fields,FALSE,$buttons)
?>
