<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/key_accounts_modul.php";
$modul = new key_accounts_modul();
$fields = array(
        array("Status","Status","status"),
        array("Input","Titel","title"),
        array("Input","URL","link"),
    );
$buttons = array("Edit","Copy","Delete","Status");
 
echo $modul->listTable($fields,FALSE,$buttons,$extrabuttons);
?>
