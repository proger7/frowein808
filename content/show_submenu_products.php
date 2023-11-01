<?php 

require("./../includes/general.inc.php");

if($LANG["language"]["shortname"] == "de" || $LANG["language"]["shortname"] == "") {
  $langLink = 'de';
  $showProducts = 'Alle Produkte anzeigen';
} elseif($LANG["language"]["shortname"] == "en") {
  $langLink = 'en';
  $showProducts = 'Show all products';
}

$p = $_POST['product_id'];
$t = $_POST['prod_checker'];
$b = $_POST['cat_checker'];



switch ($langLink) {
	case "de":
		if( !empty($t) ) {
			$query = "SELECT name as product_name,image,seo_url FROM products WHERE status = 1 AND name != '' ORDER BY `name` LIMIT 20";
		} elseif( !empty($b) ) {
			$query = "SELECT name as product_name,short_text as cat_description,cat_image FROM products_categories WHERE status = 1 AND (`order` % 2) > 0 ORDER BY `order` ";
		} else {
			$query = "SELECT t1.name as product_name,t2.name as product_cat,t1.image,t1.seo_url FROM products as t1 JOIN products_categories as t2 ON t1.category = t2.id WHERE t1.status = 1 AND t1.name != '' AND t2.name = '" . $p . "' ORDER BY t1.order LIMIT 15";
		}
	break;
	case "en":
		if( !empty($t) ) {
			$query = "SELECT name_en as product_name,image,seo_url FROM products WHERE status = 1 AND name_en != '' ORDER BY `name_en` LIMIT 20";
		} elseif( !empty($b) ) {
			$query = "SELECT name_en as product_name,short_text_en as cat_description,cat_image FROM products_categories WHERE status = 1 AND (`order` % 2) > 0 ORDER BY `order` ";
		} else {
			$query = "SELECT t1.name_en as product_name,t2.name_en as product_cat,t1.image,t1.seo_url FROM products as t1 JOIN products_categories as t2 ON t1.category = t2.id WHERE t1.status = 1 AND t1.name_en != '' AND t2.name_en = '" . $p . "' ORDER BY t1.order LIMIT 15";
		}
	break;
}





$menuProducts = $DB->select($query);
?>

<?php foreach($menuProducts as $k => $product): ?>
	<?php 
	if( !empty($p) || !empty($t) ) {
		$link = '/' . $langLink . '/products/'.$product['product_cat'].'/'.$product['seo_url'];
	?>
		<li class="subitems">
			<a href="<?php echo $link ?>">
				<?php if(!empty($p) || !empty($t) || !empty($b) ){ ?>
					<img src="/images/submenu/arrow1.svg" class="pe-2">
				<?php } ?>
				<?php echo $product['product_name'] ?>
			</a>
		</li>
	<?php
	} elseif( !empty($b) ) {
		$link = '/' . $langLink . '/products/' .$product['product_name'];
		$img = $IMAGE->get_image($product['cat_image']);
		if( !empty($product['product_name']) ) {
		?>
			<div class="row mb-2 subCategoriesItems" style="border: 1px solid #dee2e6;">
				<div class="col-md-4 col-sm-12 col-12 p-2">
					<?php // echo $img ?>

                        <?php 
                        switch ($k) {
                          case 0:
                            $imgIcon = '<img src="/images/products/nav/category_icons/INSEKTENBEKAMPFUNGicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 1:
                            $imgIcon = '<img src="/images/products/nav/category_icons/SCHANDAicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 2:
                            $imgIcon = '<img src="/images/products/nav/category_icons/BETTWANZicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 3:
                            $imgIcon = '<img src="/images/products/nav/category_icons/APPLIKATIONicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                        }

                        ?>
					
				</div>
				<div class="col-md-8 col-sm-12 col-12 pt-2" id="verticallyCenter">
					<a href="<?php echo $link ?>" class="sub__cat-title"><?php echo $product['product_name'] ?></a>
					<p class="sub__cat-content"><?php echo strip_tags($product['cat_description'])  ?></p>
				</div>
			</div>
		<?php
		}
	}
	?>

<?php endforeach; ?>

<?php $categoryLink = '/' . $langLink . '/products/' . $p ?>
<?php if(!empty($p) && count($menuProducts) > 14 ){ ?>
<li>
	<a style="color: #e3001b" href="<?php echo $categoryLink ?>"><?php echo $showProducts; ?></a>
</li>
<?php } elseif( !empty($t) && count($menuProducts) > 19 ) { ?>
<li>
	<a style="color: #e3001b" href="/<?php echo $langLink; ?>/produkt-uebersicht/"><?php echo $showProducts; ?></a>
</li>
<?php } ?>