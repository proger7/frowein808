<?php
include_once 'includes/classes/modul.class.php';
class user_modul extends modul{
  
    function __construct(){
        $this->init();
        $this->path             =  pathinfo(__FILE__,PATHINFO_DIRNAME)."/";
        $this->lang["module"]   =  parse_ini_file( $this->path."localisation/de.ini");
		$this->config			= parse_ini_file( $this->path."modul.ini");
		$this->permission		= $this->config["permission"];
        $this->table = "permissions";
    }
        /**
    * Liest die Tabelle aus
    *
    * @param  array  $fields Feldarray
    * @param  array  $filters Filterarray
    * @param  string  $table
    * @return array  assoziatives array der Tabelle
    */
   public function getTable ($fields=FALSE,$filters=FALSE, $table = FALSE, $lang= false){
		$search = $_GET["search"];
        $query = "SELECT id, name ";
        $query .= " FROM permissions_entity";
        $query .=" WHERE type = 1";
		        if ($search){
                $query .= " AND `name` LIKE '%".$search."%'";
        }
        $users = $this->db->select($query,MYSQLI_ASSOC, FALSE, "name");
        $query = "SELECT *  FROM permissions WHERE type = 1 AND (";
         if ($fields){
            $first = TRUE;
            foreach($fields as $field){
                if (!$first) $query .= " OR ";
                $query .= '(permission LIKE \''.$field[2].'\' AND value != "")';
                $first = FALSE;
            }
        }
        $query .= ")";
        if ($filters){
            $first = TRUE;
            foreach ($filters as $filter){
                $query .= " AND `".$filter["0"]."`".$filter["1"]."'".$filter["2"]."'";
                $first = FALSE;
            }
            if ($search){
                $query .= " AND ";
            }
            $query .= " )";
        }
        if ($search){
                $query .= " AND `name` LIKE '%".$search."%'";
        }
        $order = FALSE;
        $direction = FALSE;
        $NOORDER = TRUE;
        if (!$_REQUEST["order"]["field"] && !$NOORDER) $order = "order_id"; else $order = $_REQUEST["order"]["field"];
        if (!$_REQUEST["order"]["direction"] && !$NOORDER) $direction = "ASC"; else $direction = $_REQUEST["order"]["direction"];
        
        if ($order){
            $query .= ' ORDER BY '.$order;
        }
        if ($direction){
            $query .= ' '.$direction;
        }
        $query .= ';';
        $options = $this->db->select($query);
        foreach ($options as $value){
            $users[$value["name"]][$value["permission"]] = $value["value"];
        }
        
        $query = "SELECT * FROM permissions_inheritance WHERE type = 1 AND child LIKE '%".$search."%'";
		//echo $query;
        $groups = $this->db->select($query,MYSQLI_ASSOC, FALSE, "child");
        foreach ($groups as $key => $value){
            $users[$key]["group"] = $value["parent"];
        }
        return $users;
    }
    
