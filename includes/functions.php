<?php
error_reporting(0);

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', $_SESSION["_registry"]["system_config"]["debug"]["display_errors"]); 
unset ($_SESSION["_registry"]["db"]);
$registry->db = new db();
unset ($_SESSION["_registry"]["time"]);
$registry->time = new time();
$REGISTRY = $_SESSION["_registry"];
$LANG = $REGISTRY["lang"];
$DEBUG = $REGISTRY["system_config"]["debug"];
$DIR_ROOT = $REGISTRY["root"];
$DB = $REGISTRY["db"];
$URL_ROOT = $REGISTRY["system_config"]["site"]["base_url"];
$IMAGE = new image();
$TIME = new time();
if ($debug["debug_mode"] && $debug["configloads"]){
    echo "<br>";
    foreach($REGISTRY as $config => $configFlags){
        if (preg_match("/.*_config/", $config, $hit)) {
            echo '<p class="debug_msg" style="color:green;"><b>'.$hit[0].' loaded</b></p>';
        }
    }
}
if ($debug["debug_mode"] && $debug["showlang"]){
            echo '<p class="debug_msg" style="color:green;"><b>loaded language: '.$lang["language"]["name"].' ('.$lang["language"]["shortname"].')</b></p>';
}

if(is_file( pathinfo(__FILE__,PATHINFO_DIRNAME).'/custom_functions.inc.php')) include pathinfo(__FILE__,PATHINFO_DIRNAME).'/custom_functions.inc.php';

function _transform2forest($rows, $idName, $pidName){
	$children = array();
	$ids = array();
	foreach ($rows as $i=>$r) {
		$row =& $rows[$i];
		$id = $row[$idName];
		$pid = $row[$pidName];
		$children[$pid][$id] =& $row;
		if (!isset($children[$id])) $children[$id] = array();
			$row['sub'] =& $children[$id];
			$ids[$row[$idName]] = true;
		}
		$forest = array();
		foreach ($rows as $i=>$r) {
		$row =& $rows[$i];
		if (!isset($ids[$row[$pidName]])) {
			$forest[$row[$idName]] =& $row;
		}
	}
	return $forest;
}
function prepare_url($str){
	$str = str_replace(array("ä","ö","ü","ß"," ","&"),array("ae","oe","ue","ss","_","und"),$str);
	return $str;
}

function build_menu($arr,$hierarchy,$l=0){
	global $PATH_ARR, $URL_ROOT;
	$href_arr = array_flip($PATH_ARR);
	$ulclass=$l==0?' class="sf-menu"':'';
	$html='<ul'.$ulclass.'>';
	$i=0;
	$cnt=count($arr);
	foreach ($arr as $k=>$row){
		$i++;
		$html .= '<li class="';
		if($i!=$cnt && $i==1)
			$html .= ' first ';
		if($i==$cnt && $i!=1)
			$html .= ' last ';
		
		/*if(in_array($row['id'],$hierarchy))
			$html .= ' active ';*/
		
		
		if(in_array($row['id'],$hierarchy[0]))
			$html .= ' active ';
		
		$html .= '">';
		$href=$href_arr[$row['id']]?$href_arr[$row['id']]:build_path_by_id($row['id']);
		
		if($row['id']<>1)
			$html .= '<a href="'.$URL_ROOT.$href.'/">'.$row['title'].'</a>';
		else
			$html .= '<a href="'.$URL_ROOT.'">'.$row['title'].'</a>';
		
		if(!empty($row['sub'])){
			$html .= build_menu($row['sub'],$hierarchy,1);
		}
		$html .= '</li>';
	}
	$html.='</ul>';
	return $html;
}
function build_path_arr($arr,$path_arr){
	foreach ($arr as $k=>$row){
		$href=build_path_by_id($row['id']);
		$path_arr[$href]=$row['id'];
		if(!empty($row['sub'])){
			$path_arr=build_path_arr($row['sub'],$path_arr);
		}
	}
	return $path_arr;
}

function generate_path_arr(){
	global $DB;
	$all = $DB->select('SELECT `id`, `parent` FROM `pages` WHERE `status` = 1  ORDER BY `parent`, `order`;');
	$path_array = _transform2forest($all,'id','parent');
	return build_path_arr($path_array, array());
}

function get_id_parent($id){
	global $DB;
	return $DB->query_fetch('SELECT `id`, `parent`, `title` FROM `pages` WHERE `id` = '.$id.' LIMIT 1;');
}


