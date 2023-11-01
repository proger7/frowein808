<?php
include pathinfo(__FILE__,PATHINFO_DIRNAME)."/products_modul.php";


$tags = $DB->select("SELECT id,name,comment FROM `products_filters`;");
$arr = [];
foreach ($tags as $key => $tag) {
    $arr[0] = '';
    $arr[$key+1] = $tag['name'];
}


$modul = new products_modul();
$fields = array(
    array("TableSelect","Kategorie","category","name","products_categories","id"),
    // array("Select","Color","class_color",array('red'=> 'red', 'green' => 'green')),
    // array("Bool","nicht lieferbar","oos"),
    array("Input","SEO Url","seo_url"),
    array("Input","Name","name"),
    array("Input","Artikel ID","article_id"),
    array("Html","Info","red_text"),
    array("Html","Beschreibung","description",8000),
    array("Html","Kurze Beschreibung","short_description",8000),
    array("Html","Besonderheiten","tab_text",8000),
    array("Input","Name EN","name_en"),
    array("Html","Info EN","red_text_en"),
    array("Html","Beschreibung EN","description_en",8000),
    array("Html","Kurze Beschreibung EN","short_description_en",8000),
    array("Html","Besonderheiten EN","tab_text_en",8000),
    array("Image","Bild","image"),
    array("Image","Bild","image2"),
    array("Image","Bild","image3"),
    array("Image","Bild","image4"),
    array("File","Sicherheitsdatenblätter(DE) 1","pdf_file1_de"),
    array("File","Sicherheitsdatenblätter(DE) 2","pdf_file2_de"),
    array("File","Sicherheitsdatenblätter(DE) 3","pdf_file3_de"),
    array("File","Sicherheitsdatenblätter(EN) 1","pdf_file1_en"),
    array("File","Sicherheitsdatenblätter(EN) 2","pdf_file2_en"),
    array("File","Sicherheitsdatenblätter(EN) 3","pdf_file3_en"),
    // array("Input","Tags","product_tags"),
    array("MultiSelect","Tags","product_tags", $arr),
    );
echo $modul->showEntity($_GET["edit"], $fields);
?>