     public function getEntity($id, $fields=FALSE, $table = FALSE){
        $query = "SELECT id, name ";
        $query .= " FROM permissions_entity";
        $query .=" WHERE id = '".$id."';";
        //echo $query."<br>";
        $user = $this->db->query_fetch($query,MYSQLI_ASSOC, FALSE);
         $query = "SELECT *  FROM permissions WHERE name ='".$user["name"]."' AND type = 1 AND (";
         if ($fields){
            $first = TRUE;
            foreach($fields as $field){
                if (!$first) $query .= " OR ";
                $query .= '(permission LIKE \''.$field[2].'\' AND value != "")';
                $first = FALSE;
            }
        }
        $query .= ")";
        //echo $query;
        $options = $this->db->select($query);
        foreach ($options as $value){
            $user_data[$value["permission"]] = $value["value"];
        }
        $query = "SELECT parent FROM permissions_inheritance WHERE type = 1 AND child = '".$user["name"]."' LIMIT 1;";
        $user_data["name"] = $user["name"];   
        $user_data["group"] = $this->db->query_fetch($query);
                if ($user_data["group"]["parent"] != "") $user_data["group"] = $user_data["group"]["parent"];
        else $user_data["group"] = FALSE;

        return $user_data;
    }
    public function saveEntity($id, $fields=FALSE, $table = FALSE){
        $query = "SELECT id, name ";
        $query .= " FROM permissions_entity";
        $query .=" WHERE id = '".$id."';";
        $user = $this->db->query_fetch($query,MYSQLI_ASSOC, FALSE);
        foreach ($fields as $field){
            if ($field[2] != "name" && $field[2] != "group" && $field[2] != "password") {
                $row = $this->db->query("SELECT id FROM permissions WHERE name = '".$user["name"]."' AND permission = '".$field[2]."' AND type = '1' LIMIT 1;");
                if($this->db->affected() < 1)  $query = "INSERT INTO `permissions` (`id`, `name`, `type`, `permission`, `world`, `value`) VALUES (NULL, '".$user["name"]."', '1', '".$field[2]."', '', '".addslashes($_POST["save"][$field[2]])."');";
                else                        $query = "UPDATE permissions SET value = '".addslashes($_POST["save"][$field[2]])."' WHERE name = '".$user["name"]."' AND permission = '".$field[2]."' AND type = '1' LIMIT 1;";
                $this->db->query($query);
            }
            elseif ($field[2] == "group"){
                $query = "UPDATE permissions_inheritance SET parent = '".$_POST["save"][$field[2]]."' WHERE child = '".$user["name"]."' AND type = '1' LIMIT 1;";
                $this->db->query($query);
            }            
            elseif ($field[2] == "name"){
                if ($_POST["save"][$field[2]] != $user["name"]){
                    $query = "UPDATE permissions_inheritance SET child = '".$_POST["save"][$field[2]]."' WHERE child = '".$user["name"]."';";
                    $this->db->query($query);
                    $query = "UPDATE permissions_inheritance SET parent = '".$_POST["save"][$field[2]]."' WHERE parent = '".$user["name"]."';";
                    $this->db->query($query);
                    $query = "UPDATE permissions_entity SET name = '".$_POST["save"][$field[2]]."' WHERE name = '".$user["name"]."' LIMIT 1;";
                    $this->db->query($query);
                    $query = "UPDATE permissions SET name = '".$_POST["save"][$field[2]]."' WHERE name = '".$user["name"]."';";
                    $this->db->query($query);
                    $user["name"] = $_POST["save"][$field[2]];
                }
            }
            elseif ($field[2] == "password" && $_POST["save"][$field[2]] != ""){
                $auth             =  new auth();
                $password = $auth->crypt($_POST["save"][$field[2]]);
                $row = $this->db->query("SELECT id FROM permissions WHERE name = '".$user["name"]."' AND permission = 'password' AND type = '1' LIMIT 1;");
                if($this->db->affected() < 1)  $query = "INSERT INTO `permissions` (`id`, `name`, `type`, `permission`, `world`, `value`) VALUES (NULL, '".$user["name"]."', '1', 'password', '', '".$password."');";
                else                        $query = "UPDATE permissions SET value = '".$password."' WHERE name = '".$user["name"]."' AND permission = 'password' AND type = '1' LIMIT 1;";
                $this->db->query($query);
            }
        }
    }
    
    public function deleteEntity($id, $table = FALSE){
        $query = "SELECT name ";
        $query .= " FROM permissions_entity";
        $query .=" WHERE id = '".$id."';";
        $user = $this->db->query_fetch_single($query,MYSQLI_ASSOC, FALSE);
        if (!$table) $table = $this->table;
        $return = TRUE;
        $query ="DELETE FROM permissions
                WHERE name = '".$user."' AND type = 1;";
        if (!$this->db->query($query)) $return = FALSE;
        
        $query ="DELETE FROM permissions_entity
                WHERE name = '".$user."' AND type = 1 LIMIT 1;";
        if (!$this->db->query($query)) $return = FALSE;
        
        $query ="DELETE FROM permissions_inheritance
                WHERE child = '".$user."' AND type = 1;";
        if (!$this->db->query($query)) $return = FALSE;
    }
    
    public function statusEntity($id,$to,$table = FALSE){
        $query = "SELECT id, name ";
        $query .= " FROM permissions_entity";
        $query .=" WHERE id = '".$id."';";
        $user = $this->db->query_fetch($query,MYSQLI_ASSOC, FALSE);
        $this->db->query("SELECT id FROM permissions WHERE name = '".$user["name"]."' AND permission = 'status' LIMIT 1;");
        if($this->db->affected() < 1)   
                $query = "  INSERT INTO `permissions` 
                            (`id`, `name`, `type`, `permission`, `world`, `value`) 
                            VALUES 
                            (NULL, '".$user["name"]."', '1', 'status', '', '".$to."');";
        else    $query ="   Update permissions
                            SET value = ".$to."
                            WHERE permission = 'status' AND name = '".$user["name"]."';";
        return $this->db->query($query);
    }
    
