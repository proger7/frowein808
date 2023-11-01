<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/bestell_modul.php";
$modul = new bestell_modul();
$fields = array(
    array("Status","Status","status"),
    array("Table","Kategorie","news_cat_id","cat_name","orderinfo_categories","id"),
    array("Input","Text","news_subline"),
    );
$buttons = array("Edit","Delete","Status");
$extrabuttons = array("Lang" => TRUE);
echo $modul->listTable($fields,FALSE,$buttons,$extrabuttons);
?>
