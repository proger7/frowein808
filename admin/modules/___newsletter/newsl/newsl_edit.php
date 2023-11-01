<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/newsl_modul.php";
$modul = new newsl_modul();
$fields = array(
		array("Select","Sprache","language_id",array(1=>"deutsch",2=>"english")),
        array("Date","Datum","letter_date"),
        array("Input","Betreff","letter_subject"),
        array("Html","Text","letter_text",4096),
        array("File","Bild","letter_picture"),
        array("Select","Bildausrichtung","letter_picalign",array(1=>"rechts",0=>"links")),
        array("File","Anhang 1","letter_append"),
        array("File","Anhang 2","letter_append2"),
        array("File","Anhang 3","letter_append3"),
        array("BoolSelect","Interessengruppe","letter_interests","group_name","newsletter_interestgroup","id"),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
