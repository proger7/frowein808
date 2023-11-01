<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/categories_modul.php";
$modul = new categories_modul();
$fields = array(
    array("Input","Name","name"),
    array("Input","Überschrift","headline"),
    array("HTMLMin","Kurztext","short_text",1024),
    array("HTML","Beschreibung","description",4096),
    array("Input","Name EN","name_en"),
    array("Input","Überschrift EN","headline_en"),
    array("HTMLMin","Kurztext EN","short_text_en",1024),
    array("HTML","Beschreibung EN","description_en",4096),
    array("Image","Kategorie Bild","cat_image"),
    array("File","Hintergrund","background")
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
