<?php
include_once 'includes/classes/modul.class.php';
class settings_modul extends modul{   
    function __construct(){
        $this->init();
        $this->path             = pathinfo(__FILE__,PATHINFO_DIRNAME)."/";
        $this->lang["module"]   = parse_ini_file( $this->path."localisation/de.ini");
        $this->table            = "newsletter_settings";
		$this->config			= parse_ini_file( $this->path."modul.ini");
		$this->permission		= $this->config["permission"];
    }
    public function getEditField_SelectValue($id,$field,$entity){
        $query = "SELECT `value` FROM permissions WHERE permission='".$field[3]."' AND type=1";
        $selects = $this->db->select($query,MYSQLI_ASSOC, FALSE);
        $html = '<select name="save['.$field[2].']" id="'.$field[2].'">
                    <option value="">None</option>';
        foreach ($selects as $select){
            $html .= '<option value="'.$select["value"].'" ';
                if ($entity[$field[2]] == $select["value"]) $html .= 'selected="selected"';
            $html .= '>'.$select["value"].'</option>';
        }
        $html .= '</select>';
        return $html;
    }
}
?>
