<?php 

require("./../includes/general.inc.php");

if($LANG["language"]["shortname"] == "de" || $LANG["language"]["shortname"] == "") {
  $langLink = 'de';
  $mehr = "Alle Kategorien anzeigen";
} elseif($LANG["language"]["shortname"] == "en") {
  $langLink = 'en';
  $mehr = "Show all categories";
}


$p = $_POST['product_id'];
$b = $_POST['cat_checker'];

switch ($langLink) {
	case "de":
		if( !empty($p) ) {
			$query = "SELECT t1.name,t2.cat_image as product_name,t2.name as product_cat,t1.image,t1.seo_url, t2.short_text as category_description FROM products as t1 JOIN products_categories as t2 ON t1.category = t2.id WHERE t1.status = 1 AND t1.name != '' AND t2.name = '" . $p . "' ORDER BY t1.update DESC LIMIT 1";
		} elseif( !empty($b) ) {
			$query = "SELECT name as product_name,short_text as q_cat,cat_image FROM products_categories WHERE status = 1 AND (`order` % 2) = 0 ORDER BY `order` ";
		}
	break;
	case "en":
		if( !empty($p) ) {
			$query = "SELECT t1.name_en,t2.cat_image as product_name,t2.name_en as product_cat,t1.image,t1.seo_url, t2.short_text_en as category_description FROM products as t1 JOIN products_categories as t2 ON t1.category = t2.id WHERE t1.status = 1 AND t1.name_en != '' AND t2.name_en = '" . $p . "' ORDER BY t1.update DESC LIMIT 1";
		} elseif( !empty($b) ) {
			$query = "SELECT name_en as product_name,short_text_en as q_cat,cat_image FROM products_categories WHERE status = 1 AND (`order` % 2) = 0 ORDER BY `order` ";
		}
	break;
}




$menuProducts = $DB->select($query);
?>

<?php if( !empty($p) ) { ?>
	<?php $img = $IMAGE->get_image($menuProducts[0]['product_name']);?>
	<?php echo $img;?>	
	<p class="submenu__content"><?php echo $menuProducts[0]['category_description'] ?></p>
<?php } elseif( !empty($b) ) {
	foreach($menuProducts as $key => $product):
		$link = '/' . $langLink . '/products/' .$product['product_name'];
		$img = $IMAGE->get_image($product['cat_image']);
		?>
		<div class="row mb-2 subCategoriesItems" style="border: 1px solid #dee2e6;">
			<div class="col-md-4 col-sm-12 col-12 p-2">
				<?php //echo $img ?>

                        <?php 
                        switch ($key) {
                          case 0:
                            $imgIcon = '<img src="/images/products/nav/category_icons/SPEZIALPRODUKTEicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 1:
                            $imgIcon = '<img src="/images/products/nav/category_icons/TAUBENABWEHRicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 2:
                            $imgIcon = '<img src="/images/products/nav/category_icons/DEZINFKTIONSPFLGEMITTEL icon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                        }

                        ?>
				
			</div>
			<div class="col-md-8 col-sm-12 col-12 pt-2" id="verticallyCenter">
				<a href="<?php echo $link ?>" class="sub__cat-title"><?php echo $product['product_name'] ?></a>
				<p class="sub__cat-content"><?php echo strip_tags($product['q_cat']) ?></p>
			</div>
		</div>
	<?php endforeach; ?>

	<?php if( !empty($menuProducts) && count($menuProducts) >= 5 ): ?>
		  <?php $mehrLink = '/' . $langLink . '/products/'; ?>
	      <ul class="submenu_sub-items py-2">
	        <li><a style="color: #e3001b" href="<?php echo $mehrLink; ?>"><?php echo $mehr; ?></a></li>
	      </ul>
	<?php endif; ?>

<?php } ?>