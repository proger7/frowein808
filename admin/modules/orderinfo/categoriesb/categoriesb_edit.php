<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/categoriesb_modul.php";
$modul = new categoriesb_modul();
$fields = array(
    array("Input","Kategorie","cat_name"),
	array("Select","Sprache","language_id",array(1=>"deutsch",2=>"english")),
    array("Text","Beschreibung","cat_text"),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
