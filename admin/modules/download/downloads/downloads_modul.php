
<style>
    th.sorting_disabled {
        width: 150px!important;
    }
    #tableListing th:nth-child(4){
        max-width:100px!important;
        width:100px!important
    }
    #tableListing th:nth-child(1){
        max-width:7px!important;
        width:7px!important
    }
</style>
<?php

include_once 'includes/classes/modul.class.php';
class downloads_modul extends modul{   
    function __construct(){
        $this->init();
        $this->path             = pathinfo(__FILE__,PATHINFO_DIRNAME)."/";
        $this->lang["module"]   = parse_ini_file( $this->path."localisation/de.ini");
        $this->table            = "download_text";
		$this->config			= parse_ini_file( $this->path."modul.ini");
		$this->permission		= $this->config["permission"];
    }
    public function showEntity($id,$fields,$table = FALSE){
        global $FORM_COUNT,$rules;
        $isnew=false;
        if (!$table) $table = $this->table;
        if (isset($_POST["save_btn".$FORM_COUNT])) {
            $rez = $this->saveEntity($id, $fields, $table);
            if($rez!=true)
                echo '<script>window.location = "'.$_SESSION["_registry"]["variables"]["backlink"].'?edit='.$id.'";</script>';
        }
        if (isset($_POST["saveback".$FORM_COUNT])) {
            $rez = $this->saveEntity($id, $fields, $table);
            /*if($rez!=true)*/
            echo '<script>window.location = "'.$_SESSION["_registry"]["variables"]["backlink"].'";</script>';
        }
        else if (isset($_POST["reload"])) echo '<script>window.location = "'.$_SESSION["_registry"]["variables"]["backlink"].'";</script>';
        else if (isset($_GET["e_copy"])) {
            $id = $this->copyEntity($id,$fields,$table);
        }
        else if (isset($_POST["delete_img".$FORM_COUNT])){
            foreach ($_POST["delete_img".$FORM_COUNT] as $image => $even){
                $this->delete_image($id,array(2 => $image), $table);
            }
        }
        else if (isset($_POST["delete_file".$FORM_COUNT])){
            foreach ($_POST["delete_file".$FORM_COUNT] as $file => $even){
                $this->delete_file($id,array(2 => $file), $table);
            }
        }
        else if ($id == "none") {
            $id = $this->newEntity($fields, $table);
            $isnew = true;
        }
        if ($fields){
            $entity = $this->getEntity($id, $fields, $table);
            $html = '<form enctype="multipart/form-data" action="?edit='.$id.'" method="post" id="edit_form'.$FORM_COUNT.'" name="edit_form'.$FORM_COUNT.'" >
                   ';
            foreach($fields as $field){
                if($field[2] == "key_account_ids") continue;
                if ($field[0] != "Input") {
                    $call = "getEditField"."_".$field[0];
                    $fieldData = $this->$call($id,$field,$entity,$isnew);
                }
                else {
                    if($isnew==false && $field[3]){
                        $this->gen_valid_rule($field[3],$field[2]);
                    }
                    $fieldData = '<input type="text" class="form-control" name="save['.$field[2].']" class="inp_text" value=\''.htmlspecialchars ($entity[$field[2]],ENT_QUOTES,"UTF-8").'\' />';
                }
                $html .='<div class="clearfix"></div>
					<div class="col-lg-12">
						<label>'.$field[1].'</label>
						<div class="form-group">
							'.$fieldData.'
						</div>
					</div>	';
            }
        }
        $key_arr = array();
        if($entity['key_account_ids'] !=''){
            $key_arr = explode(',', $entity['key_account_ids']);
        }
        $keys = $this->db->select("SELECT * FROM key_accounts WHERE status=1");
        if(!empty($keys)){
            $html .='
<div class="clearfix"></div>
<!--
<label>Key-Accounts</label>-->';
            /*
            foreach($keys as $k){
                if(in_array($k['id'], $key_arr))
                    $html .='<div class="col-lg-12"><input type="checkbox" name="key_acc[]" checked value="'.$k['id'].'"> '.$k['title'].'</div>';
                else
                    $html .='<div class="col-lg-12"><input type="checkbox" name="key_acc[]" value="'.$k['id'].'"> '.$k['title'].'</div>';
            }
            */
            $html .='';
        }
        $html .= '<div class="col-lg-12 text-right bottom-buttons">';
        if ($this->permissions->hasPermission($this->permission.".edit")) $html.='
                            <input type="submit" name="save_btn'.$FORM_COUNT.'" id="button_save'.$FORM_COUNT.'" value="'.$_SESSION["_registry"]["lang"]["backend"]["save_btn"].'" class="btn btn-primary" />
                            <input type="submit" name="saveback'.$FORM_COUNT.'" value="'.$_SESSION["_registry"]["lang"]["backend"]["save_exit_btn"].'" class="btn btn-primary" />';
        $html .= '
                            <input type="submit" id="cancel_button" name="cancel" value="'.$_SESSION["_registry"]["lang"]["backend"]["cancel_btn"].'" back="'.$_SESSION["_registry"]["variables"]["backlink"].'" class="btn" />
                  </div>
                    </form>';
        $FORM_COUNT++;
        return $html;
    }

