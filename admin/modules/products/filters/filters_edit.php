<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/filters_modul.php";
$modul = new filters_modul();
$fields = array(
    array("Input","Value","name"),
    array("HTML","Comment","comment", 1024),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
