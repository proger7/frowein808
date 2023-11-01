<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/domains_modul.php";
$modul = new domains_modul();
$fields = array(
    array("TableSelect","Produktverknüpfung","download_text_id","download_title","download_text","id"),
    array("Input","Domainname (www.domain.de)","domain_name"),
    array("ColorPicker","Farbe Balken","farbe_balken"),
    array("ColorPicker","Farbe Textfeld","farbe_text"),
    array("Input","&Uuml;berschrift 1","titel1"),
    array("ColorPicker","&Uuml;berschrift 1 Farbe","titel1_farbe"),
    array("ColorPicker","&Uuml;berschrift 1 Hintergrund","titel1_bgfarbe"),
    array("Input","&Uuml;berschrift 2","titel2"),
    array("ColorPicker","&Uuml;berschrift 2 Farbe","titel2_farbe"),
    array("ColorPicker","&Uuml;berschrift 2 Hintergrund","titel2_bgfarbe"),
    array("HTML","Text oben","text1"),
    array("HTML","Text unten","text2"),
    array("Image","Bild","domain_bild"),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
