<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/categoriesd_modul.php";
$modul = new categoriesd_modul();
$fields = array(
    array("Status","Status","Status"),
    array("Input","Kategorien","cat_name"),
    );
$buttons = array("Edit","Copy","Delete","Status");
$extrabuttons = array("Lang" => TRUE);
echo $modul->listTable($fields,FALSE,$buttons,$extrabuttons);
?>
