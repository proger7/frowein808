<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/downloads_modul.php";
$modul = new downloads_modul();
$fields = array(
    array("Status","Status","status"),
    array("Input","ID","id"),
    array("Table","Kategorie","download_cat_id","cat_name","download_categories","id"),
    array("Input","Titel","download_title"),
	array("Input","Typ","download_typ"),
    );
$buttons = array("Edit","Delete","Status");
$extrabuttons = array("Lang" => TRUE);
echo $modul->listTable($fields,FALSE,$buttons,$extrabuttons);
?>
