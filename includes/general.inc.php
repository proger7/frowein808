<?php
error_reporting(0);

spl_autoload_register(function($class){
    $classpath = pathinfo(__FILE__,PATHINFO_DIRNAME).'/../admin/includes/classes/'.$class.'.class.php';
    if ($_SESSION["_registry"]["system_config"]["debug"]["debug_mode"] && $_SESSION["_registry"]["system_config"]["debug"]["classloads"])
    echo '<p class="debug_msg" style="color:orange;"><b>Try to load class: '.$classpath.'</b></p>';
    if (file_exists($classpath)){
        include_once($classpath);
        if ($_SESSION["_registry"]["system_config"]["debug"]["debug_mode"] && $_SESSION["_registry"]["system_config"]["debug"]["classloads"])
        echo '<p class="debug_msg" style="color:green;"><b>'.$class.' loaded</b></p>';
    }
    else{
        echo '<p class="debug_msg" style="color:red;"><b>CAN NOT LOAD CLASS '.$classpath.'. FILE NOT FOUND </b></p>';
    }
});


$registry = registry::getInstance();



if (isset($REGISTRY["lang"]["language"]["shortname"])) {
    $language = $REGISTRY["lang"]["language"]["shortname"];
}  else {
    $language = "de";
} 

if($_GET["reset"]){
        $registry->reset();
}

if($_SESSION["_registry"]["section"] == "backend"){
        $root = str_replace ('/admin/includes', '', pathinfo(__FILE__,PATHINFO_DIRNAME));
        unset ($_SESSION["_registry"]["lang"]);
        $registry->lang = parse_ini_file("$root/localisation/de.ini", TRUE);
        unset ($_SESSION["_registry"]["section"]);
        $registry->section = "frontend";
}

if($_POST["logout"]){
        unset($_SESSION["_registry"]["user"]);
}


if (empty($_SESSION["_registry"])){
        $root = str_replace ('/includes', '', pathinfo(__FILE__,PATHINFO_DIRNAME));
	if ($handle = opendir($root.'/admin/config')) {
		while (false !== ($file = readdir($handle))) {
			if (preg_match("/.*\.ini/", $file, $hit)) {
                                $name = preg_replace('/\.ini/', '', $hit[0]);
                                $registry->$name  = parse_ini_file($root."/admin/config/".$file, TRUE);
			}
		}
		closedir($handle);
	} 
        $registry->lang = parse_ini_file($root."/localisation/de.ini", TRUE);
        $registry->root = $root;
		$registry->section = "frontend";
}


error_reporting(0);
ini_set('display_errors', 0);
unset ($_SESSION["_registry"]["db"]);
$registry->db = new db();
unset ($_SESSION["_registry"]["time"]);
$registry->time = new time();
$REGISTRY = $_SESSION["_registry"];
$LANG = $REGISTRY["lang"];
$DEBUG = $REGISTRY["system_config"]["debug"];
$DIR_ROOT = $REGISTRY["root"];
$DB = $REGISTRY["db"];


if( $_SERVER["REQUEST_URI"] == '/' ){
    header("location:/de/");
}


$recent_url = str_replace('www.', '', $_SERVER["HTTP_HOST"]);
$protocol = 'https';
if($_SERVER['HTTPS'] && $_SERVER['HTTPS']=='on'){
	$protocol = 'https';	
}
$URL_ROOT = $protocol.'://'.$_SERVER["HTTP_HOST"].'/';
$_SESSION["_registry"]["system_config"]["site"]["base_url"] = $URL_ROOT;




//$PATH_ARR = array();
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


// This LANG code
// $url_arr = explode('/',trim($_SERVER["REQUEST_URI"],'/'));

// if($_SERVER['QUERY_STRING'] =='logout') {
//     unset($_SESSION['session_user_id']);
//     header("location:/");
// }

// $lang_id = $_SESSION['lang_id'] ? $_SESSION['lang_id'] : 1;
// $language = $lang_id == 1 ? 'de' : 'en';


include 'functions.php';

// $PATH_ARR = generate_path_arr();


// if(isset($_GET['url'])) {
//     $path = explode('/', trim($_GET['url'], '/'));
//     $page_id = $PATH_ARR[implode('/', $path)];
// } else {
//     $path = false;
//     $page_id = 1;
//     $hierarchy = false;
// }
 
// $page = get_page($page_id); 

// echo '<pre>'; var_dump($page); echo '</pre>';