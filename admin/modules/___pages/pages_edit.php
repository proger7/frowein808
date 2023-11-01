<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/pages_modul.php";
$modul = new pages_modul();
$fields = array(
    array("Input","Titel","title","required"),
	//array("Radio","Status","status", array(array('id'=>1, 'name'=>'df'),array('id'=>3, 'name'=>'asdf'))),
    array("HTML","Text","text"),
    array("Input","Custom path","url"),
    array("Input","SEO Titel","seo_title"),
    array("Input","SEO Keywords","seo_keywords"),
    array("Input","SEO Description","seo_desc"),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
