<?php

require("includes/general.inc.php");

if($LANG["language"]["shortname"] == "de" || $LANG["language"]["shortname"] == "") {
	$langLink = 'de';
} elseif($LANG["language"]["shortname"] == "en") {
	$langLink = 'en';
}

if($_POST["logout"])
{
  unset ($_SESSION["_registry"]["frontend_user"]);
  echo '<script>window.location = "'.$URL_ROOT. $langLink .'/partner/";</script>';
}