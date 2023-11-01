<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/datenschutz_modul.php";
$modul = new datenschutz_modul();
$fields = array(
        array("Input","Titel","title"),
    );
$buttons = array("Edit"  );
echo $modul->listTable($fields,FALSE,$buttons);
?>
