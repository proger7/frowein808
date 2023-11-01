<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/userl_modul.php";
$modul = new userl_modul();
$fields = array(
    array("Input","Email","user_email"),
    array("Input","Anrede","user_anrede"),
    array("Input","Nachname","user_nachname"),
    array("Input","Name 1 / Firstname","user_name"),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