    public function getEditField_UserGroup($id,$field,$entity){
        $query = "SELECT name ";
        $query .= " FROM permissions_entity";
        $query .=" WHERE id = '".$id."';";
        $user = $this->db->query_fetch_single($query,MYSQLI_ASSOC, FALSE);
        $query = "SELECT parent FROM permissions_inheritance WHERE type = 1 AND child = '".$user."' LIMIT 1;";
        $user_group = $this->db->query_fetch($query,MYSQLI_ASSOC, FALSE);
        if ($user_group["parent"] != "") $user_group = $user_group["parent"];
        else $user_group = FALSE;
        
        $query = "SELECT * FROM permissions_entity WHERE type = 0";
        $groups = $this->db->select($query,MYSQLI_ASSOC, FALSE);
        $html = '<select name="save['.$field[2].']" class="form-control">
                    <option value="">None</option>';
        foreach ($groups as $group){
            $html .= '<option value="'.$group["name"].'" ';
                if ($user_group == $group["name"]) $html .= 'selected="selected"';
            $html .= '>'.$group["name"].'</option>';
        }
        $html .= '</select>';
        return $html;
    }
    
    public function getEditField_Password($id,$field,$entity){
        $html = '<input type="password" class="form-control" name="save['.$field[2].']" />';
        return $html;
    }
    
      public function newEntity($fields=FALSE, $table = FALSE){
        //$searches = $this->getSearch();
        $query = "INSERT INTO `permissions_inheritance` (`id`, `child`, `parent`, `type`) VALUES (NULL, 'newUser-".date('Ymdhis')."', '', '1');
                ";
        $this->db->query($query);
        $query = "INSERT INTO `permissions` (`id`, `name`, `type`, `permission`, `world`, `value`) VALUES (NULL, 'newUser-".date('Ymdhis')."', '1', 'status', '', '2');
                ";
        $this->db->query($query);
        $query = "INSERT INTO `permissions_entity` (`id`, `name`, `type`, `prefix`, `suffix`, `default`) VALUES (NULL, 'newUser-".date('Ymdhis')."', '1', '', '', '0');
                ";
        $this->db->query($query);
        return $this->db->lastindex();
    }
    
