<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/categoriesb_modul.php";
$modul = new categoriesb_modul();
$fields = array(
    array("Status","Status","status"),
    array("Input","Kategorie","cat_name"),
    );
$buttons = array("Edit","Delete","Status");
$extrabuttons = array("Lang" => TRUE);
echo $modul->listTable($fields,FALSE,$buttons,$extrabuttons);
?>
