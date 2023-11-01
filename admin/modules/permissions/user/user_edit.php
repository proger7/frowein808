<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/user_modul.php";
$modul = new user_modul();
$fields = array(
    array("Input","Name","name"),
    array("UserGroup","Bentuzergruppe","group"),
    array("Password","Passwort","password"),
    array("Input","Vorname","firstname"),
    array("Input","Nachname","surname"),
    array("Input","Firma","company"),
    array("Input","Email","email"),
	// array('TableSelect','System User','system_user', 'login', 'user','id'),
    array("HtmlMin","Notes","notes",1024, false)
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
