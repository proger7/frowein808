<?php

include pathinfo(__FILE__,PATHINFO_DIRNAME)."/settings_modul.php";
$modul = new settings_modul();
$fields = array(
    array("Input","Mailserver Adresse","mail_serveraddress"),
    array("Input","Mailserver Port","mail_serverport"),
    array("Input","Mailserver Domain","mail_serverdomain"),
    array("Input","Absenderemail","mail_from"),
    array("SelectValue","Email-Benachrichtigung an","notify","email"),
	array("Select","Email-Format","mail_format",array(0=>"Html",1=>"Text",2=>"HTML und TEXT (Userwahl)")),
    array("Select","Template benutzen (nur HTML Format)","use_template",array(1=>"Ja",0=>"Nein"))
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>