function get_hierarchy($page_id,$h=array()){
	$path = get_id_parent($page_id);
	$h[]=array('id'=>$path['id'],'title'=>$path['title']);
	if($path['parent']>0)
		$h = get_hierarchy($path['parent'],$h);
	return $h;
}

function build_path_by_id($id){
	$path_arr = get_path_by_id($id);
	return implode('/',array_reverse($path_arr));
}

function get_path_by_id($id,$path=array()){
	global $DB;
	$item = $DB->query_fetch('SELECT LOWER(`title`) as title, LOWER(`url`) as url, `parent` FROM `pages` WHERE `id` = '.$id.' LIMIT 1;');
	$path[]=trim($item['url']?$item['url']:prepare_url($item['title']));
	if($item['parent']>0)
		$path = get_path_by_id($item['parent'],$path);
	return $path;
}
function get_settings_val($id){
	global $DB;
	$item = $DB->query_fetch_single('SELECT `value` FROM `settings` WHERE `id` = '.$id.' LIMIT 1;');
	return $item;
}

function main_menu($hierarchy){
	global $DB;
	$all = $DB->select('SELECT `id`, `title`, `url`, `order`, `parent` FROM `pages` WHERE `status` = 1 AND `in_menu` = "1" ORDER BY `parent`, `order`;');
	$menu_array = _transform2forest($all,'id','parent');
	return build_menu($menu_array,$hierarchy);
}

function get_page($id){
	global $DB;
	$page = $DB->query_fetch('SELECT * FROM `pages` WHERE `id` = '.$id.' LIMIT 1;');
	return $page;
}

function format_numb($nr){
	return number_format($nr,2,',',' ');
}

function build_breadcrumbs($hierarchy,$sub_id,$path){
	global $URL_ROOT,$PATH_ARR;
	$href_arr = array_flip($PATH_ARR);
	if($hierarchy){
		$pth=array();
		foreach($hierarchy as $k => $one){
			if($k==0 && !$sub_id)
				$breadcrumb[]=$one['title'];
			else
				$breadcrumb[]='<a href="'.$URL_ROOT.$href_arr[$one['id']].'">'.$one['title'].'</a>';
		}
		return 'Sie sind hier: '.implode(' > ',array_reverse($breadcrumb));
	}
}

function get_month($month_id){
	$month_arr=array(
		1=>'Januar',
		2=>'Februar',
		3=>'Marz',
		4=>'April',
		5=>'Mai',
		6=>'Juni',
		7=>'Juli',
		8=>'August',
		9=>'September',
		10=>'Oktober',
		11=>'November',
		12=>'Dezember'
	);
	return $month_arr[$month_id];
}

function crop_str($string, $limit){
	if(strlen($string)>$limit){
		$substring_limited = substr($string,0, $limit);
		return substr($substring_limited, 0, strrpos($substring_limited, ' ' )).'&hellip;';
	}else{
		return $string;
	}
}


function recalculate_basket($basket_id){
	global $DB;
	$DB->query('UPDATE `baskets` SET `sum` = (SELECT (SUM(`price`*`count`)) FROM `basket_items` WHERE `basket_id`='.$basket_id.'), `count` = (SELECT SUM(`count`) FROM `basket_items` WHERE `basket_id`='.$basket_id.') WHERE `id` = '.$basket_id);
}
function get_basket($basket_id){
	global $DB;
	return $DB->query_fetch('SELECT * FROM `baskets` WHERE `id`='.$basket_id);
}
function achim_send_curl($data){
	global $REGISTRY;
	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $REGISTRY['system_config']['site']['curl_url'].'curl.php');
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_USERAGENT, 'MSIE 5');
    $res = curl_exec($curl);
    if(!$res) {
        $error = curl_error($curl).'('.curl_errno($curl).')';
        curl_close($curl);
        return 'ERROR: '.$error;
    }
    else {
    	curl_close($curl);
        return 'RESULT: '.$res;
    }
}
function update_customer_data($id){
	global $DB;
	$user = $DB->query_fetch('SELECT * FROM `customers` WHERE `id`="'.$id.'" LIMIT 1');
	if($user && is_array($user) && !empty($user)){
         $_SESSION['customer'] = $user;
	}
}
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);

}

