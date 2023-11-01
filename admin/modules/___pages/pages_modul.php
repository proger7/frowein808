<?php
include_once 'includes/classes/modul.class.php';
class pages_modul extends modul{   
    function __construct(){
        $this->init();
        $this->path             = pathinfo(__FILE__,PATHINFO_DIRNAME)."/";
        $this->lang["module"]   = parse_ini_file( $this->path."localisation/de.ini");
        $this->table            = "pages";
        $this->permission       = "pages";
    }
    public function getTable($fields=FALSE,$filters=FALSE, $table = FALSE, $lang = FALSE){
        if (!$table) $table = $this->table;
        $query = "SELECT id";
        $fldsstr='id';
        if ($fields){
            foreach($fields as $field){
                if ($field[0] == "DateRange"){
                    $query .= ', `'.$field[2].'`, `'.$field[3].'`';
                    $fldsstr .= ', `'.$field[2].'`, `'.$field[3].'`';
                }else if ($field[0] == "BoolSelectRelation"){
                    $query .= '';
                }else{
                    $query .= ', `'.$field[2].'`';
                    $fldsstr .= ', `'.$field[2].'`';
                }
            }
        }
        if($this->db->is_field('order', $this->table)){
            $query .= ', `order`';
            $fldsstr .= ', `order`';
        }
        $query .= " FROM ".$table;
        if($_GET['search']){
            $this->search=$_GET['search'];
            $search=$this->search;
        }
        if ($filters || $search || $lang) $query .=" WHERE ";
        if ($filters){
            $query .= " (";
            $first = TRUE;
            foreach ($filters as $filter){
                if (!$first) $query .= " AND ";
                $query .= "`".$filter["0"]."`".$filter["1"]."'".$filter["2"]."'";
                $first = FALSE;
            }
            $query .= " )";
        }
        if ($lang){
            if ($filters || $search) $query .=" AND ";
            $query .= " `language_id`=$lang";
        }

        if ($search){
            if ($filters || $lang) $query .=" AND ";
            foreach($fields as $f){
                if($f[0]=='Input')
                    $query_arr[] = " `".$f[2]."` LIKE '%".$search."%' ";
            }
            if(is_array($query_arr) && !empty($query_arr))
                $query .= implode(' AND ',$query_arr);

        }

        $query .=' AND  site_id = 0';
        return $this->db->select($query.' ;');
    }
    public function saveEntity($id, $fields=FALSE, $table = FALSE){
        /*    ini_set('error_reporting', E_ALL);
            ini_set('display_errors',1);
            error_reporting(E_ALL);*/
        if (!$table) $table = $this->table;
        $querys = 0;
        $query = "UPDATE ".$table." SET ";
        if ($fields){
            $first = TRUE;
            foreach($fields as $field){
                if ($field[0] == "Image"){
                    if($_FILES['save']['tmp_name'][$field[2]]){
                        $imgsize = getimagesize($_FILES['save']['tmp_name'][$field[2]]);
                        $img_width = $imgsize[0];
                        $img_height = $imgsize[1];
                        if($img_width >= $field[3] && $img_height >= $field[4]){
                            $image = $this->save_image($id,$field, $table);
                            if ($image){if (!$first) $query .= ", ";
                                $query .= "`".$field[2]."` = '".$image."'";}
                            $querys ++;
                        }else{
                            echo '<p class="error">'.$field[1].' MIN size: '.$field[3].'px &times; '.$field[4].'px</p>';
                            $err = true;
                        }
                    }
                }
                else if($field[0] == "File"){
                    $file = $this->save_file($id,$field, $table);
                    if ($file){if (!$first) $query .= ", ";
                        $query .= "`".$field[2]."` = '".$file."'";}
                    $querys ++;
                }
                else if($field[0] == "DateRange" || $field[0] == "DateRangeBig"){
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".$_POST["save"][$field[2]]."', `".$field[3]."` = '".$_POST["save"][$field[3]]."'";
                    $querys ++;
                }
                else if($field[0] == "HTML" || $field[0] == "HTMLMin"){
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".addslashes($_POST["save"][$field[2]])."'";
                    $querys ++;
                }

                else if($field[0] == "BoolSelect"){
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".serialize($_POST["save"][$field[2]])."'";
                    $querys ++;
                }
                else if($field[0] == "Radio"){
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".($_POST["save"][$field[2]])."'";
                    $querys ++;
                }

                else if($field[0] == "BoolSelectRelation"){
                    $this->db->query("DELETE FROM ".$field[2]." WHERE ".$field[4]." = $id ;");
                    if(is_array($_POST["save"][$field[1]]))
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
                else if($field[0] == "InputsRelation"){
                    $this->db->query("DELETE FROM ".$field[2]." WHERE ".$field[4]." = $id ;");
                    foreach($_POST["save"][$field[1]] as $item_id => $value){
                        $sub_query = "INSERT INTO `".$field[2]."` (
                                    `".$field[3]."` ,
                                    `".$field[4]."` ,
                                                                        `value`
                                )
                                VALUES (
                                    '$item_id', '$id','".addslashes($value)."'
                                );";
                        $this->db->query($sub_query);
                    }
                }elseif ($field[0] == "Hidden"){
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[1]."` = '".$field[2]."'";
                    $querys ++;
                }
                else {
                    if (!$first) $query .= ", ";
                    $query .= "`".$field[2]."` = '".addslashes($_POST["save"][$field[2]])."'";
                    $querys ++;
                }
                $first = FALSE;
            }
        }
        $query .= ', site_id = 0 WHERE id='.$id.' LIMIT 1;';
        if ($querys && $err!=true)
            return $this->db->query($query);
        else
            return true;
    }
}
?>
