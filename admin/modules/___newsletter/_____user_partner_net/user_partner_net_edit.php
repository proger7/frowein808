<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/user_partner_net_modul.php";
$modul = new user_partner_net_modul();
$fields = array(
    array("Input","Kundennummer","kundennummer"),
    array("Input","Kontakt ID","contact_id"),
    array("Input","Passwort","user_pass"),
    array("Input","Email","user_email"),
    array("Input","Anrede","user_anrede"),
    array("Input","Titel","user_titel"),
    array("Input","Nachname","user_nachname"),
    array("Input","Name 1 / Firstname","user_name"),
    array("Input","Name 2 / Lastname","user_name2"),
    array("Input","Strasse","user_street"),
    array("Input","Postleitzahl","user_zip"),
    array("Input","Ort","user_ort"),
    //array("Select","Email-Format","user_mail_format",array(0=>"Html",1=>"Text")),
    // array("BoolSelectRelation","Interessengruppen","newsletter_user_group","group_id","user_id","group_name","newsletter_interestgroup")
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
