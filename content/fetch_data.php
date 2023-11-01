<?php 
require("./../includes/general.inc.php");

if($LANG["language"]["shortname"] == "de" || $LANG["language"]["shortname"] == "") {
  $langLink = 'de';
} elseif($LANG["language"]["shortname"] == "en") {
  $langLink = 'en';
}


	if( isset($_POST["tag"]) ){
		$arrCat = (array)$_POST["tag"];
		if(count($arrCat) > 1){
			$storage_filter = implode(",", $arrCat);
			$storage_filter = str_replace(",", "|", $storage_filter);

		} else {
			$storage_filter = $arrCat[0];
		}
		
	  	$addCondition = "WHERE t1.product_tags REGEXP '[[:<:]]".$storage_filter."[[:>:]]'";
	}


	switch ($langLink) {
		case "de":
			$mehr = 'Mehr erfahren..'; 
			$query = "SELECT t1.product_tags,t1.name as product_name,t2.id as category_id,t2.name as category_name,t2.cat_image as category_image,t2.short_text as category_short_description FROM products as t1 JOIN products_categories as t2 ON t1.category = t2.id WHERE t2.status = 1 GROUP BY t2.name";
		break;
		case "en":
			$mehr = 'Learn more..'; 
			$query = "SELECT t1.product_tags,t1.name_en as product_name,t2.id as category_id,t2.name_en as category_name,t2.cat_image as category_image,t2.short_text_en as category_short_description FROM products as t1 JOIN products_categories as t2 ON t1.category = t2.id WHERE t2.status = 1 GROUP BY t2.name_en";
		break;
	}
	

	

	$categories = $DB->select($query);
	?>

	<?php foreach ($categories as $key => $category): 
	    $name = $category['category_name'];
	    $img = $IMAGE->get_image($category['category_image']);
	    $link = $URL_ROOT . $langLink . '/products/'.  urlencode($category['category_name']);
	    $shortText = strip_tags($category['category_short_description']);
	?>
	
	<div class="col">
		<div class="card">
			<a href="<?php echo $link;?>" class="card-link__body">
				<?php //echo $img;?>
                        <?php 
                        switch ($key) {
                          case 0:
                            $imgIcon = '<img src="/images/products/nav/category_icons/APPLIKATIONicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 1:
                            $imgIcon = '<img src="/images/products/nav/category_icons/BETTWANZicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 2:
                            $imgIcon = '<img src="/images/products/nav/category_icons/DEZINFKTIONSPFLGEMITTEL icon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 3:
                            $imgIcon = '<img src="/images/products/nav/category_icons/INSEKTENBEKAMPFUNGicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 4:
                            $imgIcon = '<img src="/images/products/nav/category_icons/SCHANDAicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 5:
                            $imgIcon = '<img src="/images/products/nav/category_icons/SPEZIALPRODUKTEicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 6:
                            $imgIcon = '<img src="/images/products/nav/category_icons/TAUBENABWEHRicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                        }

                        ?>
			</a>
			<div class="card-body">
				<h5 class="card-title"><a href="<?php echo $link;?>"><?php echo $name;?></a></h5>
				<p class="card-text"><?php echo $shortText;?></p>
				<a href="<?php echo $link;?>" class="card-link"><?php echo $mehr; ?></a>
			</div>
		</div>
	</div>
	<?php endforeach; ?>