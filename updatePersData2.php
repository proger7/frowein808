<?php

require("includes/general.inc.php");

$errorMessage = "";
$KUNDENNUMMER = $_SESSION["_registry"]["frontend_user"]["KUNDENNUMMER"];

if( isset($_POST['pStreet']) || isset($_POST['pCity']) || isset($_POST['pZip']) || isset($_POST['pLand']) ) {
	$street = trim($_POST['pStreet']);
	$city = trim($_POST['pCity']);
	$zip = trim($_POST['pZip']);
	$land = trim($_POST['pLand']);

	$DB->query('UPDATE newsletter_users SET user_street = "'.$street.'",user_ort = "'.$city.'",user_zip = "'.$zip.'",user_land = "'.$land.'" WHERE kundennummer = '.$KUNDENNUMMER.'');
	$errorMessage .= '<h2>Ihre Daten wurden erfolgreich aktualisiert.</h2>';
	echo $errorMessage;
}