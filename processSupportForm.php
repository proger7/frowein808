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


$supportMessage = "";


if( empty($_POST['supportAddOptions']) || empty($_POST['suppname']) || empty($_POST['suppbusiness']) || empty($_POST['suppemail']) || empty($_POST['supptel']) || empty($_POST['suppAgreement']) ) {
	$supportMessage .= $errorMessage;
} elseif ( !filter_var($_POST['suppemail'], FILTER_VALIDATE_EMAIL) ) {
	$supportMessage .= $errorEmail;
}


if( $_SESSION['capcha'] != $_POST['kapcha'] ) {
	$supportMessage .= $captchaErrMessage;
}

if( $_SESSION["token"] != $_POST["token"] || !isset($_POST['token']) || !isset($_SESSION['token']) ) {
    exit("INVALID TOKEN");
}


if( !empty($_POST['sec']) ) {
    die();
}

if ($_POST['honeypot'] == 1) {
    die();
}



if( !empty($_POST['supportAddOptions']) && !empty($_POST['suppname']) && !empty($_POST['suppbusiness']) && !empty($_POST['suppemail']) && filter_var($_POST['suppemail'], FILTER_VALIDATE_EMAIL)  && !empty($_POST['supptel']) && !empty($_POST['suppAgreement']) && !empty($_POST['kapcha']) && ( $_SESSION['capcha'] == $_POST['kapcha'] ) && isset($_POST["token"]) && isset($_SESSION["token"]) && isset($_SESSION["token-expire"]) && $_SESSION["token"]==$_POST["token"] ) {


    if (time() >= $_SESSION["token-expire"]) {
        exit("Token expired. Please reload form.");
    }


	$requestType = isset($_POST['supportAddOptions']) ? $_POST['supportAddOptions'] : '';
	$message = isset($_POST['supp_message']) ? $_POST['supp_message'] : '';
	// $file = isset($_POST['supp_file']) ? $_POST['supp_file'] : '';
	$name = isset($_POST['suppname']) ? $_POST['suppname'] : '';
	$company = isset($_POST['suppbusiness']) ? $_POST['suppbusiness'] : '';
	$email = isset($_POST['suppemail']) ? $_POST['suppemail'] : '';
	$telefon = isset($_POST['supptel']) ? $_POST['supptel'] : '';
	$method = isset($_POST['suppVariants']) ? $_POST['suppVariants'] : '';


    $mailto = "info@frowein808.de";
    $mailsubject = "SUPPORTFORMULAR HOMEPAGE.";
    $mailsubject_bot = "BOT of SUPPORTFORMULAR HOMEPAGE";
    $mailsubject_bot_irina = "BOT for Irina";
    $mailfrom = "homepage@frowein808.de";

	$txt  = 'Nachfolgend finden Sie eine automatisch generierte Email<br /><br />
	Art der Anfrage: '. $requestType.'<br />
	Nachricht: '.$message.'<br />
	Ihr Name: '.$name.'<br />
	Ihr Unternehmen: '.$company.'<br />
	Ihr E-Mail: '.$email.'<br />
	Ihr Telefonnummer: '.$telefon.'<br />
	Wie dürfen wir Sie kontaktieren: '.$method.'<br />';

	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/HTML; charset=UTF-8' . "\r\n";
	$header .= 'From: '.$mailfrom. "\r\n";
	$header .= 'Reply-To: '.$mailfrom. "\r\n";
	$header .= 'Bcc: maier@telenorma.ag'. "\r\n";
	$header .= 'Bcc: melkostupova_mm@telenorma.ag'. "\r\n";
	$header .= 'X-Mailer: PHP/' . phpversion();

	mail($mailto, $mailsubject, $txt, $header);
	$supportMessage .= $successMessage;

    unset($_SESSION["token"]);
    unset($_SESSION["token-expire"]);

}

echo $supportMessage;