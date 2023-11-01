<?php require ("../../includes/general.inc.php"); 
 
$perm_class = new permissions();
$entity = $DB->query_fetch_single("SELECT name FROM permissions_entity WHERE `id` = ".$_GET["id"].";");
$type = $DB->query_fetch_single("SELECT type FROM permissions_entity WHERE name = '$entity' LIMIT 1;");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript"> var URL_ROOT = 'http://www.frowein808.de//admin/';</script>
        <title>Morgana Mac4</title>
                <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script> 
            </head>

    <body>
		<div  style="overflow:auto; height:100%;"> 
		<h3>Berechtigungen</h3>
		<p><b>Bitte setzen sie die gewünschten Berechtigungen und bestätigen sie diese</b></p>
<?php 
function generate_view($permissions,$names){
	global $perm_class, $entity, $LANG;
	foreach ($permissions as $name => $permission){
			if ($permission["main"] == "backend" || $permission["main"] == "permissions") continue; 
			echo '<fieldset id="'.$name.'"><legend><a id="perm_vis_'.$name.'" href="javascript:switch_perm_vis(\''.$name.'\')" style="font-size:14px; color:red; text-decoration:none;">+</a>&nbsp;&nbsp;&nbsp;
						<input class="main_perm_box" type="checkbox" name="perm['.$permission["main"].']" value="1"'; if ($perm_class->hasUserPermission($permission["main"].'.*', $entity)) echo 'checked="checked"'; if ($perm_class->hasParentPermission($permission["main"].'.*', $entity)) echo 'checked="checked" disabled="disabled"'; echo' />&nbsp;&nbsp;'.$names[$name].'</legend>
						<div id="perm_content_'.$name.'" class="perm_content" style="display:none;">
			';
			foreach ($permission as $name_2 => $permission_entity){
				if(!is_array($permission_entity) && $name_2 != "main"){
					echo '<input class="perm_box" type="checkbox" name="perm['.$permission_entity.']" value="1" '; if ($perm_class->hasUserPermission($permission_entity, $entity)) echo 'checked="checked"'; if ($perm_class->hasParentPermission($permission_entity, $entity)) echo 'checked="checked" disabled="disabled"'; echo' />&nbsp;&nbsp;'.$LANG["backend"][$name_2].'&nbsp;&nbsp;&nbsp;&nbsp;
					';
				}
				else if($name_2 != "main"){
					generate_view(array($name_2=>$permission_entity),$names);
				}
			}
			echo '		</div>
					</fieldset>
			';
	}
}
function generate_set($permissions,$_permissions){
$set_permissions = array();
	foreach ($permissions as $name => $permission){
			//echo $permission["main"].'------'.$_permissions[$permission["main"]]."<br>\n";
			if($_permissions[$permission["main"]]) $set_permissions[] = $permission["main"]."*";
			else{
				foreach ($permission as $name_2 => $permission_entity){
						//print_r($permission_entity);echo "<br>";
						if (!in_array($permission["main"],$set_permissions)) $set_permissions[] = $permission["main"];
						if(is_array($permission_entity)) $set_permissions = array_merge($set_permissions, generate_set(array($name_2=>$permission_entity),$_permissions));
						else if($_permissions[$permission_entity]) $set_permissions[] = $permission_entity;
				}
			}
	}
	//print_r($set_permissions);
	return $set_permissions;
}
$permissions = array();
$permissions['backend']['main'] = 'backend';
if ($handle = opendir($DIR_ROOT."/admin/modules")) {
    while (false !== ($file = readdir($handle))) {
		if (preg_match("/^\.{1,2}$/i",$file)) continue;
		$permissions[$file] = parse_ini_file($DIR_ROOT."/admin/modules/".$file."/permissions.ini",TRUE);
		unset($names_temp); 
		$names_temp = parse_ini_file($DIR_ROOT."/admin/modules/".$file."/modul.ini",TRUE);
		unset($subs);
		$subs = $names_temp["subs"];
		$names[$names_temp["name"]] = $names_temp["display_name_de"];
		//echo $names_temp["name"].': '.$names[$names_temp["name"]]."<br>";
		if (isset($subs)){
		foreach ($subs as $sub){
			unset($names_temp); 
			//echo "modules/".$file."/".$sub."/modul.ini<br>";
			$names_temp = parse_ini_file($DIR_ROOT."/admin/modules/".$file."/".$sub."/modul.ini",TRUE);
			$names[$names_temp["name"]] = $names_temp["display_name_de"];
		}
		}
    }
    closedir($handle);
}
if(isset($_POST["set_perm"])){
	//print_r($_POST);
	$_permissions = $_POST["perm"];
	$set_permissions = generate_set($permissions,$_permissions);	
	$DB->query("DELETE FROM `permissions` WHERE `name` = '$entity' AND value = '' AND type=$type;");
	if(isset($_POST["perm"])){
		$query = "INSERT INTO `permissions` (`id` ,`name` ,`type` ,`permission` ,`world` ,`value`)VALUES ";
		$first = true;
		foreach ($set_permissions as $set_permission){
			if (!$perm_class->hasParentPermission($set_permission, $entity)){
				if (!$first) $query .=',';
				$query .= "(NULL , '$entity', '$type', '$set_permission', '', '')";
				$first = false;
			}
		}
		$query .= ";";
		$DB->query($query);
	}
	echo '<script type="text/javascript">parent.Shadowbox.close(); </script>';
}
//print_r($user_permissions);
//print_r ($set_permissions);
//print_r($names);
echo '
<form action="" method="post" name="perm_form">';
?>
		<fieldset id="allgemein"><legend><a id="perm_vis_allgemein" href="javascript:switch_perm_vis('allgemein')" style="font-size:14px; color:red; text-decoration:none;">+</a>&nbsp;&nbsp;System</legend>
			<div id="perm_content_allgemein" class="perm_content" style="display:none;">
				<input class="perm_box" type="checkbox" name="perm[backend]" value="1" <?php if ($perm_class->hasUserPermission("backend", $entity)) echo 'checked="checked"'; if ($perm_class->hasParentPermission("backend", $entity)) echo 'checked="checked" disabled="disabled"'; ?> />&nbsp;&nbsp;Backend
			</div>
		</fieldset>
