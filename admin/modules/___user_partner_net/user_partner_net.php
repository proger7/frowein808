<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/user_partner_net_modul.php";
$modul = new user_partner_net_modul();
$fields = array(
    array("Input","ID","id"),
    array("Input","Kundenummer","kundennummer"),
    array("Status","Status","status"),

    array("Input","Nachname","user_nachname"),
    array("Input","Name 1 / Firstname","user_name"),
    array("Input","Name 2 / Lastname","user_name2"),
    array("Input","E-Mail","user_email"),
    array("Input","Import by","update_type"),

    );
$buttons = array("Edit","Delete","Status");
echo $modul->listTable($fields,FALSE,$buttons)
?>
