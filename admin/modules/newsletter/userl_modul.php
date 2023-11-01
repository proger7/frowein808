<?php
    include_once 'includes/classes/modul.class.php';
    class userl_modul extends modul{
        function __construct(){
            $this->init();
            $this->path             = pathinfo(__FILE__,PATHINFO_DIRNAME)."/";
            $this->lang["module"]   = parse_ini_file( $this->path."localisation/de.ini");
            $this->table            = "newsletter_users";
            $this->config			= parse_ini_file( $this->path."modul.ini");
            $this->permission		= $this->config["permission"];
        }
        /**
         * Generiert ein Listing aus einer Tabelle
         *
         * @param  array  $fields Feldarray
         * @param  array  $filters Filterarray
         * @param  array  $buttons Buttons der Einträge
         * @param  array  $extraButtons Hauptbuttons
         * @param  string  $table
         * @return string  html code der Tabelle
         */

        public function listTable($fields,$filters=FALSE,$buttons=FALSE,$extraButtons = FALSE, $table = FALSE, $tree = FALSE){

            //$_SESSION["_registry"]["variables"]["backlink"] = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
            $_SESSION["_registry"]["variables"]["backlink"] = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REDIRECT_URL"];
            $this->extraButtons = $extraButtons;
            $lang=(isset($_GET["lang"]) && $_GET["lang"] != "")?$_GET["lang"]:1;
            if($tree)
                $req_table = $this->getTableTree($fields,$filters,$table);
            else
                $req_table = $this->getTable($fields,$filters,$table,$lang);

            //print_r($this->lang);
            $html='	<fieldset><legend>'.$this->lang["module"]["available_entitys"].'</legend></fieldset>
					<div class="bottom-buttons"><form action="?edit=none" method="post" id="new_frm" style="display:inline-block;margin-right:10px;">';

            if ($this->permissions->hasPermission($this->permission.".edit") || $_SESSION["_registry"]["section"] == "frontend")
                $html .= '<input type="submit" src="'.$this->base_url.'admin/img/button_new_de.png" class="btn btn-primary" value="'.$_SESSION["_registry"]["lang"]["backend"]["new_entry"].'" />';
            $html .= '</form>';

            if ($this->permissions->hasPermission($this->permission.".del") || $_SESSION["_registry"]["section"] == "frontend")
                $html .= '<input type="button" src="'.$this->base_url.'admin/img/button_delete_mass_de.png" name="delete_mass" id="delete_mass"  class="btn btn-primary" style="margin-right:6px;" value="'.$_SESSION["_registry"]["lang"]["backend"]["delete_selected"].'" />
                      <script type="text/javascript">
                      	$("#delete_mass").click(function() {
                        	delete_mass(\''.$this->table.'\');
                        	return false;
                        });
                      </script>';
            $html .= '<input type="submit" src="'.$this->base_url.'admin/img/button_reload_de.png" name="reload" onClick="location.reload();"  class="btn btn-primary" style="margin-right:10px;" value="'.$_SESSION["_registry"]["lang"]["backend"]["actualize"].'" />';
            if($this->db->is_field('order', $this->table) && !$tree){
                $val = $_GET['ordering']==1?'Sort mode':'Order mode';

                //	$html .= '<input type="submit" src="'.$this->base_url.'admin/img/button_ordering.png" name="ordering" id="ordering" class="btn btn-primary" value="'.$val.'" />';
            }
            $html .= '<form style="float: right;" action="https://www.frowein808.de/admin/includes/ajax_export.php" method="POST"> 
                        <input id="newsletter_user_export" type="submit" class="btn btn-primary" value="Export csv" />
                        <input type="hidden" name="export_newsletter_users"/>
                        </form>';
            $tableclass=$_GET['ordering']==1?'ordermode':'sortmode';
            if (isset($this->extraButtons["Lang"])){
                /*for($i=1;$i<=3;$i++){
                    $act=($lang==$i)?'_active':'';
                    $html .= '<a href="?lang='.$i.'" ><img style="margin-bottom:-10px;margin-right:10px;" src="'.$this->base_url.'admin/img/btn_lang_'.$i.$act.'.png" style="cursor:pointer;"></a>';
                }*/
                for($i=1;$i<=count($this->slangs);$i++){
                    $act=($lang==$i)?'_active':'';
                    $html .= '<a class="button" href="?lang='.$i.'" >'.$this->slangs[$i].'</a>';
                }

            }
            $html .= '</div><br clear="all"><br clear="all"><div class="table-responsive"><table id="tableListing" cellspacing="0" cellpadding="0" class="'.$tableclass.' table">
            	<thead>
                	<tr>';

            if($this->db->is_field('order', $this->table) && !$tree)
                $html .= '	<th style="width:15px;">#</th>';

            $html .= '		<th style="width:15px;">&times;</th>';
            if ($fields){
                $first = TRUE;
                foreach($fields as $field){
                    $html .= ' <th';
                    if ($field[0] == "Status" || $field[0] == "Status3" || $field[0] == "Switch")$html .= ' class="swtch" ';
                    $html .= '>'.$field[1].'</th>';
                }
                $html .= '<th style="width:'.(count($buttons) * 23).'px;"></th>';
                $html .= '</tr>
				</thead>
			<tbody>';
                if($tree){
                    $tree_arr=$this->_transform2forest($req_table,'id','parent');
                    $html.=$this->build_tree($tree_arr,$fields,$buttons);
                }else{
                    foreach ($req_table as $k=>$row){
                        $html .= '<tr data-position="'.($k+1).'" id="'.$row["id"].'">';
                        if($this->db->is_field('order', $this->table) && !$tree)
                            $html .= '<td style="text-align:center;cursor:move" class="dragHandle">'.$row["order"].'</td>';
                        $html .= '<td class="deltd"><input type="checkbox" name="marked[]" value="'.$row["id"].'" /></td>';
                        foreach ($fields as $field){
                            if ($field[0] != "Input") {
                                $call = "getField"."_".$field[0];
                                $fieldData = $this->$call($field,$row);
                            }
                            else {
                                if ($field[2] == "if_unsubscribe") {
                                    if($row[$field[2]] == 0 ) {
                                        $fieldData = "Ja";
                                    } else {
                                        $fieldData = "Nein";
                                    }
                                } else {
                                    $fieldData = $row[$field[2]];
                                }
                            }
                            $html .= '
	                                <td';
                            if ($field[0] == "Status" || $field[0] == "Status3" || $field[0] == "Switch") {
                                $html .= ' style="text-align:center;"';
                                $html.='><span style="position:absolute;left:-5000px">'.$row[$field[2]].'</span>'.$fieldData.'</td>';
                            } else if ($field[0] == "Date") {
                                if($row[$field[2]] == "0000-00-00 00:00:00") {
                                    $html .= '></td>';
                                } else {
                                    $html .= ' style="padding-left:10px;"';
                                    $html .= '><span  style="position:absolute;left:-5000px">' . date("Y-m-d", strtotime($fieldData)) . '</span>' . $fieldData . '</td>';
                                }
                            } else {
                                $html .= ' style="padding-left:10px;"';
                                $html.='>'.$fieldData.'</td>';
                            }
                        }

                        if (is_array($buttons)){
                            $buttons_html= '';
                            foreach ($buttons as $button){
                                $call = "getButton"."_".$button;
                                $fieldData = $this->$call($row);
                                if ($fieldData)
                                    $buttons_html .= $fieldData.'&nbsp;';
                            }
                            $html .= '<td class="action_buttons">'.$buttons_html.'</td>';
                        }
                        $html .= '
	                        </tr>';
                    }
                }
            }
            $html .= '</tbody>
			</table></div><br>
		';
            $rowstr['y'] = '{ "bSortable": false },';
            $libstr['y'] = '.rowReordering({ sURL:URL_ROOT + "admin/includes/ajax.php?table='.$this->table.'", sRequestType: "POST", _fnEndProcessingMode: fnrel});';
            $rowstr['n'] = 'null,';
            $libstr['n'] = ';';
            if($_GET['ordering']==1){
                $ord='y';
            }else{
                $ord='n';
            }
            if($tree){
                $html .= '
	        <script type="text/javascript" charset="utf-8">
				$(document).ready(function() {
				    $("#tableListing").dataTable({
				        "oLanguage": {"sUrl": URL_ROOT + "admin/js/datatables/dataTables.'.$_SESSION["_registry"]["u_lang"].'.txt"},
				        "bPaginate": false,
				        "bStateSave" : true,
				        "bJQueryUI": true,
				        "aoColumns": [';
                $html .= '{ "bSortable": false },';
                for($i = 1; $i <= count($fields); $i++){
                    if($fields[($i-1)][0]=="Switch")
                        $html .= '{ "bSortable": false },';
                    else
                        $html .= $rowstr[$ord];
                }
                $html .= '
					      	{ "bSortable": false }
				        ]';
                $html .= '
				    } )'.$libstr[$ord].'
				    $("#tableListing_length select");
					setTimeout(function(){ $("#tableListing").parent().addClass("table-responsive");}, 300);
				} );
				';
            }else{
                $html .= '
	        <script type="text/javascript" charset="utf-8">
				$(document).ready(function() {
                    $(document).delegate("#newsletter_user_export", "click", function(){
                        
                        })
				    $("#tableListing").dataTable({
				        "oLanguage": {"sUrl": URL_ROOT + "admin/js/datatables/dataTables.'.$_SESSION["_registry"]["u_lang"].'.txt"},
				        "sPaginationType": "full_numbers",
				        "bStateSave" : true,
				        "bJQueryUI": true,
				        "bAutoWidth": false,
				        "aoColumns": [';
                if($this->db->is_field('order', $this->table))
                    $html .= 'null,';
                $html .= '{ "bSortable": false },';
                for($i = 1; $i <= count($fields); $i++){
                    if($fields[($i-1)][0]=="Switch")
                        $html .= '{ "bSortable": false },';
                    else
                        $html .= $rowstr[$ord];
                }
                $html .= '
					      	{ "bSortable": false }
				        ]';
                if($this->db->is_field('order', $this->table))
                    $html .= ',"aaSorting": [[ 0, "asc" ]]';
                $html .= '
				    } )'.$libstr[$ord].'
					setTimeout(function(){ $("#tableListing").parent().addClass("table-responsive");}, 300);
				} );
				';
            }
            $html .= '
		$("#ordering").click(function() {
			if(window.location.search.length > 1){
				window.location = "http://"+window.location.hostname+window.location.pathname;
			}else{
				window.location = "http://"+window.location.hostname+window.location.pathname+"?ordering=1";
			}
		});
		function fnrel(){
			location.reload();
		}
		</script>';
            return $html;
        }
        public function getTable($fields=FALSE,$filters=FALSE, $table = FALSE){
            if (isset($_GET["search"]) && $_GET["search"] != "")
                $search = $_GET["search"]; else $search = FALSE;
            if (isset($this->extraButtons["Lang"])){
                if (isset($_GET["lang"]) && $_GET["lang"] != "")
                    $lang = $_GET["lang"];
                else
                    $lang = 1;
            }
            if (isset($_GET["order"]) && $_GET["order"] != "")
                $order = $_GET["order"];
            else if(!$NOORDER && $this->db->is_field('order', $this->table))
                $order = "order";
            else
                $order = FALSE;

            if (isset($_GET["direction"]) && $_GET["direction"] != "")
                $direction = $_GET["direction"];
            else
                $direction = 'ASC';

            if (!$table) $table = $this->table;

            if(isset($_POST['filter']) && $_POST['filter'] !=''){
                $users_ids = $this->db->select("SELECT * FROM newsletter_user_group WHERE group_id=".$_POST['filter']);
                if(!empty($users_ids)){
                    foreach($users_ids as $user_id){
                        $arr[] = $user_id['user_id'];
                    }


                    $query = "SELECT id";
                    if ($fields){
                        foreach($fields as $field){
                            if ($field[0] == "DateRange") $query .= ', `'.$field[2].'`, `'.$field[3].'`';
                            else if ($field[0] == "BoolSelectRelation") $query .= '';
                            else $query .= ', `'.$field[2].'`';
                        }
                    }
                    if($this->db->is_field('order', $this->table))$query .= ', `order`';
                    $query .= " FROM ".$table;
                    if ($filters || $search || $lang) $query .=" WHERE ";
                    if ($filters){
                        $query .= " (";
                        $first = TRUE;
                        foreach ($filters as $filter){
                            if (!$first) $query .= " AND ";
                            $query .= "`".$filter["0"]."`".$filter["1"]."'".$filter["2"]."'";
                            $first = FALSE;
                        }
                        if ($search){
                            $query .= " AND ";
                        }
                        $query .= " )";
                    }
                    if ($search){
                        if ($filters) $query .= " AND ";
                        $query .= '(';
                        $first = TRUE;
                        foreach ($fields as $field){
                            if (!$first) $query .= " OR ";
                            $query .= "`".$field["2"]."` LIKE '%".$search."%'";
                            $first = FALSE;
                        }
                        $query .= ')';
                    }

                    if ($lang){
                        if ($filters || $search) $query .=" AND ";
                        $query .= " `language_id`=$lang";
                    }

                    $query .=" WHERE id IN(".implode(',', $arr).")";

                    if ($order){
                        $query .= ' ORDER BY `'.$order.'` '.$direction;
                    }
                    $query .= ';';
                    return $this->db->select($query);
                } else {
                    return array();
                }
            }
            else {
                $query = "SELECT if_unsubscribe ";
                if ($fields){
                    foreach($fields as $field){
                        if ($field[0] == "DateRange") $query .= ', `'.$field[2].'`, `'.$field[3].'`';
                        else if ($field[0] == "BoolSelectRelation") $query .= '';
                        else $query .= ', `'.$field[2].'`';
                    }
                }
                if($this->db->is_field('order', $this->table))$query .= ', `order`';
                $query .= " FROM ".$table;
                if ($filters || $search || $lang) $query .=" WHERE ";
                if ($filters){
                    $query .= " (";
                    $first = TRUE;
                    foreach ($filters as $filter){
                        if (!$first) $query .= " AND ";
                        $query .= "`".$filter["0"]."`".$filter["1"]."'".$filter["2"]."'";
                        $first = FALSE;
                    }
                    if ($search){
                        $query .= " AND ";
                    }
                    $query .= " )";
                }
                if ($search){
                    if ($filters) $query .= " AND ";
                    $query .= '(';
                    $first = TRUE;
                    foreach ($fields as $field){
                        if (!$first) $query .= " OR ";
                        $query .= "`".$field["2"]."` LIKE '%".$search."%'";
                        $first = FALSE;
                    }
                    $query .= ' ) AND kundennummer = 0';
                    // echo $query;exit;
                }

                if ($lang){
                    if ($filters || $search) $query .=" AND ";
                    $query .= " `language_id`=$lang";
                }



                if ($order){
                    $query .= '  WHERE  user_group != 0  AND kundennummer = 0 AND is_deleted =0 AND  id IN(select user_id from newsletter_user_group where group_id = 55) ORDER BY `'.$order.'` '.$direction;
                }

                if(!$search && !$order){
                    $query .= '  WHERE  user_group != 0  AND kundennummer = 0 AND is_deleted =0 AND  id IN(select user_id from newsletter_user_group where group_id = 55) ;';
                }
                return $this->db->select($query);
            }
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
                    if ($field[0] != "Input") {
                        $call = "getEditField"."_".$field[0];
                        if($field[2] == 'user_createdate') {
                            $fieldData =  date("d.m.Y H:i", strtotime($entity['user_createdate']))." 
<style>
#showuser_createdate{ position: absolute;left:-5000px}
</style>
";
                            $fieldData .= $this->$call($id, $field, $entity, $isnew);
                        } else if($field[2] == 'unsubscribe_date') {
                            if($entity['unsubscribe_date'] == "0000-00-00 00:00:00") {
                                $fieldData = " - ";
                            } else {
                                $fieldData =   date("d.m.Y H:i", strtotime($entity['unsubscribe_date']))  ;
                            }
                        } else {
                            $fieldData = $this->$call($id, $field, $entity, $isnew);
                        }
                    }
                    else {
                        if($isnew==false && $field[3]){
                            $this->gen_valid_rule($field[3],$field[2]);
                        }
                        if($field[2] == 'if_unsubscribe') {
                            $fieldData = "";
                            if($entity[$field[2]] == 0){
                                $fieldData = " Ja ";
                            } else {
                                $fieldData = "Nein";
                            }
                        } else {
                            $fieldData = '<input type="text" class="form-control" name="save[' . $field[2] . ']" class="inp_text" value=\'' . htmlspecialchars($entity[$field[2]], ENT_QUOTES, "UTF-8") . '\' />';
                        }
                    }
                    if($field[2]  == 'user_createdate' || $field[2]  == 'if_unsubscribe' || $field[2]  == 'unsubscribe_date' ) {
                        $html .= '<div class="clearfix"></div>
					<div class="col-lg-12">
						<h4><div style="float:left; width:175px">' . $field[1] . ':</div> ' . $fieldData . '</h4> 
                            </div>	';
                    } else {
                        $html .= '<div class="clearfix"></div>
                            <div class="col-lg-12">
                                <label>' . $field[1] . '</label>
                                <div class="form-group">
                                    ' . $fieldData . '
                                </div>
                            </div>	';
                    }
                }
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
    }
?>
