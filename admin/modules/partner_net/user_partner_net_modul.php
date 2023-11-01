<style>

    #page_navi a div {
        float: left;
        border: 1px solid #cecece;
        padding: 5px 0;
        margin-right: 5px;
        cursor: pointer;
        width: 35px;
        text-align: center;
        margin-top: 5px;
    }
    #page_navi a {
        float: left;
    }
</style>

<?php
include_once 'includes/classes/modul.class.php';
class user_partner_net_modul extends modul{
    function __construct(){
        $this->init();
        $this->path             = pathinfo(__FILE__,PATHINFO_DIRNAME)."/";
        $this->lang["module"]   = parse_ini_file( $this->path."localisation/de.ini");
        $this->table            = "newsletter_users";
		$this->config			= parse_ini_file( $this->path."modul.ini");
		$this->permission		= $this->config["permission"];
    }

/*
    public function listTable($fields,$filters=FALSE,$buttons=FALSE,$extraButtons = FALSE, $table = FALSE){
        $_SESSION["_registry"]["variables"]["backlink"] = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
        $this->extraButtons = $extraButtons;
        $req_table = $this->getTable($fields,$filters,$table);
        $entity_count = count($req_table);
        if (isset($_GET["start"]))
            $start = $_GET["start"] + 1;
        else
            $start = 1;
        if (isset($_GET["value"]))
            $value = $_GET["value"];
        else
            $value = 10;
        $last = $entity_count ;
        $sites = ceil($entity_count / $value);
        $actual_site = ceil($start / $value);
        $req_table =  array_slice ( $req_table , $start - 1 , $value , true);

        $value_select = '
        <form action="" method="get" id="form_value">
            <input type="hidden" name="start" value="'.$start.'"/>
            <input type="hidden" name="search" value="'.$_GET["search"].'"/>
            <input type="hidden" name="order" value="'.$_GET["order"].'"/>
            <input type="hidden" name="direction" value="'.$_GET["direction"].'"/>
            <input type="hidden" name="" value="'.$_GET["lang"].'"/>
            '.$this->lang["site"].' '.$actual_site.' '.$this->lang["from"].' '.$sites.' | 
            <select name="value" id="value_select">
                 <option ';
                    if($value == 10)
                        $value_select .= 'selected="selected" ';
                    $value_select .= ' value="10">10</option> 
                <option '; if($value == 25)$value_select .= 'selected="selected" '; $value_select .= 'value="25">25</option>
                <option '; if($value == 50)$value_select .= 'selected="selected" '; $value_select .= 'value="50">50</option>
                <option '; if($value == 100)$value_select .= 'selected="selected" '; $value_select .= 'value="100">100</option>
                <option '; if($value == 250)$value_select .= 'selected="selected" '; $value_select .= 'value="250">250</option>
                <option '; if($value == 500)$value_select .= 'selected="selected" '; $value_select .= 'value="500">500</option>
            </select>
             '.$this->lang["entities_p_site"].' ('.$this->lang["entities_total"].': '.$entity_count.')
        </form>
        <script type="text/javascript">$("#value_select").change(function(){$("#form_value").submit();});</script>
        ';

        $html = '
                    <div class="row">
                    <div class="col-lg-12">
                        <h2>'.$this->lang["module"]["available_entitys"].'</h2></div>
                    </div>';
        $html .= '</form>';
        if ($this->permissions->hasPermission($this->permission.".del"))
            $html .= '
            <div class="row" style="margin-bottom:15px">
                <div class="col-lg-12">  
                    <form action="?edit=none" method="post">';
                    if ($this->permissions->hasPermission($this->permission.".edit"))
                        $html .= '<input  type="submit" class="btn btn-primary" value="Neuer Entrage" style="float:left"  />
                    </form>            
                        <input type="button" src="https://www.frowein808.de/admin/img/button_delete_mass_de.png" name="delete_mass" id="delete_mass" class="btn btn-primary" style="margin-left:6px;float:left" value="markierte Einträge löschen">
                    <script type="text/javascript">
                        $("#delete_mass").click(function() {
                            delete_mass(\''.$this->table.'\');
                        });
                    </script>
                    <input  type="button"   class="btn btn-primary" style="margin-left:6px;"  value="Aktualisieren"  name="reload" onClick="location.reload();">
                </div> 
            </div> ';
        $html .='
                    <div class="row">
                        <div class="col-lg-9">
                        '.$value_select.'
</div>
                        <div class="col-lg-3 toright" style="text-align: right"> 
                                <form id="search" name="search" action="" method="get"> 
                                    <input type="hidden" name="lang" value="'.$_GET["lang"].'">
                                    <input type="text" name="search" value="'.$_GET["search"].'">&nbsp;<img src="'.$this->base_url.'admin/img/button_search.png" style="cursor:pointer;" onclick="document.search.submit();"> 
                                </form> 
</div>
                    </div>
';

        if (isset($this->extraButtons["Lang"])){
            if (isset($_GET["lang"]) && $_GET["lang"] != "") $lang = $_GET["lang"]; else  $lang = 1;
            if ($lang == 1){
                $html .= '<a href="?lang=2" ><img style="margin-bottom:-10px;" src="'.$this->base_url.'admin/img/langswitcher_de.png" style="cursor:pointer;"></a>';
            }
            else if ($lang == 2){
                $html .= '<a href="?lang=1" ><img style="margin-bottom:-10px;" src="'.$this->base_url.'admin/img/langswitcher_en.png" style="cursor:pointer;"></a>';
            }
        }
        $html .= '         <table id="tableListing" class="sortmode table dataTable no-footer" role="grid" cellspacing="0" cellpadding="0">
                        <tr><td><font style="font-size:8px;">&nbsp;</font></td></tr>
                        <tr style="background-color:#FFF;">
                            <th style="text-align: left;"></th>';
        if ($fields){
            $first = TRUE;
            foreach($fields as $field){
                $html .= '
                            <th>&nbsp;<a href="?order='.$field[2].'&start='.$_GET["start"].'&search='.$_GET["search"].'&direction=';
                if (isset($_GET["direction"]) && $_GET["direction"] == "ASC" && isset($_GET["order"]) && $_GET["order"] == $field[2]) $html.= "DESC"; else $html .= "ASC";
                $html .= '">'.$field[1].'</a>&nbsp;</th>';
            }
            $i = 1;
            foreach ($buttons as $button){
                $html .= '  <th style="text-align: right;">';
                if ($i == count($buttons)) $html .= '';
                $html .= '</th> ';
                $i++;
            }
            $html .= '  
                        </tr><tr><td><font style="font-size:8px;">&nbsp;</font></td></tr><tr>';
            $i = 1;
            foreach ($req_table as $row){
                $html .= '
                        <tr';

                $html .= '>
                            <td><input type="checkbox" name="marked[]" value="'.$row["id"].'" /></td>';
                foreach ($fields as $field){
                    if ($field[0] != "Input") {
                        $call = "getField"."_".$field[0];
                        $fieldData = $this->$call($field,$row);
                    }
                    else $fieldData = $row[$field[2]];
                    $html .= '
                                <td>'.$fieldData.'</td>';
                }
                if (is_array($buttons)){
                    foreach ($buttons as $button){
                        $call = "getButton"."_".$button;
                        $fieldData = $this->$call($row);
                        if ($fieldData)
                            $html .= '
                                    <td>'.$fieldData.'</td>';
                    }
                }
                $html .= '
                        </tr>';
                $i++;
            }

        }
        $html .= '
                    </table>
                    
                    </form> 
<form action="?edit=none" method="post">';


        if ($sites > 1){
            $html .= '        <div class="row">
                                    <div clacc="col-lg-12">
                                            <div id="page_navi" style="margin-top:10px;">';
                                                    if ($actual_site > 1) {
                                                        $html .= '<a href="?start=0"><div> Erste </div></a>';
                                                        //$html .= '<a href="?start=' . (($actual_site * 10) - 10) . '"><div> << </div></a>';
                                                    }
                                                    if ($actual_site < 40) {
                                                        $start_site = 1;
                                                    } else {
                                                        $start_site = $actual_site - 10;
                                                    }
                                                    if ($start_site < 1) {
                                                        $start_site = 1;
                                                    }
                                                    for ($start_site; $start_site <= $sites; $start_site ++){
                                                        if ($start_site > 40 && $start_site - $actual_site >= 10) {
                                                            break;
                                                        }
                                                        if ($start_site < 40 && $start_site  > 39) {
                                                            break;
                                                        }
                                                        $start= $start_site * $value - $value;
                                                        if ($actual_site != $start_site) {
                                                            $html .= ' <a href="?value=' . $value . '&start=' . $start . '&search=' . $_GET["search"] . '&order=' . $_GET["order"] . '&direction=' . $_GET["direction"] . '&lang=' . $_GET["lang"] . '"><div>' . $start_site . '</div></a>';
                                                        }
                                                        else {
                                                            $html .= '<a><div style="border:none"><b style="color:#000">' . $start_site . '</b></div></a>';
                                                        }
                                                    }
                                                    if ($actual_site < $sites)
                                                        $html .='<a href="?start='.$start.'"><div> >> </div</a>';
                            $html .= ' 
                                            </div>
                                    </div>
                                    </div>
                            </div>';
        }
        return $html;
    }
*/
    public function listTable($fields,$filters=FALSE,$buttons=FALSE,$extraButtons = FALSE, $table = FALSE, $tree = FALSE){

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

        $list_fields = array(  "status" => "Status", "id" => "ID",  "kundennummer" => "Kundenummer",  "user_nachname" => "Nachname", "user_name" => "Firstname", "update_type" => "Import by");
        $html .= '</div><br clear="all"><br clear="all"><div class="table-responsive">

<table id="tableListing" cellspacing="0" cellpadding="0" class="'.$tableclass.' table">
            	<thead>
                	<tr>';


        if ($list_fields){
            foreach($list_fields as $key=>$val){
                $html .='<th>'.$val.'</th>';
            }
            $html .= '<th></th>';
            $html .= '</tr>
				</thead>
			<tbody>';

        }
        $html .= '</tbody>
			</table></div><br>
		';
        $rowstr['y'] = '{ "bSortable": false },';
        $rowstr['n'] = 'null,';
        if($tree){

        }else{

$html .='
<script type="text/javascript">

$(document).ready(function(){
        function loadDatatable(){
        if($.fn.dataTable.isDataTable("#tableListing")){
            $("#tableListing").DataTable().destroy();
        }
        var datatable = $("#tableListing").DataTable({
            locale: "de",

            "aoColumnDefs": [
                { "bSortable": true, "aTargets": [ 0,1,2] },
                { "sWidth": "40px", "targets": [  0,1,2] },
                { "sWidth": "65px", "targets": [  6] }
            ],
            "lengthMenu": [ 10, 25, 50, 75, 100 ],
            "processing": true,
            "serverSide": true,
            "ajax": {
            "url": "/serverProcessingNewsletterUsers.php?server=true",
                "data": {
                "table": "newsletter_users"
                }
            },
            "oLanguage": {
            "sUrl": "https://www.frowein808.de/admin/js/datatables/dataTables..txt",

            }
        });
    }
    loadDatatable();
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
});
</script>
';
        }

        return $html;
    }
    public function getTable($fields=FALSE,$filters=FALSE, $table = FALSE){
        if (isset($_GET["search"]) && $_GET["search"] != "") $search = $_GET["search"]; else $search = FALSE;
        if (isset($this->extraButtons["Lang"])){
            if (isset($_GET["lang"]) && $_GET["lang"] != "") $lang = $_GET["lang"]; else  $lang = 1;
        }
        if (isset($_GET["order"]) && $_GET["order"] != "") $order = $_GET["order"];
        else if(!$NOORDER && $this->db->is_field('order', $this->table)) $order = "order";
        else $order = FALSE;
        if (isset($_GET["direction"]) && $_GET["direction"] != "") $direction = $_GET["direction"]; else $direction = 'ASC';
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



            if ($order){
                $query .= ' ORDER BY `'.$order.'` '.$direction;
            }
            $query .= ';';
            return $this->db->select($query);
        }
    }

}
?>