function generate_ean($start = false)
    {
    	global $DB;
        if($start === false)
        {
            // 2000000010001 - 2000000020001
            $code = '2' . rand(1000000, 9999999) . rand(3000, 9999);
            $isexist = $DB->query_fetch('SELECT `ean` FROM customers WHERE `ean` LIKE "'.$code.'"');
        }
        else 
        {
            $code = $start;
        }
        if (!empty($isexist))
            generate_ean();
        else
        {
            $codearr = str_split($code);
            $s1 = $s2 = 0;
            foreach ($codearr as $k => $it)
            {
                if ($k == 0 || $k % 2 == 0)
                {
                    $s1 += $it;
                } else
                {
                    $s2 += $it;
                }
            }
            $tmpres = $s2 * 3 + $s1;
            $tmpmax = (substr((string)$tmpres, 0, - 1) + 1) . '0';
            $lastitem = (int)$tmpmax - (int)$tmpres;
            $lastitem = $lastitem == 10 ? 0 : $lastitem;
            return $code . $lastitem;
        }
    }

function gen_token() {
    $bytes = openssl_random_pseudo_bytes(9, $cstrong);
    return bin2hex($bytes);
}

function cutString($str, $length, $postfix='...', $encoding=null) {
    $encoding = $encoding ?: mb_detect_encoding($str);
 
    if (mb_strlen($str, $encoding) <= $length) {
        return $str;
    }
 
    $tmp = mb_substr($str, 0, $length, $encoding);
    return mb_substr($tmp, 0, mb_strripos($tmp, ' ', 0, $encoding), $encoding) . $postfix;
}
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
     if($laenge<$origin){ 
         $string=$string."...";
     } 
     return $string; 
 } 
 
 function lang_getfrombrowser ($allowed_languages, $default_language = "en", $lang_variable = null, $strict_mode = true) {
        // $_SERVER['HTTP_ACCEPT_LANGUAGE'] verwenden, wenn keine Sprachvariable mitgegeben wurde
        if ($lang_variable === null) {
                $lang_variable = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        }

        // wurde irgendwelche Information mitgeschickt?
        if (empty($lang_variable)) {
                // Nein? => Standardsprache zur�ckgeben
                return $default_language;
        }

        // Den Header auftrennen
        $accepted_languages = preg_split('/,\s*/', $lang_variable);

        // Die Standardwerte einstellen
        $current_lang = $default_language;
        $current_q = 0;

        // Nun alle mitgegebenen Sprachen abarbeiten
        foreach ($accepted_languages as $accepted_language) {
                // Alle Infos �ber diese Sprache rausholen
                $res = preg_match ('/^([a-z]{1,8}(?:-[a-z]{1,8})*)'.
                                   '(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $accepted_language, $matches);

                // war die Syntax g�ltig?
                if (!$res) {
                        // Nein? Dann ignorieren
                        continue;
                }
                
                // Sprachcode holen und dann sofort in die Einzelteile trennen
                $lang_code = explode ('-', $matches[1]);

                // Wurde eine Qualit�t mitgegeben?
                if (isset($matches[2])) {
                        // die Qualit�t benutzen
                        $lang_quality = (float)$matches[2];
                } else {
                        // Kompabilit�tsmodus: Qualit�t 1 annehmen
                        $lang_quality = 1.0;
                }

                // Bis der Sprachcode leer ist...
                while (count ($lang_code)) {
                        // mal sehen, ob der Sprachcode angeboten wird
                        if (in_array (strtolower (join ('-', $lang_code)), $allowed_languages)) {
                                // Qualit�t anschauen
                                if ($lang_quality > $current_q) {
                                        // diese Sprache verwenden
                                        $current_lang = strtolower (join ('-', $lang_code));
                                        $current_q = $lang_quality;
                                        // Hier die innere while-Schleife verlassen
                                        break;
                                }
                        }
                        // Wenn wir im strengen Modus sind, die Sprache nicht versuchen zu minimalisieren
                        if ($strict_mode) {
                                // innere While-Schleife aufbrechen
                                break;
                        }
                        // den rechtesten Teil des Sprachcodes abschneiden
                        array_pop ($lang_code);
                }
        }

        // die gefundene Sprache zur�ckgeben
        return $current_lang;
}
function parr($arr){
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

function fsize($path) { 
      $fp = fopen($path,"r"); 
      $inf = stream_get_meta_data($fp); 
      fclose($fp); 
      foreach($inf["wrapper_data"] as $v) { 
        if (stristr($v, "content-length")) { 
          $v = explode(":", $v); 
          return trim($v[1]); 
        } 
      } 
      return 0;
}

function formattingFilesize($path) {
    $inbytes = fsize($path);
    $units="Bytes";
    if ($inbytes>1024)
    {   $units="KBytes";
        $inbytes=round(($inbytes/1024)*100)/100;
    }
    if ($inbytes>1024)
    {   $units="MBytes";
        $inbytes=round(($inbytes/1024)*100)/100;
    }
    echo $inbytes . ' ' . $units;
}

?>

