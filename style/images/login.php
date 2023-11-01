<?php 
require("../includes/general.inc.php");
if($_POST['action']=='login'){
	$login=$_POST['data'][0]['value'];
	$pswd=$_POST['data'][1]['value'];
	if($login && $pswd){
		$ean1='2000000'.$login;
		$ean2='2000000'.$login.'2';
		$user = $DB->query_fetch('SELECT * FROM `customers` WHERE (`ean`="'.mysql_escape_string($login).'" OR `ean`="'.mysql_escape_string($ean1).'" OR `ean`="'.mysql_escape_string($ean2).'") AND `pswd`="'.mysql_escape_string($pswd).'" LIMIT 1');
		if($user && is_array($user) && !empty($user)){
	         $_SESSION['customer_id'] = $user['id']; 
	         $_SESSION['customer'] = $user;
	         echo '1';
		}else{
			$user = $DB->query_fetch('SELECT * FROM `customers` WHERE `ean`="'.mysql_escape_string($login).'" OR `ean`="'.mysql_escape_string($ean1).'" OR `ean`="'.mysql_escape_string($ean2).'" OR `pswd`="'.mysql_escape_string($pswd).'" LIMIT 1');
			if($user && is_array($user) && !empty($user)){
		         if($user['ean']!=$login)
		         	echo '2';
		         if($user['pswd']!=$pswd)
		         	echo '3';
			}else{
				echo '0';
			}
		}
	}else{
		echo '0';
	}
}
?>