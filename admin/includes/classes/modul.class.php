<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modul
 *
 * @author Abadon
 */
class modul {
	protected       $db;
	protected       $time;
	protected       $lang;
	protected       $base_url;
	protected       $base_root;
	protected       $ftp;
	protected       $permission;
	protected       $permissions;
	protected       $config;
	public          $table;
	private         $name;
	private         $path;
	public          $extraButtons;


	function __construct(){
		$this->init();
	}

	protected function init(){
		$this->db       =  $_SESSION["_registry"]["db"];
		$this->lang     =  $_SESSION["_registry"]["lang"]["backend"];
		$this->time     =  $_SESSION["_registry"]["time"];
		$this->base_url =  $_SESSION["_registry"]["system_config"]["site"]["base_url"];
		$this->base_root =  $_SESSION["_registry"]["root"]."/";
		$this->permissions = new permissions();
		$this->slangs = array(1=>'DE',2=>'EN');
		try
		{
			$this->ftp = FTP::getInstance();
			$this->ftp->connect($_SESSION["_registry"]["ftp_config"]["self"], false, true );
		}
		catch (FTPException $error) {echo $error->getMessage();}
	}

	public function _transform2forest($rows, $idName, $pidName)
    {
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
    public function gen_valid_rule($validation_value,$name){
    	global $rules;
    	if(is_array($validation_value)){
    		$validarr=array();
    		foreach($validation_value as $k=>$v){
    			$validarr[]=$v.': true';
    		}
    		$validstr = implode(',', $validarr);
    	}else{
    		$validstr = $validation_value .': true';
    	}
    	$rules[]='"save['.$name.']": {'.$validstr.'}';
    }
	public function build_tree($arr,$fields,$buttons,$pre=''){
		$html='';
		foreach ($arr as $k=>$row){
			$html .= '
                        <tr>';
			$html .= '
                            <td><input type="checkbox" name="marked[]" value="'.$row["id"].'" /></td>';
			foreach ($fields as $field){
				if ($field[0] != "Input") {
					$call = "getField"."_".$field[0];
					$fieldData = $this->$call($field,$row);
				}
				else $fieldData = $row[$field[2]];
				$html .= '
                                <td';
				if ($field[0] == "Status" || $field[0] == "Status3" || $field[0] == "Switch") $html .=' style="text-align:center;"';
				else
					$html .=' style="padding-left:10px;"';
				if($field[2] == "title")
					$html.='>'.$pre.$fieldData.'</td>';
				else
					$html.='>'.$fieldData.'</td>';
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
			$html .= '</tr>';
			if(!empty($row['sub'])){
				$html .= $this->build_tree($row['sub'],$fields,$buttons,$pre.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
			}
		}
		return $html;
	}
	public function getTableTree($fields=FALSE,$filters=FALSE, $table = FALSE){
        if (!$table) $table = $this->table;
        $query = "SELECT id";
        if ($fields){
            foreach($fields as $field){
                if ($field[0] == "DateRange") $query .= ', `'.$field[2].'`, `'.$field[3].'`';
                else if ($field[0] == "BoolSelectRelation") $query .= '';
                else $query .= ', `'.$field[2].'`';
            }
        }
        if($this->db->is_field('order', $this->table))$query .= ', `order`';
        $query .= ", parent FROM ".$table;
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
        $query .= ' ORDER BY parent, `order`;';
        return $this->db->select($query);
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
	        			//$html .= '<td style="text-align:center;"><img src="'.$this->base_url.'admin/img/arrow_out.png" title="Order" /></td>';
					$html .= '<td class="deltd"><input type="checkbox" name="marked[]" value="'.$row["id"].'" /></td>';
					foreach ($fields as $field){
						if ($field[0] != "Input") {
							$call = "getField"."_".$field[0];
							$fieldData = $this->$call($field,$row);
						}
						else $fieldData = $row[$field[2]];
						$html .= '
	                                <td';
						if ($field[0] == "Status" || $field[0] == "Status3" || $field[0] == "Switch")
							$html .=' style="text-align:center;"';
						else
							$html .=' style="padding-left:10px;"';
						$html.='>'.$fieldData.'</td>';
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


	/**
	 * Liest die Tabelle aus
	 *
	 * @param  array  $fields Feldarray
	 * @param  array  $filters Filterarray
	 * @param  string  $table
	 * @return array  assoziatives array der Tabelle
	 */
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
		return $this->db->select($query.' ;');
	}

	/**
	 * wandelt datetime in das standartformat der gewählten sprache oder in definiertes
	 *
	 * @param  string  $field Feldarray array(typ,name,spalte[,timeformat])
	 * @param  string  $row Datensatz
	 * @return string  html code der Tabelle
	 */
	protected function getField_DateTime($field,$row){
		if (!isset($field[3])) $format = FALSE;
		else $format = $field[3];
		return $this->time->convertDateTime($row[$field[2]],$format);
	}
	/**
	 * wandelt datum in das standartformat der gewählten sprache oder in definiertes
	 *
	 * @param  string  $field Feldarray array(typ,name,spalte[,timeformat])
	 * @param  string  $row Datensatz
	 * @return string  html code der Tabelle
	 */
	protected function getField_Date($field,$row){
		if (!isset($field[3])) $format = FALSE;
		else $format = $field[3];
		if ($row[$field[2]] != "0000-00-00") return $this->time->convertDate($row[$field[2]],$format);
	}

	protected function getField_Select($field,$row){
		return $field[3][$row[$field[2]]];
	}

	protected function getField_DateRange($field,$row){
		if (!isset($field[4])) $format = FALSE;
		else $format = $field[4];
		if ($row[$field[2]] != "0000-00-00") $from = $this->time->convertDate($row[$field[2]],$format);
		if ($row[$field[3]] != "0000-00-00") $till = $this->time->convertDate($row[$field[3]],$format);
		return $from.' - '. $till;
	}

	/**
	 * wandelt zeit in das standartformat der gewählten sprache oder in definiertes
	 *
	 * @param  string  $field Feldarray array(typ,name,spalte[,timeformat])
	 * @param  string  $row Datensatz
	 * @return string  html code der Tabelle
	 */
	protected function getField_Time($field,$row){
		if (!isset($field[3])) $format = FALSE;
		else $format = $field[3];
		return $this->time->convertTime($row[$field[2]],$format);
	}
	/**
	 * holt anhand des inhaltes den inhalt aus einer anderen Tabelle
	 *
	 * @param  string  $field Feldarray array(typ,name,spalte,zielspalte,tabelle,zieleigenschaft)
	 * @param  string  $row Datensatz
	 * @return string  html code der Tabelle
	 */
	protected function getField_Table($field,$row){
		if (!isset($field[3]) || !isset($field[4]) || !isset($field[5])) return '<p style="color:red;">FIELD-ERROR</p>';
		else {
			return $this->db->query_fetch_single("SELECT $field[3] FROM $field[4] WHERE $field[5] = '".$row[$field[2]]."' LIMIT 1;");
		}
	}

	/**
	 * holt anhand des inhaltes den inhalt aus einer anderen Tabelle
	 *
	 * @param  string  $field Feldarray array(typ,name,spalte,zielspalte,tabelle,zieleigenschaft)
	 * @param  string  $row Datensatz
	 * @return string  html code der Tabelle
	 */
	protected function getField_TableFilter($field,$row){
		if (!isset($field[3]) || !isset($field[4]) || !isset($field[5])) return '<p style="color:red;">FIELD-ERROR</p>';
		else {
			return $this->db->query_fetch_single("SELECT $field[3] FROM $field[4] WHERE $field[5] = '".$row[$field[2]]."' AND $field[6] LIMIT 1;");
		}
	}

	/**
	 * gibt eine rote oder grüne kugel aus
	 *
	 * @param  string  $field Feldarray array(typ,name,spalte,zielspalte,tabelle,zieleigenschaft)
	 * @param  string  $row Datensatz
	 * @return string  ausgabe der grafik
	 */
	public function getField_StatusFE($field,$row){
		$status = '<i class="fas fa-circle"';
		switch ((int)$row[$field[2]]){
			case 0: $status .= 'style="color:#ff0000" title="'.$this->lang["inactive"].'"'; break;
			case 1: $status .= 'style="color:lightgreen" title="'.$this->lang["active"].'"'; break;
			case 2: $status .= 'style="color:yellow" title='.$this->lang["active"].'"'; break;
		}
		$status.= '></i>';
		return $status;
	}
	protected function getField_Status($field,$row){
		$status = '<img src="'.$this->base_url.'admin/img/';
		switch ($row[$field[2]]){
			case 0: $status .= 'kugel_rot.gif" alt="'.$this->lang["inactive"].'"'; break;
			case 1: $status .= 'kugel_gruen.gif" alt="'.$this->lang["active"].'"'; break;
			case 2: $status .= 'kugel_gelb.gif" alt="'.$this->lang["active"].'"'; break;
		}
		$status.= ' />';
		return $status;
	}

	protected function getField_Switch($field,$row){
		$switch = '<img class="switchbtn" src="'.$this->base_url.'admin/img/';
		switch ($row[$field[2]]){
			case 0: $switch .= 'kugel_rot.gif" alt="'.$this->lang["not new"].'"'; break;
			case 1: $switch .= 'kugel_gruen.gif" alt="'.$this->lang["new"].'"'; break;
			case 2: $switch .= 'kugel_gelb.gif" alt="'.$this->lang["new"].'"'; break;
		}
		$switch.= ' onclick="ajax_action(\'change_switch\',\''.$this->table.'\','.$row["id"].',\''.$field[2].'\')" />';
		return $switch;
	}
	/*	public function getButton_Status($row){
		if (!$this->permissions->hasPermission($this->permission.".edit") && $_SESSION["_registry"]["section"] != "frontend") return false;
		if (!$row["status"]) $status = 1;
		else $status = 0;
		$button = '<img style="cursor:pointer;" src="'.$this->base_url.'admin/img/button_status.png" title="Status" onclick="ajax_action(\'change_status\',\''.$this->table.'\','.$row["id"].','.$status.')"/>';
		return $button;
	}*/

	protected function getField_Bool($field,$row){
		switch ($row[$field[2]]){
			case 0: $status = 'Nein'; break;
			case 1: $status = 'Ja'; break;
		}
		return $status;
	}

	/**
	 * gibt eine rote grüne oder gelbe kugel aus
	 *
	 * @param  string  $field Feldarray array(typ,name,spalte,zielspalte,tabelle,zieleigenschaft)
	 * @param  string  $row Datensatz
	 * @return string  ausgabe der grafik
	 */
	protected function getField_Status3($field,$row){
		$status = '<img src="'.$this->base_url.'admin/img/';
		switch ($row[$field[2]]){
			case "": $status .= 'kugel_gelb.gif" alt="'.$this->lang["wait"].'"'; break;
			case 2: $status .= 'kugel_gelb.gif" alt="'.$this->lang["wait"].'"'; break;
			case 1: $status .= 'kugel_gruen.gif" alt="'.$this->lang["active"].'"'; break;
			case 0: $status .= 'kugel_rot.gif" alt="'.$this->lang["inactive"].'"'; break;
		}
		$status.= ' />';
		return $status;
	}

	protected function getField_Lang($field,$row){
		switch ($row[$field[2]]){
			case 1: $status .= 'DE'; break;
			case 2: $status .= 'EN'; break;
		}
		return $status;
	}

	public function getButton_EditFE($row, $page){
		$button = '<a class="edit_lnk" href="'.$page.'/'.$row["id"].'" title="'.$_SESSION["_registry"]["lang"]["backend"]["edit_btn"].'"><i class="far fa-edit" style="color: #337ab7"></i></a>';
		return $button;
	}
	protected function getButton_Edit($row){
		if (!$this->permissions->hasPermission($this->permission.".read") && $_SESSION["_registry"]["section"] != "frontend") return false;
		$button = '<a class="edit_lnk" href="?edit='.$row["id"].'" title="'.$_SESSION["_registry"]["lang"]["backend"]["edit_btn"].'"><i class="far fa-edit" style="color: #337ab7"></i></a>';
		return $button;
	}
	protected function getButton_Order($row){
		if (!$this->permissions->hasPermission($this->permission.".read") && $_SESSION["_registry"]["section"] != "frontend") return false;
		$button = '
                    <img style="cursor:pointer;" src="'.$this->base_url.'admin/img/pfeil_up.png" title="'.$_SESSION["_registry"]["lang"]["backend"]["up_btn"].'" onclick="ajax_action(\'change_order\',\''.$this->table.'\','.$row["id"].','.($row["order"] - 1).')" />
                    <img style="cursor:pointer;" src="'.$this->base_url.'admin/img/pfeil_down.png" title="'.$_SESSION["_registry"]["lang"]["backend"]["down_btn"].'" onclick="ajax_action(\'change_order\',\''.$this->table.'\','.$row["id"].','.($row["order"] + 1).')" />';
		return $button;
	}
		protected function getButton_OrderParent($row){
		if (!$this->permissions->hasPermission($this->permission.".read")) return false;
		$button = '
                    <img style="cursor:pointer;" src="'.$this->base_url.'admin/img/pfeil_up.png" title="'.$_SESSION["_registry"]["lang"]["backend"]["up_btn"].'" onclick="ajax_action(\'change_order_parent\',\''.$this->table.'\','.$row["id"].',\''.($row["order"] - 1).','.$row["parent"].'\')"/>
                    <img style="cursor:pointer;" src="'.$this->base_url.'admin/img/pfeil_down.png" title="'.$_SESSION["_registry"]["lang"]["backend"]["down_btn"].'" onclick="ajax_action(\'change_order_parent\',\''.$this->table.'\','.$row["id"].',\''.($row["order"] + 1).','.$row["parent"].'\')"/>';
		return $button;
	}
	protected function getButton_Copy($row){
		if (!$this->permissions->hasPermission($this->permission.".edit") && $_SESSION["_registry"]["section"] != "frontend") return false;
		$button = '<a href="?edit='.$row["id"].'&e_copy=1" class="edit_lnk" title="'.$_SESSION["_registry"]["lang"]["backend"]["copy_btn"].'"><i class="far fa-copy"></i></a>';
		return $button;
	}
	public function getButton_DeleteFE($row, $table){
		$button = '<i class="far fa-trash-alt" id="delete_button_'.$row["id"].'" title="'.$_SESSION["_registry"]["lang"]["backend"]["del_btn"].'" style="color:#e3001b ;font-size:18px"></i> 
                   <script type="text/javascript">
                        jQuery("#delete_button_'.$row["id"].'").click(function() {
                            var r=confirm("'.$this->lang["delete_entry"].'");
                                if (r==true) ajax_action(\'delete\',\''.$table.'\','.$row["id"].');
                        });
                   </script>';
		return $button;
	}
	public function getButton_Delete($row){
		if (!$this->permissions->hasPermission($this->permission.".del") && $_SESSION["_registry"]["section"] != "frontend") return false;
		$button = '<i class="far fa-trash-alt" id="delete_button_'.$row["id"].'" title="'.$_SESSION["_registry"]["lang"]["backend"]["del_btn"].'" style="color:#e3001b!important;font-size:18px"></i> 
                   <script type="text/javascript">
                        jQuery("#delete_button_'.$row["id"].'").click(function() {
                            var r=confirm("'.$this->lang["delete_entry"].'");
                                if (r==true) ajax_action(\'delete\',\''.$this->table.'\','.$row["id"].');
                        });
                   </script>';
		return $button;
	}



	public function getButton_DeleteUsers($row){
		if (!$this->permissions->hasPermission($this->permission.".del") && $_SESSION["_registry"]["section"] != "frontend") return false;
		$button = '<i class="far fa-trash-alt" id="delete_button_'.$row["id"].'" style="color:#337ab7;font-size:18px"  title="'.$_SESSION["_registry"]["lang"]["backend"]["del_btn"].'"></i> 
                   <script type="text/javascript">
                        jQuery("#delete_button_'.$row["id"].'").click(function() {
                            var r=confirm("'.$this->lang["delete_entry"].'");
                                if (r==true) ajax_action(\'delete_users\',\''.$this->table.'\','.$row["id"].');
                        });
                   </script>';
		return $button;
	}
	public function getButton_Status($row){
		if (!$this->permissions->hasPermission($this->permission.".edit") && $_SESSION["_registry"]["section"] != "frontend") return false;
		if (!$row["status"]) $status = 1;
		else $status = 0;
		$button = '<i class="fab fa-audible" title="Status" onclick="ajax_action(\'change_status\',\''.$this->table.'\','.$row["id"].','.$status.')" style="color:#e3001b ;font-size:18px"></i>  ';
		return $button;
	}
	public function getButton_StatusFE($row, $table){
		if (!$row["status"]) $status = 1;
		else $status = 0;
		$button = '<i class="fab fa-audible" title="Status" onclick="ajax_action(\'change_status\',\''.$table.'\','.$row["id"].','.$status.')" style="color:#e3001b;font-size:18px"></i>  ';
		return $button;
	}
	public function getButton_Status3($row){
		if (!$this->permissions->hasPermission($this->permission.".edit")) return false;
		$button = '<div class="status_holder" id="status_holder_'.$row["id"].'" style="width:20px; float:left;">
                    <img src="'.$this->base_url.'admin/img/button_status.png" title="Status" class="status" id="status_'.$row["id"].'" content="#status_box_'.$row["id"].'" />
                   <ul class="status_box" id="status_box_'.$row["id"].'">
                        <li><img title="gesperrt" style="cursor:pointer;" src="'.$this->base_url.'admin/img/kugel_rot.gif" title="inactive" onclick="ajax_action(\'change_status\',\''.$this->table.'\','.$row["id"].',0)"/></li>
                        <li><img title="aktiv" style="cursor:pointer;" src="'.$this->base_url.'admin/img/kugel_gruen.gif" title="active" onclick="ajax_action(\'change_status\',\''.$this->table.'\','.$row["id"].',1)"/></li>                          
                        <li><img title="inaktiv" style="cursor:pointer;" src="'.$this->base_url.'admin/img/kugel_gelb.gif" title="wait" onclick="ajax_action(\'change_status\',\''.$this->table.'\','.$row["id"].',2)"/></li>
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

	public function getField_Image($field,$entity){
		if ($entity[$field[2]] != ""){
			$image = new image();
			$html = $image->get_thumb($entity[$field[2]]);
		}
		return $html;
	}

	public function getField_Url($field,$entity){
		if ($entity[$field[2]] != ""){
			$html = '<a href="'.$entity[$field[2]].'" target="_blank" >'.$entity[$field[2]].'</a>';
		}
		return $html;
	}

	public function getField_File($field,$entity){
		$FILENAME = $this->base_root."uploads/".$entity[$field[2]];
		$val_save = $field[2];
		if (!is_file($FILENAME))
		{
			return "";
		}

		$info[]=array("jpg","Image");
		$info[]=array("gif","Image");
		$info[]=array("png","Image");
		$info[]=array("pdf","PDF-File");
		$info[]=array("zip","Compressed File");
		$info[]=array("htm","HTML-File");
		$info[]=array("html","HTML-File");
		$info[]=array("doc","Word Document");
		$info[]=array("rar","Compressed File");
		$info[]=array("txt","Text-File");
		$info[]=array("mp3","MP3 Music-file");
		$info[]=array("exe","Executable file");
		$info[]=array("tar","Tar Compressed file");
		$info[]=array("swf","Flash file");

		$ext=substr($FILENAME,-3);
		$ext2=substr($FILENAME,-4);
		if ($ext2[0]!=".")  $ext=$ext2;
		$ext=strtolower($ext);
		for ($t=0;$t<count($info);$t++)
		{   if ($ext==$info[$t][0])
		{       if ($info[$t][1]=="Image")
		$html .= '       <a href="'.$this->base_url.'uploads/'.$entity[$field[2]].'" rel="shadowbox" title="'.$image[2].'">
                                                    <img src="'.$this->base_url.'uploads/'.$entity[$field[2]].'" style="width:100px;" />
                                                </a>';
		else    $html .= '<a href="'.$this->base_url.'uploads/'.$entity[$field[2]].'">[download]</a>';
		return $html;
		}
		}
		$html .= '<a href="'.$this->base_url.'uploads/'.$entity[$field[2]].'">[download]</a>';
		return $html;
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


	public function showEntityStructered($id,$fields,$table = FALSE){
		global $FORM_COUNT;
		if (!$table) $table = $this->table;
		if (isset($_POST["save".$FORM_COUNT])) foreach ($fields as $field) { $this->saveEntity($id, $field, $table);}
		if (isset($_POST["saveback".$FORM_COUNT])) { foreach ($fields as $field) {$this->saveEntity($id, $field, $table);} echo '<script>window.location = "'.$_SESSION["_registry"]["variables"][sha1($this->path)]["backlink"].'";</script>';}
		else if (isset($_POST["reload"])) echo '<script>window.location = "'.$_SESSION["_registry"]["variables"][sha1($this->path)]["backlink"].'";</script>';
		else if (isset($_POST["save_action"]) && $_POST["save_action"] == "delete" || isset($_GET["delete"])) {
			$this->deleteEntity($id, $fields, $table );
			echo '<script>window.location = "'.$_SESSION["_registry"]["variables"][sha1($this->path)]["backlink"].'";</script>';
		}
		else if (isset($_GET["status_change"])) {
			$this->statusEntity($id,$_GET["status"],$table);
			echo '<script>window.location = "'.$_SESSION["_registry"]["variables"][sha1($this->path)]["backlink"].'";</script>';
		}
		else if (isset($_GET["copy"])) {
			$id = $this->copyEntity($id,$table);
		}
		else if (isset($_POST["delete_mass"])) {
			if (isset($_POST["marked"])){
				foreach ($_POST["marked"] as $id){
					$this->deleteEntity($id, $fields, $table);
				}
			}
			echo '<script>window.location = "'.$_SESSION["_registry"]["variables"][sha1($this->path)]["backlink"].'";</script>';
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
			$html = '   <form enctype="multipart/form-data" action="?edit='.$id.'" method="post" id="edit_form'.$FORM_COUNT.'" name="edit_form'.$FORM_COUNT.'" >
                        <table id="showEntity">';
			$fieldlist = $fields;

			$html .= '
                            <tr><th colspan="10">'.$name.'</th></tr>';
			foreach ($fieldlist as $fields){
				$entity = $this->getEntity($id, $fields, $table);
				$html .= '
                        <tr>';
				foreach($fields as $field){
					if ($field[0] != "Input") {
						$call = "getEditField"."_".$field[0];
						$fieldData = $this->$call($id,$field,$entity);
					}
					else $fieldData = '<input type="text" class="" name="save['.$field[2].']" value="'.$entity[$field[2]].'" />';
					if ($field[0] != "Hidden")
					$html .= '
                                <td>'.$field[1].'</td><td class="entity_field">'.$fieldData.'</td>';
					else
					$html .= $fieldData;
				}
				$html .= '
                        </tr>';
			}

		}
		$html .= ' <tr class="btns"><td colspan="10">
                            <input type="image" src="'.$this->base_url.'admin/img/button_save_de.png" name="save'.$FORM_COUNT.'" value="" id="button_save'.$FORM_COUNT.'" />
                            <input type="image" src="'.$this->base_url.'admin/img/button_saveback_de.png" name="saveback'.$FORM_COUNT.'" value="" />
                            <a href="'.$_SESSION["_registry"]["variables"][sha1($this->path)]["backlink"].'"><img src="'.$this->base_url.'admin/img/button_cancel_de.png" /></a>
                   </td></tr>
                    </table>
                    </form>';
		$FORM_COUNT++;
		return $html;
	}

	public function getEntity($id,$fields,$table = FALSE){
		if (!$table) $table = $this->table;
		$query = "SELECT `id`";
		if ($fields){
			foreach($fields as $field){
				if ($field[0] == "DateRange" || $field[0] == "DateRangeBig") $query .= ", `".$field[2]."`, `".$field[3]."`";
				else if ($field[0] == "Hidden") $query .= ", `".$field[1]."`";
				else if ($field[0] == "BoolSelectRelation" || $field[0] == "OrderedBoolSelectRelation" || $field[0] == "InputsRelation") $query .= "";
				else $query .= ", `".$field[2]."`";
			}

		}
		$query .= " FROM `".$table."` WHERE id=".$id.";";
		return $this->db->query_fetch($query);
	}

	public function copyEntity($id,$fields,$table = FALSE){
		if (!$table) $table = $this->table;
		$query = "SELECT * FROM `".$table."` WHERE id=".$id.";";
		$old_entity = $this->db->query_fetch($query);
		unset($old_entity["id"]);
		unset($old_entity["update"]);
		unset($old_entity["editor"]);
		if (!$table) $table = $this->table;
		$bool_selects = array();
		foreach ($fields as $field){
			if($field[0] == "Image"){
				$image_cl = new image();
				if($image_cl->is_set($old_entity[$field[2]])){
					$ext = $image_cl->get_ext($old_entity[$field[2]]);
					$time = microtime(true) * 100 ;
					$image_array_tmp = unserialize($old_entity[$field[2]]);
					$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]);
					$this->ftp->chmod("uploads",0777);
					copy($this->base_root."uploads/".$image_array_tmp[0] , $this->base_root."uploads/".$time.$ext);
					copy($this->base_root."uploads/".$image_array_tmp[1] , $this->base_root."uploads/".$time."_thumb".$ext);
					$image_array_tmp[0] = $time.$ext;
					$image_array_tmp[1] = $time."_thumb".$ext;
					$old_entity[$field[2]] = serialize($image_array_tmp);
					$this->ftp->chmod("uploads",0755);
					unset ($image_array_tmp);
					unset ($ext);
					unset ($time);
				}
			}
			else if($field[0] == "File"){
				if($old_entity[$field[2]]){
					$ext=substr($old_entity[$field[2]] ,-3);
					$ext2=substr($old_entity[$field[2]] ,-4);
					if ($ext2[0]!=".")  $ext=$ext2;
					$ext = ".".$ext;
					$ext=strtolower($ext);
					$time = microtime(true) * 100 ;
					$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]);
					$this->ftp->chmod("uploads",0777);
					copy($this->base_root."uploads/".$old_entity[$field[2]] , $this->base_root."uploads/".$time.$ext);
					$old_entity[$field[2]] = $time.$ext;
					$this->ftp->chmod("uploads",0755);
					unset ($ext);
					unset ($time);
				}
			}
			else if($field[0] == "BoolSelectRelation" || $field[0] == "InputsRelation"){
				$bool_selects[] = $field;

			}
		}
		$query = "INSERT INTO ".$table." (
                    `id` ,
                    `update` ,
                    `editor`";

		foreach ($old_entity as $field => $value){
			$query .= " ,
                    `$field`";
			if ($field == "order") $old_entity[$field] = $this->db->get_max($field,$table) + 1;
		}
		$query .= "
                )VALUES (
                    NULL , NULL , '".$_SESSION["_registry"]["user"]["name"]."'";
		foreach ($old_entity as $field => $value){
			$query .= " , '".$value."'";
		}
		$query .= "          );
                ";
		$new_id = $this->db->lastindex_query($query);
		foreach ($bool_selects as $select){
			$old_selects = $this->db->select("SELECT * FROM ".$select[2]." WHERE ".$select[4]." = ".$id." ;");
			foreach ($old_selects as $new_select){
				if(isset($new_select["value"])){
					$this->db->query("INSERT INTO  ".$select[2]." (`".$select[3]."`, `".$select[4]."`,`value`) VALUES (".$new_select[$select[3]].",".$new_id.",'".$new_select["value"]."');");
				}
				else{
					$this->db->query("INSERT INTO  ".$select[2]." (`".$select[3]."`, `".$select[4]."`) VALUES (".$new_select[$select[3]].",".$new_id.");");
				}
			}
		}
		return $new_id;
	}

	public function saveEntity($id, $fields=FALSE, $table = FALSE){
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
				else if($field[0] == "MultiSelect") {
					$tags = implode(',', $_POST["save"][$field[2]]);

					if (!$first) $query .= ", ";
					$query .= "`".$field[2]."` = '".$tags."'";
					$querys ++;

				} else if($field[0] == "File"){
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
				}
				else {
					if (!$first) $query .= ", ";
					$query .= "`".$field[2]."` = '".addslashes($_POST["save"][$field[2]])."'";
					$querys ++;
				}
				$first = FALSE;
			}
		}
		$query .= ' WHERE id='.$id.' LIMIT 1;';

		// echo '<pre>'; var_dump($query); echo "</pre>";

		if ($querys && $err!=true)
			return $this->db->query($query);
		else
			return true;
	}

	public function saveEntityArticle($id, $fields=FALSE, $table = FALSE){
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
					$file = $this->save_file_article($id,$field, $table, $_POST['save']['article_number']);
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
				}
				else {
					if (!$first) $query .= ", ";
					$query .= "`".$field[2]."` = '".addslashes($_POST["save"][$field[2]])."'";
					$querys ++;
				}
				$first = FALSE;
			}
		}
		$query .= ' WHERE id='.$id.' LIMIT 1;';
		if ($querys && $err!=true)
			return $this->db->query($query);
		else
			return true;
	}


