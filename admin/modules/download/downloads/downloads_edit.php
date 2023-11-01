<?php


include pathinfo(__FILE__,PATHINFO_DIRNAME)."/downloads_modul.php";
$modul = new downloads_modul();
$fields = array(
	array("Select","Sprache","language_id",array(1=>"deutsch",2=>"english")),
	array("TableSelect","Kategorie","download_cat_id","cat_name","download_categories","id"),
	array("Input","Typ","download_typ"),
    array("Text","Titel","download_title"),
	array("File","Produktinformation","download_file1"),
    array("File","Sicherheitsdatenblatt","download_file2"),
	array("File","Gebrauchsanweisung","download_file3"),
	array("File","Packungsbeilage","download_file4"),
	array("Input","key_account_ids","key_account_ids")
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
