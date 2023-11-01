<?php
error_reporting(0);
function __autoload($class)
{
    $classpath = pathinfo(__FILE__,PATHINFO_DIRNAME).'/classes/'.$class.'.class.php';
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
}

function get_installed_modules($path,$installedModules = FALSE,$submodules = FALSE){
    global $URL_ROOT;
    global $DIR_ROOT;
    global $permissions;
    //var_dump($installedModules);
    if ($installedModules){ 
        if ($handle = opendir($DIR_ROOT."/admin/modules/".$path)){
            while (false !== ($file = readdir($handle))) {
                if (preg_match("^\.{1,2}^",$file)) continue;
                if (is_dir($DIR_ROOT."/admin/modules/".$path."/".$file) && isset($installedModules[$file]) && $installedModules[$file]) {
                    $modules_temp = parse_ini_file($DIR_ROOT."/admin/modules/".$path."/".$file."/modul.ini",TRUE);
                    if ($permissions->hasPermission($modules_temp["permission"])){
                        $modules[$file] = $modules_temp;
                        $modules[$file]["url"] = $URL_ROOT."admin".$path."/".$file."/";
                        $modules[$file]["path"] = $path."/".$file."/";
                        if(isset($modules[$file]["subs"])){
                            $modules[$file]["subs"] = get_installed_modules($path."/".$file,FALSE,$modules[$file]["subs"]);
                        }
                    }
                }
            }
        }
    }

    else{
    	//var_dump($submodules);
        foreach($submodules as $sub){
        	
        	
            if (is_dir($DIR_ROOT."/admin/modules/".$path."/".$sub)) {
                $modules_temp = parse_ini_file($DIR_ROOT."/admin/modules/".$path."/".$sub."/modul.ini",TRUE);
                if ($permissions->hasPermission($modules_temp["permission"])){
                    $modules[$sub] = $modules_temp;
                    $modules[$sub] = parse_ini_file($DIR_ROOT."/admin/modules/".$path."/".$sub."/modul.ini",TRUE);
                    $modules[$sub]["url"] = $URL_ROOT."admin".$path."/".$sub."/";
                    $modules[$sub]["path"] = $path."/".$sub."/";
                    if(isset($modules[$sub]["subs"])){
                        $modules[$sub]["subs"] = get_installed_modules($path."/".$sub);
                    }
                }
            }
        }
    }
    return $modules;
}

function make_list($modules,$active_module, $parent = FALSE){
    global $URL_ROOT;
    global $REGISTRY;
    foreach ($modules as $key => $modul){
		
		$modul_name = $modul["name"];
		
        $is_active = FALSE;
        foreach ($active_module as $active){
            if ($active == $modul["name"]) $is_active = TRUE;
        }
               
        $html .= '
            <p  style="float:left;" id="'.$modul_name.'" class="btn btn-primary no-radius modul_nav  '.$modul["type"];
        if ($parent) $html.=" sub ".$parent;
        if ($is_active) $html .= ' active_modul active';
        $html .= '" ';
        if ($modul["type"] != "navigation") $html .= 'file="'.$modul["url"].'"';
        $html .= '>';

        $html .= "<font>".$modul["display_name_".$REGISTRY["lang"]["language"]["shortname"]].'</font></p><div style="clear:both;"></div>';
        if (isset($modul["subs"])){
            $html .= make_list($modul["subs"],$active_module, $modul["name"]);
        }
    }
    return $html;
}

$registry = registry::getInstance();

if($_GET["reset"]){
        $registry->reset();
}

if($_SESSION["_registry"]["section"] == "frontend"){
		$root = str_replace ('/admin/includes', '', pathinfo(__FILE__,PATHINFO_DIRNAME));
		unset ($_SESSION["_registry"]["lang"]);
        $registry->lang = parse_ini_file("$root/admin/localisation/de.ini", TRUE);
		unset ($_SESSION["_registry"]["section"]);
		$registry->section = "backend";
}



if($_POST["logout"]){
        unset($_SESSION["_registry"]["user"]);
}

if (empty($_SESSION["_registry"])){
        $root = str_replace ('/admin/includes', '', pathinfo(__FILE__,PATHINFO_DIRNAME));
	if ($handle = opendir($root.'/admin/config')) {
		while (false !== ($file = readdir($handle))) {
			if (preg_match("/.*\.ini/", $file, $hit)) {
                                $name = preg_replace('/\.ini/', '', $hit[0]);
                                $registry->$name  = parse_ini_file($root."/admin/config/".$file, TRUE);
			}
		}
		closedir($handle);
	}
        
        $registry->lang = parse_ini_file($root."/admin/localisation/de.ini", TRUE);
        $registry->root = $root;
		$registry->section = "backend";
}
unset ($_SESSION["_registry"]["db"]);
$registry->db = new db();
$registry->section = "admin";
unset ($_SESSION["_registry"]["time"]);
$registry->time = new time();
$REGISTRY = $_SESSION["_registry"];
$LANG = $REGISTRY["lang"];

$DEBUG = $REGISTRY["system_config"]["debug"];
$DIR_ROOT = $REGISTRY["root"];
$DB = $REGISTRY["db"];
$recent_url= str_replace('www.', '', $_SERVER["HTTP_HOST"]);


$URL_ROOT = $_SESSION["_registry"]["system_config"]["site"]["base_url"];
error_reporting(1);
ini_set('display_errors',1);
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

if(isset($_SESSION["_registry"]["user"])){
    $permissions = new permissions();
    $installedModules = $DB->select_pair("modules","name","active","order");
    $modules_temp = get_installed_modules("",$installedModules);
    foreach ($installedModules as $module_sort => $status){
        if (isset ($modules_temp[$module_sort])) 
            $modules[$module_sort] = $modules_temp[$module_sort];
    }    
    $active_module = explode("___", $_GET["module"]);
    $breacrump = '<a href="'.$URL_ROOT.'admin">Home</a>';
    $modul_temp = $modules;
    $first = TRUE;
        if (count($active_module) > 0 && isset($modul_temp[$active_module[0]]["display_name_".$REGISTRY["lang"]["language"]["shortname"]])) $breacrump .= ' &gt; <a href="'.$modul_temp[$active_module[0]]["url"].'">'.$modul_temp[$active_module[0]]["display_name_".$REGISTRY["lang"]["language"]["shortname"]].'</a>';
        if (count($active_module) == 1) $modul_temp = $modul_temp[$active_module[0]];
        else{
            foreach ($active_module as $active_modul){
            if (!$first){
                $modul_temp =  $modul_temp[$last]["subs"][$active_modul];
                $breacrump .= ' &gt; <a href="'.$modul_temp["url"].'">'.$modul_temp["display_name_".$REGISTRY["lang"]["language"]["shortname"]].'</a>';
            }
            $last = $active_modul;
            $first = FALSE;
            }
        }
    
    unset($active_modul);
    if ($modul_temp["file"] != "" && $modul_temp["path"] != ""){
        $active_modul = "modules".$modul_temp["path"].$modul_temp["file"];
        if($_GET["edit"]) $active_modul .= "_edit";
        $active_modul .= ".php";
    }
}
if(is_file( pathinfo(__FILE__,PATHINFO_DIRNAME).'/custom_functions.inc.php')) include pathinfo(__FILE__,PATHINFO_DIRNAME).'/custom_functions.inc.php';
include pathinfo(__FILE__,PATHINFO_DIRNAME).'/functions.inc.php';
?>