<?php
generate_view($permissions,$names);
echo '
	<input type="submit" name="set_perm" value="setzen">
</form>';
?>
<script type="text/javascript">
	$('.main_perm_box').click(function(){
		var main_field = $(this).parent().parent().parent().parent();
		var parent_field = $(this).parent().parent();
		$('#'+parent_field.attr("id") + ' .main_perm_box,#'+parent_field.attr("id") + ' .perm_box').prop("checked",$(this).prop("checked"));
		if ($(this).prop("checked") == false){
			if(main_field) $("#"+main_field.attr("id")+">legend>input").prop("checked",false);
			if(parent_field) $("#"+parent_field.attr("id")+">legend>input").prop("checked",false);
		}		
		else{
			var main_set = true;
			$('#'+main_field.attr("id") + ' .main_perm_box').each(function(i){
				if($(this).prop("checked") == false && i > 0) main_set = false;
			});
			$("#"+main_field.attr("id")+">legend>input").prop("checked",main_set);
		}
	})
	
	$('.perm_box').click(function(){
		var parent_field = $(this).parent().parent();
		var main_field = parent_field.parent().parent();
		if ($(this).prop("checked") == false){
			if(parent_field) $("#"+parent_field.attr("id")+">legend>input").prop("checked",false);
			if(main_field) $("#"+main_field.attr("id")+">legend>input").prop("checked",false);
		}
		else{
			var parent_set = true;
			$('#'+parent_field.attr("id") + ' .perm_box').each(function(i){
				if($(this).prop("checked") == false) parent_set = false;
			});
			$("#"+parent_field.attr("id")+">legend>input").prop("checked",parent_set);
			var main_set = true;
			$('#'+main_field.attr("id") + ' .main_perm_box').each(function(i){
				if($(this).prop("checked") == false && i > 0) main_set = false;
			});
			$("#"+main_field.attr("id")+">legend>input").prop("checked",main_set);
		}
	})
	
	function switch_perm_vis(name){
		var box = $('#perm_content_'+ name);
		var switcher = $('#perm_vis_'+ name);
		if (box.css("display") == "none"){
			box.show();
			switcher.html("-");
		}
		else{
			box.hide();
			switcher.html("+");
		}
	}
</script>
</div>
</body>
</html>