<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/bestell_modul.php";
$modul = new bestell_modul();
$fields = array(
    array("TableSelect","Kategorie","news_cat_id","cat_name","orderinfo_categories","id"),
	array("Select","Sprache","language_id",array(1=>"deutsch",2=>"english")),
    array("Input","Titel","news_headline"),
    array("Text","Text","news_subline"),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
