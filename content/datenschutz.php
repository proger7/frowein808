<?php
if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}

switch ($langLink) {
	case "de":
		include('datenschutz/datenschutz-de.php');
	break;
	case "en":
		include('datenschutz/datenschutz-en.php');
	break;
}