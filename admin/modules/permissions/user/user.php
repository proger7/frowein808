<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/user_modul.php";
$modul = new user_modul();
$fields = array(
	array("Status3","Status","status"),
    array("Input","Name","name"),
    array("Input","Bentuzergruppe","group"),
    array("Input","Vorname","firstname"),
    array("Input","Nachname","surname"),
    array("Input","Firma","company"),
    //
	//array("Switch","Status","status")
    );
$buttons = array("Edit","Delete","Status3");
echo $modul->listTable($fields,FALSE,$buttons)
?>
