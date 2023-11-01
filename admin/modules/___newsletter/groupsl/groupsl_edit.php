<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/groupsl_modul.php";
$modul = new groupsl_modul();
$fields = array(
    array("Input","Interessengruppe","group_name"),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
