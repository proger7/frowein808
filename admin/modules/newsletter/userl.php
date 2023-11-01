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
    array("Status","Status","status"),
    array("Date","Datum","user_createdate"),
    array("Input","Subscribed ","if_unsubscribe"),
    array("Date","Unsubscribed Datum","unsubscribe_date"),
    array("Input","Nachname","user_nachname"),
    array("Input","Firstname","user_name"),
    array("Input","E-Mail","user_email"),
    );
$buttons = array("Edit","Delete","Status");
echo $modul->listTable($fields,FALSE,$buttons)
?>
