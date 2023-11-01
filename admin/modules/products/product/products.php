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
    array("Status","Status","status"),
    array("Table","Kategorie","category","name","products_categories","id"),
    array("Input","Produkt","name"),
    array("Select","Tags","product_tags", $arr),
    );
$buttons = array("Order","Edit","Copy","Delete","Status");
echo $modul->listTable($fields,FALSE,$buttons)
?>
