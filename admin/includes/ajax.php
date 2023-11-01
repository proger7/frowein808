<?php
include 'general.inc.php';
try
    {
        $ftp = FTP::getInstance();
        $ftp->connect($_SESSION["_registry"]["ftp_config"]["self"], false, true );
    }
        catch (FTPException $error) {echo $error->getMessage();}
$base_root = $_SESSION["_registry"]["root"]."/";
function save_image($name){
                global $URL_ROOT;
                global $ftp;
                global $base_root;
                if (!is_dir($base_root."admin/tmp"))  {
					$ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/");
					$ftp->makeDir("tmp");
					$ftp->chmod("tmp",0770);
				}
                if ($_FILES[$name]['tmp_name'] != ""){
                    if(preg_match("/image/i", $_FILES[$name]['type'])){
                        if(preg_match('/(jpg|jpeg)$/i', $_FILES[$name]['type'])){
                            $ext = ".jpg";
                            $type = ImageEditor::JPG;
                        }
                        elseif(preg_match('/(png)$/i', $_FILES[$name]['type'])){
                            $ext = ".png";
                            $type = ImageEditor::PNG;
                        }
                        elseif(preg_match('/(gif)$/i', $_FILES[$name]['type'])){
                            $ext = ".gif";
                            $type = ImageEditor::GIF;
                        }
                        $time = microtime(true) * 100 ;
                        move_uploaded_file($_FILES[$name]['tmp_name'],$base_root."admin/tmp/".$time.$ext);
                        $ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
                        $ftp->upload($base_root."admin/tmp/".$time.$ext,  $time.$ext, 'auto', 0 );
						
                        /*$ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/");
                        $ftp->removeDir("tmp","1");*/
						//echo $URL_ROOT."/uploads/".$time.$ext;;
						
						$ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/tmp/");
						$ftp->delete($base_root."admin/tmp/".$time.".tmp");

                        return $URL_ROOT."/uploads/".$time.$ext;
                        }
                    else{
                        return false;
                    }
                }
} 
error_reporting(0);
if($_POST["action"] == "gen_pass"){
     function CreatePassword($length = 7, $capitals = true, $specialSigns = true)
  {
    $array = array();


    if($length < 8)
      $length = mt_rand(8,20);

    # Zahlen
    for($i=48;$i<58;$i++)
      $array[] = chr($i);

    # kleine Buchstaben
    for($i=97;$i<122;$i++)
      $array[] = chr($i);

    # Großbuchstaben
    if($capitals )
      for($i=65;$i<90;$i++)
        $array[] = chr($i);

    # Sonderzeichen:
    if($specialSigns)
    {
      for($i=33;$i<47;$i++)
        $array[] = chr($i);
      for($i=59;$i<64;$i++)
        $array[] = chr($i);
      for($i=91;$i<96;$i++)
        $array[] = chr($i);
      for($i=123;$i<126;$i++)
        $array[] = chr($i);
    }

    mt_srand((double)microtime()*1000000);
    $passwort = '';

    for ($i=1; $i<=$length; $i++)
    {
      $rnd = mt_rand( 0, count($array)-1 );
      $passwort .= $array[$rnd];
    }

    echo $passwort;
    exit;
  }
}
else if($_POST["action"] == "change_order"){
    $old_position = $DB->query_fetch_single("SELECT `order` FROM ".$_POST["table"]." WHERE id=".$_POST["id"]." LIMIT 1");
    if($_POST["value"] < $old_position){
        $DB->query("UPDATE `".$_POST["table"]."` SET `order` = `order`+1 WHERE `order` BETWEEN ".$_POST["value"]." AND $old_position - 1;");
        $DB->query("UPDATE `".$_POST["table"]."` SET `order` = ".$_POST["value"]." WHERE `ID` = ".$_POST["id"]." LIMIT 1;");
    }
    else if ($_POST["value"] > $old_position){
        $DB->query("UPDATE `".$_POST["table"]."` SET `order` = `order`-1 WHERE `order` BETWEEN ".$_POST["value"] ." AND $old_position + 1;");
        $DB->query("UPDATE `".$_POST["table"]."` SET `order` = ".$_POST["value"]." WHERE `ID` = ".$_POST["id"]." LIMIT 1;");
    }
}
else if($_POST["action"] == "change_order_parent"){
    $values = split(',',$_POST["value"]);
    $old_position = $DB->query_fetch_single("SELECT `order` FROM ".$_POST["table"]." WHERE id=".$_POST["id"]." LIMIT 1");
    if($_POST["value"] < $old_position){
        $DB->query("UPDATE `".$_POST["table"]."` SET `order` = `order`+1 WHERE (`order` BETWEEN ".$values[0]." AND $old_position - 1) AND parent = ".$values[1].";");
        $DB->query("UPDATE `".$_POST["table"]."` SET `order` = ".$values[0]." WHERE `ID` = ".$_POST["id"]." LIMIT 1;");
    }
    else if ($_POST["value"] > $old_position){
        $DB->query("UPDATE `".$_POST["table"]."` SET `order` = `order`-1 WHERE (`order` BETWEEN ".$values[0] ." AND $old_position + 1) AND parent = ".$values[1].";");
        $DB->query("UPDATE `".$_POST["table"]."` SET `order` = ".$values[0]." WHERE `ID` = ".$_POST["id"]." LIMIT 1;");
    }
}
elseif($_POST["action"]=="change_order_total_lang"){
	$str = str_replace(array('tableListing[]=','id_'),'',$_POST['value']);
	$ordered_array = explode('&',$str);
	foreach($ordered_array as $k=>$id){
		if(is_numeric($id)){
			$DB->query("UPDATE `".$_POST["table"]."` SET `order` = ".$k." WHERE `id` = ".$id." LIMIT 1;");
			$DB->query("UPDATE `".$_POST["table"]."` SET `order` = ".$k." WHERE `lang_id` <> '1' AND `rel_id` = ".$id." LIMIT 1;");
		}
	}
}elseif($_POST["action"]=="change_order_total"){
	$str = str_replace(array('tableListing[]=','id_'),'',$_POST['value']);
	$ordered_array = explode('&',$str);
	foreach($ordered_array as $k=>$id){
		if(is_numeric($id)){
			$DB->query("UPDATE `".$_POST["table"]."` SET `order` = ".$k." WHERE `id` = ".$id." LIMIT 1;");
		}
	}

}else if($_POST["action"] == "change_order_tree"){
	$values = split(',',$_POST["value"]);
	$old_position = $DB->query_fetch_single("SELECT `order` FROM ".$_POST["table"]." WHERE id=".$_POST["id"]." LIMIT 1");//21
	if(is_numeric($values[0])){
		if($values[0] < $old_position){
			$DB->query("UPDATE `".$_POST["table"]."` SET `order` = `order`+1 WHERE `order` >= $values[0] ;");
			$DB->query("UPDATE `".$_POST["table"]."` SET `order` = ".$values[0]." WHERE `id` = ".$_POST["id"]." LIMIT 1;");
		}
		else if ($values[0] > $old_position){
			$DB->query("UPDATE `".$_POST["table"]."` SET `order` = `order`-1 WHERE `order` <= $values[0] ;");
			$DB->query("UPDATE `".$_POST["table"]."` SET `order` = ".$values[0]." WHERE `id` = ".$_POST["id"]." LIMIT 1;");
		}
	}
}

