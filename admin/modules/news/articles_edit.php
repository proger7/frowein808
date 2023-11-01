<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/articles_modul.php";
$modul = new articles_modul();
$fields = array(
    array("Select","Sprache","language_id",array(1=>"deutsch",2=>"english")),
    array("Select","Bereich","news_mainpage",array(0=>"&Ouml;ffentlich",1=>"Partner-Net")),
    // array("Bool","Archiv","news_archiv"),
    array("Input","Titel","news_headline"),
    array("Html","News","news_subline",4096),
    array("File","News-PDF","news_pdf"),
    array("File","News-Bild","news_picture"),
    array("Input","News-Link 1","news_link1"),
    array("Input","News-Link 2","news_link2"),
    array("Input","Tags","news_tags"),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