    public function saveEntity($id, $fields=FALSE, $table = FALSE){
        if (!$table) $table = $this->table;
        if(isset($_POST['key_acc'])){
            $key_str = ', key_account_ids="'.implode(',', $_POST['key_acc']).'"';
        }
        $query = "UPDATE ".$table." SET ";
        if ($fields){
            $first = TRUE;
            foreach($fields as $field){
                if ($field[0] == "Image"){
                    $image = $this->save_image($id,$field, $table);
                    if ($image){if (!$first) $query .= ", ";
                        $query .= "`".$field[2]."` = '".$image."'";}
                }
                else if($field[0] == "File"){
                    $file = $this->save_file($id,$field, $table);
                    if ($file){if (!$first) $query .= ", ";
                        $query .= "`".$field[2]."` = '".$file."'";}
                }
                else if($field[0] == "DateRange"){
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".$_POST["save"][$field[2]]."', `".$field[3]."` = '".$_POST["save"][$field[3]]."'";
                }
                else if($field[0] == "InputsRelation"){
                    $this->db->query("DELETE FROM ".$field[2]." WHERE ".$field[4]." = $id ;");
                    foreach($_POST["save"][$field[1]] as $item_id => $value){
                        $sub_query = "INSERT INTO `".$field[2]."` (
                                    `".$field[3]."` ,
                                    `".$field[4]."` ,
                                                                        `value`
                                )
                                VALUES (
                                    '$item_id', '$id','$value'
                                );";
                        $this->db->query($sub_query);
                    }
                }
                else if($field[0] == "BoolSelect"){
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".serialize($_POST["save"][$field[2]])."'";
                }

                else if($field[0] == "BoolSelectRelation"){
                    $this->db->query("DELETE FROM ".$field[2]." WHERE ".$field[4]." = $id ;");
                    foreach($_POST["save"][$field[1]] as $item_id){
                        $sub_query = "INSERT INTO `".$field[2]."` (
                                    `".$field[3]."` ,
                                    `".$field[4]."` 
                                )
                                VALUES (
                                    '$item_id', '$id'
                                );";
                        $this->db->query($sub_query);
                    }
                }
                else if($field[0] == "OrderedBoolSelectRelation"){
                    $this->db->query("DELETE FROM ".$field[2]." WHERE ".$field[4]." = $id ;");
                    foreach($_POST["save"][$field[1]] as $item_id){
                        $sub_query = "INSERT INTO `".$field[2]."` (
                                    `".$field[3]."` ,
                                    `".$field[4]."` ,
                                                                        `order`
                                )
                                VALUES (
                                    '$item_id', '$id', '".$_POST["order"][$field[1]][$item_id]."'
                                );";
                        $this->db->query($sub_query);
                    }
                }

                else {
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".addslashes(html_entity_decode ($_POST["save"][$field[2]],ENT_QUOTES,"UTF-8"))."'";
                }
                $first = FALSE;
            }
        }
        $query .= $key_str.' WHERE id='.$id.' LIMIT 1;';
        return $this->db->query($query);
    }

    /*
    public function saveEntity($id, $fields=FALSE, $table = FALSE){
        print_r($_POST);
        if (!$table) $table = $this->table;
		if(isset($_POST['key_acc'])){
			$key_str = ', key_account_ids="'.implode(',', $_POST['key_acc']).'"';
		}
        $query = "UPDATE ".$table." SET ";
        if ($fields){
            $first = TRUE;
            foreach($fields as $field){
                if ($field[0] == "Image"){
                    $image = $this->save_image($id,$field, $table);
                    if ($image){if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".$image."'";}
                }
                else if($field[0] == "File"){
                    $file = $this->save_file($id,$field, $table);
                    if ($file){if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".$file."'";}
                }
                else if($field[0] == "DateRange"){
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".$_POST["save"][$field[2]]."', `".$field[3]."` = '".$_POST["save"][$field[3]]."'";
                }
                else if($field[0] == "InputsRelation"){
                    $this->db->query("DELETE FROM ".$field[2]." WHERE ".$field[4]." = $id ;");
                    foreach($_POST["save"][$field[1]] as $item_id => $value){
                        $sub_query = "INSERT INTO `".$field[2]."` (
                                    `".$field[3]."` ,
                                    `".$field[4]."` ,
                                                                        `value`
                                )
                                VALUES (
                                    '$item_id', '$id','$value'
                                );";
                        $this->db->query($sub_query);
                    }
                }
                else if($field[0] == "BoolSelect"){
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".serialize($_POST["save"][$field[2]])."'";
                }

                else if($field[0] == "BoolSelectRelation"){
                    $this->db->query("DELETE FROM ".$field[2]." WHERE ".$field[4]." = $id ;");
                    foreach($_POST["save"][$field[1]] as $item_id){
                        $sub_query = "INSERT INTO `".$field[2]."` (
                                    `".$field[3]."` ,
                                    `".$field[4]."` 
                                )
                                VALUES (
                                    '$item_id', '$id'
                                );";
                        $this->db->query($sub_query);
                    }
                }
                else if($field[0] == "OrderedBoolSelectRelation"){
                    $this->db->query("DELETE FROM ".$field[2]." WHERE ".$field[4]." = $id ;");
                    foreach($_POST["save"][$field[1]] as $item_id){
                        $sub_query = "INSERT INTO `".$field[2]."` (
                                    `".$field[3]."` ,
                                    `".$field[4]."` ,
                                                                        `order`
                                )
                                VALUES (
                                    '$item_id', '$id', '".$_POST["order"][$field[1]][$item_id]."'
                                );";
                        $this->db->query($sub_query);
                    }
                }

                else {
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".addslashes(html_entity_decode ($_POST["save"][$field[2]],ENT_QUOTES,"UTF-8"))."'";
                }
                $first = FALSE;
            }
        }
        $query .= $key_str.' WHERE id='.$id.' LIMIT 1;';
        return $this->db->query($query);
    }
    */





}
?>