	public function saveEntityLieferung($id, $fields=FALSE, $table = FALSE){
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
					$file = $this->save_file_lieferung($id,$field, $table, $_POST['save']['shipment_article']);
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

				else if($field[0] == "Date"){
					if (!$first) $query .= ", ";
					$query .= "`".$field[2]."` = '".date('Y-m-d', strtotime($_POST["save"][$field[2]]))."'";
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
				}
				else {
					if (!$first) $query .= ", ";
					$query .= "`".$field[2]."` = '".addslashes($_POST["save"][$field[2]])."'";
					$querys ++;
				}
				$first = FALSE;
			}
		}
		  $query .= ' WHERE id='.$id.' LIMIT 1;';
		if ($querys && $err!=true)
			return $this->db->query($query);
		else
			return true;
	}

	public function save_image($id,$field, $table){
		if (!is_dir($this->base_root."admin/tmp"))  {
			$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/");
			$this->ftp->makeDir("tmp");
			$this->ftp->chmod("tmp",0770);
		}
		if ($_FILES['save']['tmp_name'][$field[2]] != ""){
			if(preg_match("/image/i", $_FILES['save']['type'][$field[2]])){
				if(preg_match('/(jpg|jpeg)$/i', $_FILES['save']['type'][$field[2]])){
					$ext = ".jpg";
					$type = ImageEditor::JPG;
				}
				elseif(preg_match('/(png)$/i', $_FILES['save']['type'][$field[2]])){
					$ext = ".png";
					$type = ImageEditor::PNG;
				}
				elseif(preg_match('/(gif)$/i', $_FILES['save']['type'][$field[2]])){
					$ext = ".gif";
					$type = ImageEditor::GIF;
				}else
					return false;
				$time = microtime(true) * 100 ;
				move_uploaded_file($_FILES['save']['tmp_name'][$field[2]],$this->base_root."admin/tmp/".$time.$ext);
				$image_tmp = new ImageEditor();
				$image_tmp->loadImageFile($this->base_root."admin/tmp/".$time.$ext);
				$image = new ImageEditor();
				if ($field[3] && $field[4] && $field[7]){
					$image->createCanvas($field[3], $field[4]);
					$image->fillin($image_tmp);
				}
				else $image = $image_tmp;
				$image->writeImageFile( $this->base_root."admin/tmp/".$time.".tmp",$type);
				$thumb = new ImageEditor();
				if ($field[5] && $field[6]){
					$thumb->createCanvas($field[5], $field[6]);
					$thumb->fillin($image_tmp);
				}
				else {
					$thumb->createCanvas(100, 100);
					$thumb->fillin($image_tmp);
				}
				$thumb->writeImageFile( $this->base_root."admin/tmp/".$time."_thumb.tmp",$type);
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
				$this->ftp->upload($this->base_root."admin/tmp/".$time.".tmp",  $time.$ext, 'auto', 0 );
				$this->ftp->upload($this->base_root."admin/tmp/".$time."_thumb.tmp",    $time."_thumb".$ext, 'auto', 0 );
                $this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/tmp/");
                $this->ftp->delete($time.".tmp");
                $this->ftp->delete($time."_thumb.tmp");
				$query = "SELECT ".$field[2]." FROM ".$table." WHERE id=".$id." LIMIT 1";
				$old_img = unserialize($this->db->query_fetch_single($query));
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
				if (is_file($this->base_root."uploads/".$old_img[0]))
					$this->ftp->delete($old_img[0]);
				if (is_file($this->base_root."uploads/".$old_img[1]))
					$this->ftp->delete($old_img[1]);
				return serialize(array($time.$ext,$time."_thumb".$ext,$_POST["image"][$field[2]]));

			}
			else{
				$query = "SELECT ".$field[2]." FROM ".$table." WHERE id=".$id." LIMIT 1";
				$old_img = unserialize($this->db->query_fetch_single($query));
				return serialize(array($old_img[0],$old_img[1],$_POST["image"][$field[2]]));
			}
		}
		else{
			$query = "SELECT ".$field[2]." FROM ".$table." WHERE id=".$id." LIMIT 1";
			$old_img = unserialize($this->db->query_fetch_single($query));
			return serialize(array($old_img[0],$old_img[1],$_POST["image"][$field[2]]));
		}
	}

	public function save_file($id,$field, $table){

		if (!is_dir($this->base_root."admin/tmp"))  {
			$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/");
			$this->ftp->makeDir("tmp");
			$this->ftp->chmod("tmp",0770);
		}

		if ($_FILES['save']['tmp_name'][$field[2]] != ""){
			$ext = strtolower(end(explode('.', $_FILES['save']['name'][$field[2]])));
			if(!in_array($ext,array('exe','php','php3','bat','com','htm','html'))){
				$ext = ".".$ext;
				$ext=strtolower($ext);
				$time = microtime(true) * 100;
				move_uploaded_file($_FILES['save']['tmp_name'][$field[2]],$this->base_root."admin/tmp/".$time.".tmp");
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
				$this->ftp->upload($this->base_root."admin/tmp/".$time.".tmp",  $time.$ext, 'auto', 0 );
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/tmp/");
				$this->ftp->delete($time.".tmp");
				$old_file = $this->db->query_fetch_single("SELECT ".$field[2]." FROM ".$table." WHERE id=".$id." LIMIT 1;");
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
				if (is_file($this->base_root."uploads/".$old_img[0])) $this->ftp->delete($old_file);
			return $time.$ext;
			}
		}
	}
	public function save_file_article($id,$field, $table, $article_number){

		if (!is_dir($this->base_root."admin/tmp"))  {
			$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/");
			$this->ftp->makeDir("tmp");
			$this->ftp->chmod("tmp",0770);
		}

		if ($_FILES['save']['tmp_name'][$field[2]] != ""){
			$ext = strtolower(end(explode('.', $_FILES['save']['name'][$field[2]])));
			if(!in_array($ext,array('exe','php','php3','bat','com','htm','html'))){
				$ext = ".".$ext;
				$ext=strtolower($ext);
				$time = microtime(true) * 100;
				move_uploaded_file($_FILES['save']['tmp_name'][$field[2]],$this->base_root."admin/tmp/".$time.".tmp");
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
				$this->ftp->upload($this->base_root."admin/tmp/".$time.".tmp",  $time.$ext, 'auto', 0 );
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."htdocs/upload/M_15/rek1/");
				$this->ftp->upload($this->base_root."admin/tmp/".$time.".tmp",  $id.$ext, 'auto', 0 );
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."htdocs/upload/M_15/rek2/");
				$this->ftp->upload($this->base_root."admin/tmp/".$time.".tmp",  $id.$ext, 'auto', 0 );
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/tmp/");
				$this->ftp->delete($time.".tmp");
				$old_file = $this->db->query_fetch_single("SELECT ".$field[2]." FROM ".$table." WHERE id=".$id." LIMIT 1;");
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
				if (is_file($this->base_root."uploads/".$old_img[0])) $this->ftp->delete($old_file);
			return $time.$ext;
			}
		}
	}
	public function save_file_lieferung($id,$field, $table, $article_id){

		if (!is_dir($this->base_root."admin/tmp"))  {
			$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/");
			$this->ftp->makeDir("tmp");
			$this->ftp->chmod("tmp",0770);
		}

		if ($_FILES['save']['tmp_name'][$field[2]] != ""){
			$ext = strtolower(end(explode('.', $_FILES['save']['name'][$field[2]])));
			if(!in_array($ext,array('exe','php','php3','bat','com','htm','html'))){
				$ext = ".".$ext;
				$ext=strtolower($ext);
				$time = microtime(true) * 100;
				move_uploaded_file($_FILES['save']['tmp_name'][$field[2]],$this->base_root."admin/tmp/".$time.".tmp");
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
				$this->ftp->upload($this->base_root."admin/tmp/".$time.".tmp",  $time.$ext, 'auto', 0 );
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."htdocs/upload/".$field[3]."/".$field[4]."/");
				$this->ftp->upload($this->base_root."admin/tmp/".$time.".tmp",  $article_id.$ext, 'auto', 0 );
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/tmp/");
				$this->ftp->delete($time.".tmp");
				$old_file = $this->db->query_fetch_single("SELECT ".$field[2]." FROM ".$table." WHERE id=".$id." LIMIT 1;");
				$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
				if (is_file($this->base_root."uploads/".$old_img[0])) $this->ftp->delete($old_file);
			return $time.$ext;
			}
		}
	}

	public function delete_image($id,$field, $table){
		$query = "SELECT ".$field[2]." FROM ".$table." WHERE id=".$id." LIMIT 1";
		$old_img = unserialize($this->db->query_fetch_single($query));
		$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
		if (is_file($this->base_root."uploads/".$old_img[0])) $this->ftp->delete($old_img[0]);
		if (is_file($this->base_root."uploads/".$old_img[1])) $this->ftp->delete($old_img[1]);
		$this->db->query ("UPDATE ".$table." SET ".$field[2]." = '' WHERE id = ".$id.";");

	}
	public function delete_image_article($id,$field, $table){

		$query = "SELECT ".$field[2]." FROM ".$table." WHERE id=".$id." LIMIT 1";
		$old_img = $this->db->query_fetch_single($query);
        $ext = strtolower(end(explode('.', $old_img[$field[2]])));
		$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
		if (is_file($this->base_root."uploads/".$old_img[0])) $this->ftp->delete($old_img[$field[2]]);
		  $this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."htdocs/upload/M_15/rek1/");
	     $this->ftp->delete($id.".".$ext[1]);
		    $this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."htdocs/upload/M_15/rek2/");
		  $this->ftp->delete($id.".".$ext[1]);
		$this->db->query ("UPDATE ".$table." SET ".$field[2]." = '' WHERE id = ".$id.";");

	}

	public function delete_file($id,$field, $table){
		$old_file = $this->db->query_fetch_single("SELECT ".$field[2]." FROM ".$table." WHERE id=".$id." LIMIT 1;");
		$this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
		if (is_file($this->base_root."uploads/".$old_file)) $this->ftp->delete($old_file);
		$this->db->query ("UPDATE ".$table." SET ".$field[2]." = '' WHERE id = ".$id.";");

	}

	public function newEntity($fields=FALSE, $table = FALSE){
		if (!$table) $table = $this->table;
		$query = "INSERT INTO ".$table." (
                    `id` ,
                    `update` ,
                    `editor`";
		if ($this->db->is_field('order', $table)){
			$order =  ", '".($this->db->get_max('order', $table) + 1)."'";
			$query .= " ,
                    `order`";
		}
		$query .= ")VALUES (
                    NULL , NOW( ) , '".$_SESSION["_registry"]["user"]["name"]."'".$order."
                    );
                ";
		return $this->db->lastindex_query($query);
	}
	public function getEditField_DateRangeBig($id,$field,$entity,$isnew){
		if (!isset($field[4])) $format = FALSE;
		else $format = $field[4];
		if ($entity[$field[2]] != "0000-00-00") $from = $this->time->convertDate($entity[$field[2]],$format);
		if ($entity[$field[3]] != "0000-00-00") $till = $this->time->convertDate($entity[$field[3]],$format);
		$html = '<input type="hidden" name="save['.$field[2].']" value="'.$entity[$field[2]].'" id="hidden_'.$field[2].'"/>
                 <input type="hidden" name="save['.$field[3].']" value="'.$entity[$field[3]].'" id="hidden_'.$field[3].'"/>
                 <input type="text" id="show'.$field[2].'" class="" value="'.$from.'" /></td><td> - </td><td><input class="" type="text" id="show'.$field[3].'" value="'.$till.'" />
                 <script>
                    $(function() {
                        var dates = $( "#show'.$field[2].', #show'.$field[3].'" ).datepicker({
                            defaultDate: "",
                            minDate: "",
                            changeMonth: true,
                            numberOfMonths: 1,
                            onSelect: function( selectedDate ) {
                            var option = this.id == "show'.$field[2].'" ? "minDate" : "maxDate",
                            instance = $( this ).data( "datepicker" ),
                            date = $.datepicker.parseDate(
                            instance.settings.dateFormat ||
                            $.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings );
                            dates.not( this ).datepicker( "option", option, date );
                            $("#show'.$field[2].'").datepicker( "option", "altField", "#hidden_'.$field[2].'" );    
                            $("#show'.$field[2].'").datepicker( "option", "dateFormat", "'.$this->time->getFormat_calendar().'" );  
                            $("#show'.$field[2].'").datepicker( "option", "altFormat", "yy-mm-dd" );    
                            $("#show'.$field[3].'").datepicker( "option", "altField", "#hidden_'.$field[3].'" );
                            $("#show'.$field[3].'").datepicker( "option", "dateFormat", "'.$this->time->getFormat_calendar().'" );  
                            $("#show'.$field[3].'").datepicker( "option", "altFormat", "yy-mm-dd" );    
            }
        });
        
    });
                </script>';
		return $html;
	}

	public function getEditField_OrderedBoolSelectRelation($id,$field,$entity,$isnew){
		$items = $this->db->select("SELECT ".$field[3].", ".$field[4].", `order` FROM ".$field[2]." WHERE ".$field[4]." = $id ORDER BY `order`;",MYSQLI_ASSOC,FALSE,$field[3]);
		$query = "SELECT id, ".$field[5]." FROM ".$field[6].";";
		$selects = $this->db->select($query,MYSQLI_ASSOC, FALSE);
		$html = "<table>";
		foreach ($selects as $select){
			$html .= '<tr><td><input type="checkbox" class="small_input" name="save['.$field[1].']['.$select["id"].']" value="'.$select["id"].'" ';
			if (isset($items[$select["id"]][$field[4]]))  $html .= 'checked="checked"';
			$html .= '>'.$select[$field[5]].'</input></td><td><input class="" type="text" name="order['.$field[1].']['.$select["id"].']" value="'.$items[$select["id"]]["order"].'" style="width:20px;"/></td></tr>';
		}
		$html .= '</table>';
		return $html;
	}

	public function getEditField_Hidden($id,$field,$entity,$isnew){
		$html = '<input type="hidden" name="save['.$field[1].']" value="'.$entity[$field[2]].'" />';
		return $html;
	}
