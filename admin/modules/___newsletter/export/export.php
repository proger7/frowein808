<?php
$_SESSION["_registry"]["variables"]["backlink"] = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$categories = $DB->select("SELECT * FROM `newsletter_interestgroup`;");
echo 'Wählen sie die zu exportierenden Interessengruppen.';
echo '<form action="'.$URL_ROOT.'admin/includes/ajax.php" method="post"><input type="hidden" name="action" value="export" />';
foreach ($categories as $category){
	echo '<input type="checkbox" name="cats['.$category["group_name"].']" value="'.$category["id"].'">'.$category["group_name"].'<br>';
}
echo '<input type="submit" name="export" value="exportieren"></form>';
?>
