<style>
    td.action_buttons {
        //width: 192px;
    }
    .action_buttons a, .action_buttons i {
        padding: 5px 3px;
    }
</style>
<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/userl_modul.php";
$modul = new userl_modul();
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
