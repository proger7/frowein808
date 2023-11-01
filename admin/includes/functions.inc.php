<?php
function cut_txt($string,$laenge){
    $origin=strlen($string);
    $stri_arr=explode(" ",$string);
    $anzzahl=count($stri_arr);
    $gekuerzt=0;
    $string="";
    while($gekuerzt<$anzzahl){ 
        $string_alt=$string;
        $string=$string." ".$stri_arr[$gekuerzt];
        $gekuerzt++;
        if(strlen($string)>$laenge){ 
            $gekuerzt=$anzzahl; 
            $string=$string_alt;
        } 
    } 
    return $string; 
}
 
function send_mail($from = FALSE,$to = FALSE, $msg = FALSE, $subject = FALSE, $html= TRUE){
    if($from && $to && $msg && $subject){
        if ($html){
            $header  = 'MIME-Version: 1.0' . "\r\n";
            $header .= 'Content-type: text/html; charset=UTF-8' . "\r\n"; 
        }
            $header .= 'From: '.$from. "\r\n";          
            $header .= 'Reply-To: '.$from. "\r\n";
            $header .= 'X-Mailer: PHP/' . phpversion();
            return mail ($to,$subject,$msg,$header);
    }
    return "fehler";
}

function get_remote_file($url)
{
    if (ini_get('allow_url_fopen')) {
        return file_get_contents($url);
    }
    elseif (function_exists('curl_init')) {
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_HEADER, 0);
        $file = curl_exec($c);
        curl_close($c);
        return $file;
    }
    else {
        die('Error');
    }
} 

function mac_get_current_user(){
    return $_SESSION["_registry"]["user"]["name"];
}

function FilterText($txt) {
  $txt = str_replace ("Ä", "&Auml;", $txt);
  $txt = str_replace ("ä", "&auml;", $txt);
  $txt = str_replace ("Ö", "&Ouml;", $txt);
  $txt = str_replace ("ö", "&ouml;", $txt);
  $txt = str_replace ("Ü", "&Uuml;", $txt);
  $txt = str_replace ("ü", "&uuml;", $txt);
  $txt = str_replace ("ß", "&szlig;", $txt);
  return($txt);
}

function CleanText($txt) {
  $txt = str_replace ("Ä", "Ae", $txt);
  $txt = str_replace ("ä", "ae", $txt);
  $txt = str_replace ("Ö", "Oe", $txt);
  $txt = str_replace ("ö", "oe", $txt);
  $txt = str_replace ("Ü", "Ue", $txt);
  $txt = str_replace ("ü", "ue", $txt);
  $txt = str_replace ("ß", "ss", $txt);
  return($txt);
}
?>