/*
	public function getEditField_Html($id,$field,$entity,$isnew){
		global $URL_ROOT;
		$html = '
			<textarea style="" id="text_'.$field[2].'" name="save['.$field[2].']">'.stripslashes($entity[$field[2]]).'</textarea>';
		$html.='<script type="text/javascript">
					 ClassicEditor
        .create( document.querySelector( \'#text_'.$field[2].'\' ) )
        .catch( error => {
            console.error( error );
        } );
				</script>';
		return $html;
	}
	public function getEditField_HtmlMin($id,$field,$entity,$isnew){
		global $URL_ROOT;
		$html = '
			<textarea id="text_'.$field[2].'" name="save['.$field[2].']">'.stripslashes($entity[$field[2]]).'</textarea>';
		$html.='<script type="text/javascript">
					 ClassicEditor
        .create( document.querySelector( \'#text_'.$field[2].'\' ) )
        .catch( error => {
            console.error( error );
        } );
				</script>';
		return $html;
	}
*/
    public function getEditField_Html($id, $field, $entity,  $isnew=false){
        global $URL_ROOT;
        $html = '
   			<textarea class="form-control" style="" id="text_'.$field[2].'" name="save['.$field[2].']" rows="10" data-sample-short>'.stripslashes($entity[$field[2]]).'</textarea>';

        $html.='<script type="text/javascript">

 CKEDITOR.replace("text_'.$field[2].'",{  
  "filebrowserUploadUrl":"'.$URL_ROOT.'upload_sce.php",   });

   				</script>' ;
        return $html;
    }
    public function getEditField_HtmlMin($field, $entity, $isnew=false){
        global $URL_ROOT;
        $html = '
   			<textarea  class="form-control"  id="text_'.$field[2].'" name="save['.$field[2].']">'.stripslashes($entity[$field[2]]).'</textarea>';
        $html.='<script type="text/javascript">
   					 ClassicEditor
           .create( document.querySelector( \'#text_'.$field[2].'\' ) )
           .catch( error => {
               console.error( error );
           } );
   				</script>';
        return $html;
    }

	public function getEditField_Text($id,$field,$entity,$isnew){
		if($isnew==false && $field[3]){
			$this->gen_valid_rule($field[3],$field[2]);
		}
		$html = '<textarea name="save['.$field[2].']" cols="50" rows="10">'.$entity[$field[2]].'</textarea>';
		return $html;
	}


	public function getEditField_Select($id,$field,$entity,$isnew){
		$html = '<select name="save['.$field[2].']" id="'.$field[2].'" class="form-control">
					<option value="0">None</option>';
		foreach ($field[3] as $key => $select){
			$html .= '<option value="'.$key.'"';
			if ($entity[$field[2]] == $key) $html .=' selected="selected"';
			$html .='>'.$select.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	public function getEditField_MultiSelect($id,$field,$entity,$isnew){
		$html = '<select name="save['.$field[2].'][]" id="'.$field[2].'" class="form-control" multiple>';

		foreach ($field[3] as $key => $select){
			$html .= '<option value="'.$select.'"';

			$e1 = $entity[$field[2]];
			$e2 = $select;

			if (strpos($e1, $e2) !== false) $html .=' selected="selected"';
			// echo '<pre>'; var_dump($select); echo '</pre>';
			// if ($explMain[0] == $expl[0]) $html .=' selected="selected"';
			$html .='>'.$select.'</option>';
		}
		$html .= '</select>';
		return $html;
	}


	public function getEditField_TableSelect($id,$field,$entity,$isnew){
		if(is_array($field[3])){
			$query = "SELECT id, ".implode(', ',$field[3])." FROM ".$field[4]." ORDER BY `order`;";
		}else{
			$query = "SELECT id, ".$field[3]." FROM ".$field[4]." ORDER BY `order`;";
		}
		$selects = $this->db->select($query,MYSQLI_ASSOC, FALSE);
		$html = '<select name="save['.$field[2].']" id="'.$field[2].'" class="form-control">';
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


    public function get_opt_tree($tree,$sel,$name,$id,$pre=''){
    	$opt='';
    	foreach($tree as $it){
    		$opt .= '<option value="'.$it['id'].'" ';
            if ($sel == $it['id'])
            	$opt .= 'selected="selected"';
            if($id==$it['id']){
            	$opt .= 'disabled="disabled"';
            }
            $opt .= '>'.$pre.$it[$name].'</option>';
            if(isset($it['sub'])){
            	$thispre=$pre.'&nbsp;&nbsp;&nbsp;';
            	$opt .= $this->get_opt_tree($it['sub'],$sel,$name,$id,$thispre);
            }
    	}
    	return $opt;
    }

    public function getEditField_TableSelectTree($id,$field,$entity,$isnew){
        $query = "SELECT id, ".$field[3].", parent FROM ".$field[4]." ORDER BY parent*1, `order`;";
        $selects = $this->db->select($query,MYSQLI_ASSOC, FALSE);
        $tree=array();
        $tree = $this->_transform2forest($selects,'id','parent');
        $html = '<select name="save['.$field[2].']" id="'.$field[2].'">
                    <option value="">--None--</option>';
        $html .= $this->get_opt_tree($tree, $entity[$field[2]],$field[3],$id);
        $html .= '</select>';
        return $html;
    }
	public function getEditField_TableSelectFilter($id,$field,$entity,$isnew){
		$query = "SELECT id, ".$field[3]." FROM ".$field[4]." WHERE $field[6];";
		$selects = $this->db->select($query,MYSQLI_ASSOC, FALSE);
		$html = '<select name="save['.$field[2].']" id="'.$field[2].'">
                    <option value="">None</option>';
		foreach ($selects as $select){
			$html .= '<option value="'.$select[$field[5]].'" ';
			if ($entity[$field[2]] == $select[$field[5]]) $html .= 'selected="selected"';
			$html .= '>'.$select[$field[3]].'</option>';
		}
		$html .= '</select>';
		if ($field[7])
		$html .=       '
                <script>
                        $( "#'.$field[2].'" ).change(function() {
                            $("#edit_form").submit();
                        });
                </script>';
		return $html;
	}

	public function getEditField_TableSelectWhere($id,$field,$entity,$isnew){
		$query = "SELECT id, ".$field[3]." FROM ".$field[4]." WHERE ".$field[6][0]." ".$field[6][1]." '".$entity[$field[6][2]]."';";
		$selects = $this->db->select($query,MYSQLI_ASSOC, FALSE);
		$html = '<select name="save['.$field[2].']" id="'.$field[2].'">
                    <option value="">None</option>';
		foreach ($selects as $select){
			$html .= '<option value="'.$select[$field[5]].'" ';
			if ($entity[$field[2]] == $select[$field[5]]) $html .= 'selected="selected"';
			$html .= '>'.$select[$field[3]].'</option>';
		}
		$html .= '</select>';
		if ($field[7])
		$html .=       '
                <script>
                        $( "#'.$field[2].'" ).change(function() {
                            $("#edit_form").submit();
                        });
                </script>';
		return $html;
	}

	public function getEditField_Date($id,$field,$entity,$isnew){
		if (!isset($field[4])) $format = FALSE;
		else $format = $field[4];
		if ($entity[$field[2]] != "0000-00-00") $date = $this->time->convertDate($entity[$field[2]],$format);
		if($isnew==false && $field[3]){
			$this->gen_valid_rule($field[3],$field[2]);
		}
		$html = '<input type="hidden" name=save['.$field[2].']" value="'.$entity[$field[2]].'" id="hidden_'.$field[2].'"/>
                 <input type="text" id="show'.$field[2].'" value="'.$date.'" />
                 <script>
                    $(function() {
                        $( "#show'.$field[2].'" ).datepicker({
                            dateFormat: "'.$this->time->getFormat_calendar().'",
                            altField: "#hidden_'.$field[2].'",
                            altFormat: "yy-mm-dd"
                        });
                    });
                </script>';
		return $html;
	}

	public function getEditField_DateRange($id,$field,$entity,$isnew){
		if (!isset($field[4])) $format = FALSE;
		else $format = $field[4];
		if ($entity[$field[2]] != "0000-00-00") $from = $this->time->convertDate($entity[$field[2]],$format);
		if ($entity[$field[3]] != "0000-00-00") $till = $this->time->convertDate($entity[$field[3]],$format);
		$html = '<input type="hidden" name="save['.$field[2].']" value="'.$entity[$field[2]].'" id="hidden_'.$field[2].'"/>
                 <input type="hidden" name="save['.$field[3].']" value="'.$entity[$field[3]].'" id="hidden_'.$field[3].'"/>
                 <input class="" type="text" id="show'.$field[2].'" value="'.$from.'" /> - <input class="" type="text" id="show'.$field[3].'" value="'.$till.'" />
                 <script>
                    $(function() {
                        var dates = $( "#show'.$field[2].', #show'.$field[3].'" ).datepicker({
                            defaultDate: "",
                            minDate: "",
                            changeMonth: true,
                            numberOfMonths: 1,
                            onSelect: function( selectedDate ) {
                            var option = this.id == "show'.$field[2].'" ? "minDate" : "maxDate",
                            instance = $( this ).data( "datepicker" ),
                            date = $.datepicker.parseDate(
                            instance.settings.dateFormat ||
                            $.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings );
                            dates.not( this ).datepicker( "option", option, date );
                            $("#show'.$field[2].'").datepicker( "option", "altField", "#hidden_'.$field[2].'" );    
                            $("#show'.$field[2].'").datepicker( "option", "dateFormat", "'.$this->time->getFormat_calendar().'" );  
                            $("#show'.$field[2].'").datepicker( "option", "altFormat", "yy-mm-dd" );    
                            $("#show'.$field[3].'").datepicker( "option", "altField", "#hidden_'.$field[3].'" );
                            $("#show'.$field[3].'").datepicker( "option", "dateFormat", "'.$this->time->getFormat_calendar().'" );  
                            $("#show'.$field[3].'").datepicker( "option", "altFormat", "yy-mm-dd" );    
            }
        });
        
    });
                </script>';
		return $html;
	}

	public function getEditField_Image($id,$field,$entity,$isnew){
		global $FORM_COUNT;
		$image = new image();
		if($isnew==false && $field[3]){
			$this->gen_valid_rule($field[3],$field[2]);
		}
		if (!$image->is_set($entity[$field[2]])) $html =
            '
            <input type="file" name="save['.$field[2].']" /></td></tr><tr><td>
                      '.$this->lang["image_alt"].' ('.$field[1].')</td><td> <input type="input" name="image['.$field[2].']"  />';
		else{
			$html = $image->get_thumb($entity[$field[2]]);//<input type="file" name="save['.$field[2].']" />
			$html .= '<br />
                      <input type="submit" class="delete_img" name="delete_img'.$FORM_COUNT.'['.$field[2].']" value="delete" /></td></tr><tr><td>
                      '.$this->lang["image_alt"].' ('.$field[1].')</td><td> <input type="input" name="image['.$field[2].']" value="'.$image->get_alt($entity[$field[2]]).'" />';
		}
		return $html;
	}

	public function getEditField_Bool($id,$field,$entity,$isnew){
		$html = '<input type="checkbox" class="small_input" name="save['.$field[2].']" value="1" ';
		if ($entity[$field[2]]) $html .= 'checked="checked" ';
		$html .= "/>";
		return $html;
	}

	public function getEditField_Colorpicker($id,$field,$entity,$isnew){
		$html .= '<input type="hidden" maxlength="6" size="6" id="'.$field[2].'" value="'.$entity[$field[2]].'" name="save['.$field[2].']" />
                    <div id="colorSelector_'.$field[2].'"><div style="background-color: #'.$entity[$field[2]].'; width:25px; height:25px; border: 1px solid black;"></div></div>
                <script>
                    $(\'#colorSelector_'.$field[2].'\').ColorPicker({
                        color: \'#'.$entity[$field[2]].'\',
                        onShow: function (colpkr) {
                            $(colpkr).fadeIn(500);
                            return false;
                        },
                        onHide: function (colpkr) {
                            $(colpkr).fadeOut(500);
                            return false;
                        },
                        onChange: function (hsb, hex, rgb) {
                            $("#'.$field[2].'").val(hex);
                            $("#colorSelector_'.$field[2].' div").css("backgroundColor", "#" + hex);
                        }
                    });
                </script>';
		return $html;
	}

	public function getEditField_BoolSelect($id,$field,$entity,$isnew){
		global $rules;
		$query = "SELECT id, ".$field[4]." FROM ".$field[5].";";
		$selects = $this->db->select($query,MYSQLI_ASSOC, FALSE);
		$items = unserialize($entity[$field[2]]);
		$class='';
		if($isnew==false && $field[3]=='required'){
			$class='valid'.$field[2];
		}
		foreach ($selects as $k=>$select){
			if($k==0){
				$html .= '<span class="first">';
			}
			$html .= '<input type="checkbox" class="small_input '.$class.'" name="save['.$field[2].']['.$select["id"].']" value="1" ';
			if ($items[$select["id"]] == 1)  $html .= 'checked="checked"';
			$html .= '>'.$select[$field[4]].'</input><br>';

			if($isnew==false && $field[3]=='required'){
				$rules[]='"save['.$field[2].']['.$select["id"].']": {mac_require_from_group: [1, ".'.$class.'"]}';
			}
			if($k==0){
				$html .= '</span>';
			}

		}
		return $html;
	}

	public function getEditField_Radio($id,$field,$entity,$isnew){
		if($isnew==false && $field[3]){
			/*?????????????*/
		}
		$selects = $field[4];
		$item = $entity[$field[2]];
		foreach ($selects as $select){
			$html .= '<input type="radio" class="small_input" name="save['.$field[2].']" value="'.$select["id"].'" ';
			if ($item == $select["id"])  $html .= 'checked="checked"';
			$html .= '>'.$select["name"].'</input><br>';
		}
		return $html;
	}


	public function getEditField_BoolSelectRelation($id,$field,$entity,$isnew){
		$items = $this->db->select_pair ($field[2],$field[4],$field[5],FALSE,FALSE, $field[5]."=$id" );
		$query = "SELECT id, ".$field[6]." FROM ".$field[7]." WHERE `status`=1;";
		$selects = $this->db->select($query,MYSQLI_ASSOC, FALSE);
		foreach ($selects as $select){
			$html .= '<input type="checkbox" class="small_input" name="save['.$field[1].']['.$select["id"].']" value="'.$select["id"].'" ';
			if (isset($items[$select["id"]]))  $html .= 'checked="checked"';
			$html .= '>'.$select[$field[6]].'</input><br>';
		}
		return $html;
	}

	public function getEditField_Info($id,$field,$entity,$isnew){
		$html = '<input class="" type="text" readonly="readonly" name="save['.$field[2].']" value="'.$entity[$field[2]].'" />';
		return $html;
	}

	public function getEditField_File($id,$field,$entity,$isnew){
		$FILENAME = $this->base_root."uploads/".$entity[$field[2]];
		$val_save = $field[2];
		if (!is_file($FILENAME)){
			if($isnew==false && $field[3]){
				$this->gen_valid_rule($field[3],$field[2]);
			}
			$html = '<input type="file" class="form-control" name="save['.$val_save.']">';
			return $html;
		}

		$info[]=array("jpg","Image");
		$info[]=array("gif","Image");
		$info[]=array("png","Image");
		$info[]=array("pdf","PDF-File");
		$info[]=array("zip","Compressed File");
		$info[]=array("htm","HTML-File");
		$info[]=array("html","HTML-File");
		$info[]=array("doc","Word Document");
		$info[]=array("rar","Compressed File");
		$info[]=array("txt","Text-File");
		$info[]=array("mp3","MP3 Music-file");
		$info[]=array("exe","Executable file");
		$info[]=array("tar","Tar Compressed file");
		$info[]=array("swf","Flash file");

		$ext=substr($FILENAME,-3);
		$ext2=substr($FILENAME,-4);
		if ($ext2[0]!=".")  $ext=$ext2;
		$ext=strtolower($ext);
		for ($t=0;$t<count($info);$t++)
		{   if ($ext==$info[$t][0])
		{   $html .= $info[$t][0].' - '.$info[$t][1];
		if ($info[$t][1]=="Image")
		{   $image = new ImageEditor();
		$image->loadImageFile($FILENAME);
		$fsize=filesize($FILENAME);
		$units="Bytes";
		if ($fsize>1024)
		{   $units="KBytes";
		$fsize=round(($fsize/1024)*100)/100;
		}
		if ($fsize>1024)
		{   $units="MBytes";
		$fsize=round(($fsize/1024)*100)/100;
		}
		$html .= '&nbsp;&nbsp;Gr&ouml;&szlig;e: '.$image->width.'x'.$image->height.' ('.$fsize.' '.$units.')<br/>';
		$html .= '       <a href="'.$this->base_url.'uploads/'.$entity[$field[2]].'" rel="shadowbox">
                                                    <img src="'.$this->base_url.'uploads/'.$entity[$field[2]].'" style="width:200px;" />                  
                                                </a><br>
                                                <input type="submit" name="delete_file'.$FORM_COUNT.'['.$field[2].']" value="delete" />';
		} else
		{   $fsize=filesize($FILENAME);
		$units="Bytes";
		if ($fsize>1000)
		{   $units="KBytes";
		$fsize=round(($fsize/1024)*100)/100;
		}
		if ($fsize>1000)
		{   $units="MBytes";
		$fsize=round(($fsize/1024)*100)/100;
		}
		$html .= '&nbsp;&nbsp;Gr&ouml;&szlig;e: '.$fsize.' '.$units.'<br>';
		$html .= '<a href="'.$this->base_url.'uploads/'.$entity[$field[2]].'">[download]</a><br>
                                          <input type="submit" name="delete_file'.$FORM_COUNT.'['.$field[2].']" value="delete" />';
		}
		return $html;
		}
		}
		$html .= '*.'.$ext.' - unbekannter Dateityp';
		$fsize=filesize($FILENAME);
		$units="Bytes";
		if ($fsize>1000)
		{   $units="KBytes";
		$fsize=round(($fsize/1024)*100)/100;
		}
		if ($fsize>1000)
		{   $units="MBytes";
		$fsize=round(($fsize/1024)*100)/100;
		}
		$html .= '&nbsp;&nbsp;Gr&ouml;&szlig;e: '.$fsize.' '.$units.'<br>';
		$html .= '<a href="'.$this->base_url.'uploads/'.$entity[$field[2]].'">[download]</a><br>
                  <input type="submit" name="delete_file'.$FORM_COUNT.'['.$field[2].']" value="delete" />';
		return $html;
	}
	public function getEditField_InputsRelation($id,$field,$entity,$isnew){
		function get_box($name,$value,$id,$limit,$base_url){
			$html = '
<textarea id="'.$id.'" name="'.$name.'">'.$value.'</textarea>
<script type="text/javascript">
var hb_min_'.$id.' = $("#'.$id.'").css("height","'.($limit / 10).'px").htmlbox({
        toolbars:[
        [
        // Bold, Italic, Underline, Strikethrough, Sup, Sub
        "separator","bold","italic","underline","strike","sup","sub",
        // Left, Right, Center, Justify
        "separator","justify","left","center","right",      
                //Strip tags
        "separator","removeformat",
                // Hyperlink, Remove Hyperlink
        "separator","link","unlink" 
            ]
    ],
    idir:"'.$base_url.'admin/js/HtmlBox/images",    
    limit:'.$limit.',
    skin:"blue",
        about: false
});  
</script>
';
			return $html;
		}
		$items = $this->db->select("SELECT ".$field[3].", ".$field[4].", value FROM ".$field[2]." WHERE ".$field[4]." = $id ;",MYSQLI_ASSOC,FALSE,$field[3]);
		$query = "SELECT id, ".$field[5]." FROM merkmale_cats_rel JOIN merkmale WHERE cat_id = ".$entity["parent"]." AND id = merkmal_id ORDER BY `order`;";
		$selects = $this->db->select($query,MYSQLI_ASSOC, FALSE);
		$html = "<table>";
		foreach ($selects as $select){
			$html .= '<tr><td>'.$select[$field[5]].'</td></tr><tr><td>'.get_box('save['.$field[1].']['.$select["id"].']',$items[$select["id"]]['value'],$select["id"],$field[7],$this->base_url).'</td></tr>';
		}
		$html .= '</table>';
		return $html;
	}

	public function getAvCount($article_id=null,$condition_id=null){
        $article_id=(int)$article_id;
        $condition_id=(int)$condition_id;
        $limit='';
        $order='';
        $sqlSUM='SUM';
        if($condition_id==10){
            $sqlSUM='';
            $limit=' LIMIT 1';
            $order=' ORDER BY shipment_arrival ASC';
        }
        $sql='SELECT '.$sqlSUM.'(shipment_quantity) as count_items FROM shipment WHERE shipment_condition='.$condition_id.' AND shipment_article='.$article_id.$order.$limit;
        $res=$this->db->query_fetch($sql);
        if(!$res){

            return false;
        }
        $count=0;
        $row= $res;
        $count=$row['count_items'];

        //admin reserved
        $formData=$this->_getXmlBkData($article_id,$condition_id);
        if($formData!==false && !empty($formData['admin_reserved'])){
            $count-=$formData['admin_reserved'];
        }

        $res=$this->db->query_fetch('SELECT SUM(count) as count FROM auctions WHERE article_id='.$article_id.' AND condition_id='.$condition_id.' AND `lock`!=2 AND `lock` !=0');
        if($res){
            $row=$res;
            $count-=$row['count'];
        }
        $sql='SELECT SUM(Sell.selling_noofarticle) as count FROM shipment Ship
                LEFT JOIN shipment_sellings Sell ON(Ship.id=Sell.selling_shipment)
                WHERE Ship.shipment_condition='.$condition_id.' AND Ship.shipment_article='.$article_id;
        $res=$this->db->query_fetch($sql);
        if($res){
            $row=$res;
            $count-=$row['count'];
        }
        return $count;
    }

    public  function _getXmlBkData($artId,$condId){
        if(!empty($this->_formData[$artId][$condId])){
            return $this->_formData[$artId][$condId];
        }
        $sql='SELECT xml_backup_garantie_admin admin_reserved, xml_backup_vippm vip_marge,xml_backup_auktion_startpreis_vip vip_start_price FROM xml_backup WHERE xml_backup_artikel_id='.$artId.' AND xml_backup_condition_id='.$condId;
        $res=$this->db->query_fetch($sql);
        if(!$res){
            return false;
        }
        $data=$res;
        $this->_formData[$artId][$condId]=$data;
        return $data;
        }

        public  function _getSellCount($article_id,$condition_id){
            $price=null;
            $res=$this->db->query('SELECT count_sell FROM reserved_for_catalog WHERE id='.(int)$article_id.' AND condition_id='.(int)$condition_id.' LIMIT 1');
            if(!$res){
                return false;
            }

            return $res['count_sell'];
        }


        /** Cockpit  */
    function getArticleInfo($article_id){
        $articleInfo=array();
        $articleInfo= $this->db->query_fetch('SELECT article_name_de name, id ,anbieter_id, short_desc_de short_description, long_desc_de long_description,min_margin
                FROM termek
                WHERE id='.$article_id.' '.$this->_getAnbieterCondition().'
                LIMIT 1');

        if(empty($articleInfo)){
            return false;
        }
        $res= $this->db->query_fetch('SELECT name FROM sellers WHERE id='.(int)$articleInfo['anbieter_id'].' LIMIT 1');

        $seller='';
        if($res){
            $seller=$seller['name'];
        }
        $articleInfo['seller']=$seller;
        $articleInfo['lotmenge']=$this->_getLotmenge();
        $articleInfo['min_margin']*=1;
        $this->articleInfo=$articleInfo;
        return $articleInfo;
    }

    private function _getAnbieterCondition($pref=null,$post='anbieter_id'){
        if(empty($this->anbieterId)){
            return false;
        }
        if(!empty($pref)){
            $pref.='.';
        }
        $sql=' AND '.$pref.$post.'='.$this->anbieterId;
        return $sql;
    }



        /* End Cockpit */
}
?>