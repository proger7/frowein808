<?php
    include "includes/general.inc.php";
    /*
    if(isset($_POST['name'])){
        $recipient= 'info@frowein808.de';
        $subject="=?UTF-8?B?".base64_encode('Nachtrag - '.$_POST['product']). "?=";
        $mailfrom = 'info@frowein808.de';
        $headers = "From: ".$mailfrom."\nReply-To: ".$mailfrom."\n";
        $headers .= "Content-type: text/html; charset=utf-8"."\r\n";
        $message = '
			Neue Frage zu '.$_POST['product'].'<br /><br />
			Vorname: '.$_POST['name'].'<br />
			Nachname: '.$_POST['surname'].'<br />
			E-Mail: '.$_POST['email'].'<br />
			Nachricht: '.$_POST['comment'].'<br />
		';
        mail($recipient,$subject,$message,$headers);
    }
*/
    if(isset($_POST['cookie_stats'])){
        $DB->query("INSERT INTO `cookie_stats` ( `date`, `ip`, `user_agent`, `cookie_type`) VALUES(now(),	'".$_SERVER['REMOTE_ADDR']."',	'".$_SERVER['HTTP_USER_AGENT']."',	'".$_POST['cookie_str']."');");
    }
?>