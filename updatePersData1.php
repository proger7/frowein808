<?php

require("includes/general.inc.php");

$errorMessage = "";
$KUNDENNUMMER = $_SESSION["_registry"]["frontend_user"]["KUNDENNUMMER"];

if( isset($_POST['pNameField']) || isset($_POST['pNachnameField']) || isset($_POST['personalPassw']) ) {
	$username = trim($_POST['pNameField']);
	$nachname = trim($_POST['pNachnameField']);
	$password = trim($_POST['personalPassw']);
	$DB->query('UPDATE newsletter_users SET user_name = "'.$username.'",user_nachname = "'.$nachname.'",user_pass = "'.$password.'" WHERE kundennummer = '.$KUNDENNUMMER.'');
	$errorMessage .= '<h2>Ihre Daten wurden erfolgreich aktualisiert.</h2>';
	echo $errorMessage;
}