    public function showEntity($id,$fields,$table = FALSE){
    	global $FORM_COUNT;
    	$getstr='table_size='.$this->table_size.'&page='.$this->page;
    	if (!$table) $table = $this->table;
    	if (isset($_POST["save_btn".$FORM_COUNT])) {
    		$rez = $this->saveEntity($id, $fields, $table);
    		if($rez!=true)
    		echo '<script>window.location = "'.$_SESSION["_registry"]["variables"]["backlink"].'?edit='.$id.'&'.$getstr.'";</script>';
    	}
    	if (isset($_POST["saveback".$FORM_COUNT])) {
    		$rez = $this->saveEntity($id, $fields, $table);
    		/*if($rez!=true)*/
    		echo '<script>window.location = "'.$_SESSION["_registry"]["variables"]["backlink"].'?'.$getstr.'";</script>';
    	}
    	else if (isset($_POST["reload"])) echo '<script>window.location = "'.$_SESSION["_registry"]["variables"]["backlink"].'?'.$getstr.'";</script>';
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
    	else if ($id == "none") $id = $this->newEntity($fields, $table);
    	if ($fields){
    		$entity = $this->getEntity($id, $fields, $table);
    		$html = '<form enctype="multipart/form-data" action="?edit='.$id.'&'.$getstr.'" method="post" id="edit_form'.$FORM_COUNT.'" name="edit_form'.$FORM_COUNT.'" >
                        <table id="showEntity">';
    		$html .= '<tr><td colspan="2"><button onclick="open_iframe(\''.$this->base_url.'admin/modules/permissions/permissions.php?id='.$id.'\',600,600);return false;">Rechte verwalten</button></td></tr>';
    		foreach($fields as $field){
    			if ($field[0] != "Input") {
    				$call = "getEditField"."_".$field[0];
    				$fieldData = $this->$call($id,$field,$entity, 0);
    			}
    			else $fieldData = '<input type="text" name="save['.$field[2].']" class="form-control" value=\''.htmlspecialchars ($entity[$field[2]],ENT_QUOTES,"UTF-8").'\' />';
    			if ($field[0] != "Hidden")
    			$html .= '<tr><td>'.$field[1].'</td><td class="entity_field">'.$fieldData.'</td></tr>';
    			else
    			$html .= '<tr><td></td><td class="entity_field">'.$fieldData.'</td></tr>';
    		}
    	}
    	$html .= ' <tr class="btns"><td colspan="2">';
    	if ($this->permissions->hasPermission($this->permission.".edit")) $html.='
                                <input type="submit" name="save_btn'.$FORM_COUNT.'" id="button_save'.$FORM_COUNT.'" value="Speichern" class="button" />
                                <input type="submit" name="saveback'.$FORM_COUNT.'" value="Speichern und zurück" class="button" />';
    	$html .= '
                                <input type="submit" id="cancel_button" name="cancel" value="Abbrechen" back="'.$_SESSION["_registry"]["variables"]["backlink"].'" class="button" />
                       </td></tr>
                        </table>
                        </form>';
    	$FORM_COUNT++;
    	return $html;
    }
    
    
    public function getButton_Status3($row){
        if (!$this->permissions->hasPermission($this->permission.".edit")) return false;
        $button = '<div class="status_holder" id="status_holder_'.$row["id"].'">
                    <img src="'.$this->base_url.'admin/img/button_status.png" title="Status" class="status" id="status_'.$row["id"].'" content="#status_box_'.$row["id"].'">
                   <ul class="status_box" id="status_box_'.$row["id"].'">
                        <li><img title="gesperrt" style="cursor:pointer;" src="'.$this->base_url.'admin/img/kugel_rot.gif" title="inactive" onclick="ajax_action(\'change_entity_status\',\''.$this->table.'\',\''.$row["name"].'\',0)"/></li>
                        <li><img title="inaktiv" style="cursor:pointer;" src="'.$this->base_url.'admin/img/kugel_gruen.gif" title="active" onclick="ajax_action(\'change_entity_status\',\''.$this->table.'\',\''.$row["name"].'\',1)"/></li>                          
                        <li><img title="aktiv" style="cursor:pointer;" src="'.$this->base_url.'admin/img/kugel_gelb.gif" title="wait" onclick="ajax_action(\'change_entity_status\',\''.$this->table.'\',\''.$row["name"].'\',2)"/></li>
                   </ul>
                   </div>
                   <script type="text/javascript">
                        $("#status_'.$row["id"].'").click(function() {
                            $($(this).attr("content")).toggle();
                        });
                   </script>
';
        return $button;
    } 
    public function getButton_Delete($row){
        if (!$this->permissions->hasPermission($this->permission.".del")) return false;
        $button = '<img id="delete_button_'.$row["id"].'" src="'.$this->base_url.'admin/img/button_delete.png" title="Löschen" style="cursor:pointer;">
                   <script type="text/javascript">
                        $("#delete_button_'.$row["id"].'").click(function() {
                            var r=confirm("'.$this->lang["delete_entry"].'");
                                if (r==true) ajax_action(\'delete_entity\',\''.$this->table.'\',\''.$row["name"].'\');
                        });
                   </script>';
        return $button;
    }      
	public function getEditField_TableSelectSites($id,$field,$entity,$isnew){
	
			
			if($_SESSION["_registry"]["user"]['group']=="admin") { 
				$query = "SELECT id, ".$field[3]." FROM ".$field[4]." ORDER BY `id`;";
			} else {
				$query = "SELECT id, ".$field[3]." FROM ".$field[4]." WHERE id=".$_SESSION['_registry']['site_id']." ORDER BY `id`;";
			}
		$selects = $this->db->select($query,MYSQLI_ASSOC, FALSE);
		$html = '<select name="save['.$field[2].']" id="'.$field[2].'">';
		if($field[6]!==false)
			$html .='
                    <option value="">None</option>';
		foreach ($selects as $select){
			$html .= '<option value="'.$select[$field[5]].'" ';
			if ($entity[$field[2]] == $select[$field[5]]) $html .= 'selected="selected"';
			if(is_array($field[3])){
				$html .= ' class="'.$select[$field[3][1]].'">'.$select[$field[3][0]].'</option>';
			}else{
				$html .= '>'.$select[$field[3]].'</option>';
			}
		}
		$html .= '</select>';
		if ($field[6])
		$html .=       '
                <script>
                        $( "#'.$field[2].'" ).change(function() {
                            $("#edit_form").submit();
                        });
                </script>';
		return $html;
	}
}
?>
