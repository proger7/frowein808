<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/datenschutz_modul.php";
$modul = new datenschutz_modul();
$fields = array(
    array("Html","Text DE ","text_de" ),
    array("Html","Text EN ","text_en" ),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
