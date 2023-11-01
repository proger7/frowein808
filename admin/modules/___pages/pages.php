<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/pages_modul.php";
$modul = new pages_modul();
$fields = array(
	array("Switch","Status","status"),
	array("Switch","Menu","in_menu"),
    array("Input","Titel","title")
    );
$buttons = array("Edit","Copy","Delete");
echo $modul->listTable($fields,FALSE,$buttons);
?>