<?php
include_once 'includes/classes/modul.class.php';
class datenschutz_modul extends modul{
    function __construct(){
        $this->init();
        $this->path             = pathinfo(__FILE__,PATHINFO_DIRNAME)."/";
        $this->lang["module"]   = parse_ini_file( $this->path."localisation/de.ini");
        $this->table            = "datenschutz_text";
		$this->config			= parse_ini_file( $this->path."modul.ini");
		$this->permission		= $this->config["permission"];
    }
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
}
?>
