<?php
include_once 'includes/classes/modul.class.php';
class bestell_modul extends modul{   
    function __construct(){
        $this->init();
        $this->path             = pathinfo(__FILE__,PATHINFO_DIRNAME)."/";
        $this->lang["module"]   = parse_ini_file( $this->path."localisation/de.ini");
        $this->table            = "orderinfo_text";
		$this->config			= parse_ini_file( $this->path."modul.ini");
		$this->permission		= $this->config["permission"];
    }
}
?>
