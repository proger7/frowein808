<?php
include_once 'includes/classes/modul.class.php';
class filters_modul extends modul{   
    function __construct(){
        $this->init();
        $this->path             = pathinfo(__FILE__,PATHINFO_DIRNAME)."/";
        $this->lang["module"]   = parse_ini_file( $this->path."localisation/de.ini");
        $this->table            = "products_filters";
		$this->config			= parse_ini_file( $this->path."modul.ini");
		$this->permission		= $this->config["permission"];
    }
}
?>
