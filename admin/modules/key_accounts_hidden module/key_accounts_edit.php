<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/key_accounts_modul.php";
$modul = new key_accounts_modul();
$fields = array(
    array("Input","Titel","title"),
     array("Input","URL","link"),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
