<?php


include "redirects.php";

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors',1);
// error_reporting(E_ALL);

require("includes/general.inc.php");

$css_files = array  (
                        $URL_ROOT."style/bootstrap.min.css",
                        $URL_ROOT."style/style.css?".rand(100, 10000),
                    );
$js_files = array   (
              $URL_ROOT."js/bootstrap.min.js",
              $URL_ROOT."js/bootstrap.bundle.min.js",
              $URL_ROOT."js/popper.min.js",
              $URL_ROOT."js/ckeditor.js",
              $URL_ROOT."js/main.js",
                    );


// START of lang switcher


if (isset($_GET["content"]) && $_GET["content"] != "") {
  $content = split("___", $_GET["content"]);
}
$content = explode('/',trim($_SERVER["REQUEST_URI"],'/'));



require_once 'content/header.php';


/* List of urls for 404 appear */
$urls = $DB->select("SELECT url FROM pages ");
$arr = [];
foreach($urls as $url){
  $arr[] = $url['url'];
}
if( !in_array($content[1], $arr) ) {
  include('content/404.php');
}


/* End of this contruction */

if( !empty($content[0]) ) {
    if( $content[0] == "de" || $content[0] == "en" ) {
        $_SESSION["_registry"]["lang"] = parse_ini_file($DIR_ROOT."/localisation/$content[0].ini", TRUE);
        $LANG = $_SESSION["_registry"]["lang"];
        $LANG["language"]["shortname"] = $content[0];
        $_SESSION['language'] = $lang;
        header("location: ".$_SESSION["_registry"]["HTTP_REFERER"]);
    }
    if( !isset($_SESSION["_registry"]["lang"]) ) {
        $_SESSION["_registry"]["lang"] = parse_ini_file($DIR_ROOT."/localisation/de.ini", TRUE);
        $LANG = $_SESSION["_registry"]["lang"];
        $LANG["language"]["shortname"] = "de";
        $_SESSION['language'] = $lang;
        header("location: ".$_SESSION["_registry"]["HTTP_REFERER"]);
    } 

    include("content/".$content[0].".php");

} elseif( !isset($_SESSION["_registry"]["lang"]) ) {

    include("tabgeo_country_v4/tabgeo_country_v4.php");
    $usip = $_SERVER['REMOTE_ADDR'];
    $country_code = tabgeo_country_v4($usip);
    if( $country_code == "DE" ) {
        $_SESSION["_registry"]["lang"] = parse_ini_file($DIR_ROOT."/localisation/de.ini", TRUE);
        $LANG = $_SESSION["_registry"]["lang"];
    } else {
        $_SESSION["_registry"]["lang"] = parse_ini_file($DIR_ROOT."/localisation/en.ini", TRUE);
        $LANG = $_SESSION["_registry"]["lang"];
    }
    include("content/home.php");

} elseif( isset($_SESSION["_registry"]["lang"]) ) {

    if($_SESSION["_registry"]["lang"] == "") {
      $_SESSION["_registry"]["lang"] = parse_ini_file($DIR_ROOT."/localisation/de.ini", TRUE);
      $LANG = $_SESSION["_registry"]["lang"];
    } else { 
      $_SESSION["_registry"]["lang"] = parse_ini_file($DIR_ROOT."/localisation/".$_SESSION['_registry']['lang']['language']['shortname'].".ini", TRUE);
      $LANG = $_SESSION["_registry"]["lang"];
    }
    include("content/home.php");

}


if( ($content[0] == 'de' || $content[0] == 'en') && !isset($content[1]) ){
  include("content/home.php");
} else {
  include("content/".$content[1].".php");
}



require_once 'content/footer.php';

$_SESSION["_registry"]["HTTP_REFERER"] = "https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];