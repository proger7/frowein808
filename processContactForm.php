<?php

require("includes/general.inc.php");

session_start();


if($LANG["language"]["shortname"] == "de" || $LANG["language"]["shortname"] == "") {
    $langLink = 'de';
} elseif($LANG["language"]["shortname"] == "en") {
    $langLink = 'en';
}
switch ($langLink) {
    case 'de':
    	$captchaErrMessage = "<h2>Sie haben einen ungültigen Captcha-Wert eingegeben</h2>";
        $successMessage = "<h2>Vielen Dank für deine Nachricht.</h2>";
        $errorEmail = "<h2>Bitte Ihre E-Mail eingeben</h2>";
        $errorMessage = "<h2 style='color:#e2001a'>Nicht alle Pflichtangaben ( * ) wurden ausgefüllt.</h2>";
    break;
    case 'en':
    	$captchaErrMessage = "<h2>You entered an invalid captcha value</h2>";
        $successMessage = "<h2>Thank you for your message.</h2>";
        $errorEmail = "<h2>Please enter your E-Mail</h2>";
        $errorMessage = "<h2 style='color:#e2001a'>Not all required fields ( * ) have been filled in.</h2>";
    break;
}



$contactMessage = "";


if( empty($_POST['vorname']) || empty($_POST['nachname']) || empty($_POST['email-p']) ) {
	$contactMessage .= $errorMessage;
} elseif ( !filter_var($_POST['email-p'], FILTER_VALIDATE_EMAIL) ) {
	$contactMessage .= $errorEmail;
} 


if( $_SESSION['capcha'] != $_POST['kapcha'] ) {
    $contactMessage .= $captchaErrMessage;
}


if( !empty($_POST['sec']) ) {
    die();
}

if ($_POST['honeypot'] == 1) {
    die();
}



// $captcha = $_POST['frc-captcha-solution'];
// if(!$captcha || ($captcha == '.UNSTARTED') ) {
//     $contactMessage .= $captchaErrMessage;
//     exit;
// }




if( $_SESSION["token"] != $_POST["token"] || !isset($_POST['token']) || !isset($_SESSION['token']) ) {
    exit("INVALID TOKEN");
}


if( !empty($_POST['vorname']) && !empty($_POST['nachname']) && !empty($_POST['email-p']) && filter_var($_POST['email-p'], FILTER_VALIDATE_EMAIL) && !empty($_POST['kapcha']) && ( $_SESSION['capcha'] == $_POST['kapcha'] ) && isset($_POST["token"]) && isset($_SESSION["token"]) && isset($_SESSION["token-expire"]) && $_SESSION["token"]==$_POST["token"]  ) {


    if (time() >= $_SESSION["token-expire"]) {
        exit("Token expired. Please reload form.");
    }


    $vorname = isset($_POST['vorname']) ? $_POST['vorname'] : '';
    $nachname = isset($_POST['nachname']) ? $_POST['nachname'] : '';
    $unternehmen = isset($_POST['unternehmen']) ? $_POST['unternehmen'] : '';
    $email = isset($_POST['email-p']) ? $_POST['email-p'] : '';
    $nachricht = isset($_POST['nachricht']) ? $_POST['nachricht'] : '';


    $mailto = "info@frowein808.de";
    $mailsubject = "KONTAKTFORMULAR HOMEPAGE.";
    $mailsubject_bot = "BOT of KONTAKTFORMULAR HOMEPAGE";
    $mailsubject_bot_irina = "BOT for Irina";
    $mailfrom = "homepage@frowein808.de";


	$txt  = 'Nachfolgend finden Sie eine automatisch generierte Email<br /><br />
	Vorname: '. $vorname.'<br />
	Nachname: '.$nachname.'<br />
	Unternehmen: '.$unternehmen.'<br />
	Email: '.$email.'<br />
	Nachricht: '.$nachricht.'<br />';

	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/HTML; charset=UTF-8' . "\r\n";
	$header .= 'From: '.$mailfrom. "\r\n";
	$header .= 'Reply-To: '.$mailfrom. "\r\n";
	$header .= 'Bcc: maier@telenorma.ag'. "\r\n";
	$header .= 'Bcc: melkostupova_mm@telenorma.ag'. "\r\n";
	$header .= 'X-Mailer: PHP/' . phpversion();

	mail($mailto, $mailsubject, $txt, $header);
	$contactMessage .= $successMessage;

    unset($_SESSION["token"]);
    unset($_SESSION["token-expire"]);

}


echo $contactMessage;