else if($_POST["action"] == "delete"){
    delete($_POST["table"],$_POST["id"]);
}
else if($_POST["action"] == "delete_entity"){
        $entity = $_POST["id"];
        $query ="DELETE FROM permissions WHERE name = '".$entity."'";
        $DB->query($query);
        $result .= $query.'
        ';
        $query ="DELETE FROM permissions_entity WHERE name = '".$entity."';";
        $DB->query($query);
        $result .= $query.'
        ';
        $query ="DELETE FROM permissions_inheritance WHERE child = '".$entity."' OR parent = '".$entity."';";
        $DB->query($query);
        $result .= $query.'
        ';
        echo $result;
}
else if($_POST["action"] == "change_status"){
    $DB->query("UPDATE ".$_POST["table"]." set `status` = ".$_POST["value"] ." WHERE id=".$_POST["id"]." LIMIT 1;");
}
else if($_POST["action"] == "change_status_coupon"){
    $shops = $DB->select("SELECT * FROM oc_stock");
    foreach($shops as $shop){
        $shop_arr[] = $shop['kasse_shop_id'];
    }
    if($_POST["value"] == 1) {
        $row = $DB->query_fetch("SELECT * FROM coupons WHERE id=" . $_POST["id"]);

        $api_query = $DB->query_fetch("SELECT * FROM konnektor WHERE name='Kasse'");
        $apiKey = $api_query['secret_key'];
        $mainUrl = 'https://'.$api_query['domain'].'/api/';

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, $mainUrl . 'login');
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST, false);
        $dataString = ['secret_key' => $apiKey];
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $dataString);
        $result = curl_exec($cURL);
        curl_close($cURL);

        $result = json_decode($result, TRUE);
        if (!empty($result['token'])) {
            $token = $result['token'];

            $filter = '';
            //$filter = '/filter/from_datetime=2019-03-13+12%3A14%3A33/status=1';

            //$url = $mainUrl . 'products/is_expired/0&token=' . $token;
            $url = $mainUrl . 'discounts';
            $data =
                [
                    $_POST["id"] => //konnektorid
                        [
                            'name' => $row['name'],
                            'discount_type_id' => 10,
                            'date_start' => $row['start_date'],
                            'date_finish' => $row['end_date'],
                            'val' => (int)$row['discount'],//in %
                            'bonus_ids' => $row['kasse_id'],//kassen good ids, coma as separator
                            'shops_ids' => implode(',', $shop_arr),//all shop ids, can't be empty, coma as separator
                            'action_code' => $row['action_code'],
                        ]
                ];

            $dataString = ['data' => json_encode($data), 'token' => $token];

            $cURL = curl_init();
            curl_setopt($cURL, CURLOPT_URL, $url);

            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST, false);

            curl_setopt($cURL, CURLOPT_POSTFIELDS, $dataString);

            $result = curl_exec($cURL);
            curl_close($cURL);
            //  var_dump($result);
            $result = json_decode($result, TRUE);
               var_dump($result);
        }
    }
    $DB->query("UPDATE ".$_POST["table"]." set `status` = ".$_POST["value"] ." WHERE id=".$_POST["id"]." LIMIT 1;");
}
elseif($_POST["action"] == "change_switch"){
	$DB->query("UPDATE ".$_POST["table"]." SET `".$_POST["value"]."` = IF(`".$_POST["value"]."`='0','1','0') WHERE id=".$_POST["id"]." LIMIT 1;");
}
else if($_POST["action"] == "change_entity_status"){
    if($DB->affected_query("SELECT id FROM permissions WHERE permission = 'status' AND name = '".$_POST["id"]."' LIMIT 1;"))
    $DB->query("UPDATE permissions set `value` = ".$_POST["value"] ." WHERE permission = 'status' AND name = '".$_POST["id"]."' LIMIT 1;");
    else
    $DB->query("INSERT INTO permissions (
                `name` ,
                `type` ,
                `permission` ,
                `value`
             )
            VALUES (
                '".$_POST["id"]."', '1', 'status', '".$_POST["value"] ."'
            );");
}
else if($_POST["action"] == "delete_mass"){


      echo  $DB->query("DELETE FROM ".$_POST['table']." WHERE id=".$_POST["to_del"]." LIMIT 1;");
}
else if($_POST['fromPosition']){
	$ordersfrom = $DB->query_fetch_single("SELECT COUNT(`id`) as cnt FROM ".$_GET["table"]." WHERE `order`=".$_POST["fromPosition"]." ");
	$ordersto = $DB->query_fetch_single("SELECT COUNT(`id`) as cnt FROM ".$_GET["table"]." WHERE `order`=".$_POST["toPosition"]." ");
	if($ordersfrom > 1 || $orderstp > 1 || $_POST["fromPosition"] == $_POST["toPosition"] ){
		$sels = $DB->select("SELECT `id` FROM ".$_GET["table"]." ORDER BY `order`");
		foreach($sels as $k=>$selid){
			$DB->query("UPDATE ".$_GET["table"]." set `order` = ".$k ." WHERE `id`=".$selid['id']." LIMIT 1;");
		}
	}else{
		$DB->query("UPDATE ".$_GET["table"]." set `order` = ".$_POST["fromPosition"] ." WHERE `order`=".$_POST["toPosition"]." LIMIT 1;");
		$DB->query("UPDATE ".$_GET["table"]." set `order` = ".$_POST["toPosition"] ." WHERE id=".$_POST["id"]." LIMIT 1;");
	}
}

function delete($table,$id){
    global $DB;
    echo("DELETE FROM $table WHERE id=$id LIMIT 1;");
    $DB->query("DELETE FROM $table WHERE id=$id LIMIT 1;");
}
?>