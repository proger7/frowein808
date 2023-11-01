<?php 
require("./../includes/general.inc.php");

if($LANG["language"]["shortname"] == "de" || $LANG["language"]["shortname"] == "") {
  $langLink = 'de';
} elseif($LANG["language"]["shortname"] == "en") {
  $langLink = 'en';
}

$s_lang_id = 1;

$s_maxPagePoint = 10;
$s_offsetMaxPagePoint = 4;
$s_adjacents = "2";
$sperr = 8;
$sperr2 = 6;

$s_limit = 9;
$s_page = isset($_POST['page_no'])  ? $_POST['page_no'] : 1;
$s_paginationStart = ($s_page - 1) * $s_limit;


if( isset($_POST["tag"]) ){
	$arrCat = (array)$_POST["tag"];
	if(count($arrCat) > 1){
		$storage_filter = implode(",", $arrCat);
		$storage_filter = str_replace(",", "|", $storage_filter);

	} else {
		$storage_filter = $arrCat[0];
	}
	
  	$addCondition = " AND product_tags REGEXP '[[:<:]]".$storage_filter."[[:>:]]'";
}
//parr($_POST);
switch ($langLink) {
	case "de":
		$moreButton = 'Mehr erfahren..';
		$category = $DB->query_fetch("SELECT id FROM products_categories WHERE name = '".urldecode($_POST['page_url'])."' OR  name_en = '".urldecode($_POST['page_url'])."' LIMIT 1;");
		$products = $DB->select("SELECT name as w1, red_text as w2, image, seo_url FROM products WHERE category = ".$category["id"]." AND status = 1 ".$addCondition." ORDER BY `order` LIMIT $s_paginationStart, $s_limit");
	break;
	case "en":
		$moreButton = 'Learn more..';
		$category = $DB->query_fetch("SELECT id FROM products_categories WHERE name = '".urldecode($_POST['page_url'])."' OR name_en = '".urldecode($_POST['page_url'])."' LIMIT 1;");
		$products = $DB->select("SELECT name_en as w1, red_text_en as w2, image, seo_url FROM products WHERE category = ".$category["id"]." AND status = 1 ".$addCondition." ORDER BY `order` LIMIT $s_paginationStart, $s_limit");
	break;
}





// Get total records
if( isset($_POST['tag']) ) {
	$s_sql = " AND product_tags REGEXP '[[:<:]]".$storage_filter."[[:>:]]'";
}
$s_sql_tag = "SELECT count(id) AS id FROM products WHERE category = ".$category["id"]." AND status = 1" . $s_sql;
$s_sql = $DB->select($s_sql_tag);
$sallRecrods = $s_sql[0]['id'];

// Calculate total pages
$s_totoalPages = ceil($sallRecrods / $s_limit);
$q_second_last = $s_totoalPages - 1;

// Prev + Next
$s_prev = $s_page - 1;
$s_next = $s_page + 1;





foreach ($products as $product):?>
	<?php $productLink = '/' . $langLink . '/products/'. urlencode($_POST['page_url']) .'/'.$product['seo_url'];?>
	<div class="col">
		<div class="card">
			<a href="<?php echo $productLink;?>">
				<?php if($product['image']){ ?>
					<?php echo $IMAGE->get_image($product['image']);?>
				<?php } else { ?>
					<img src="<?php echo $URL_ROOT.'uploads/no-photo.png';?>" class="img-fluid">
				<?php } ?>
			</a>
			<div class="card-body">
				<h5 class="card-title"><a href="<?php echo $productLink;?>"><?php echo $product['w1'];?></a></h5>
				<p class="card-text"><?php echo strip_tags($product['w2']);?></p>
				<a href="<?php echo $productLink;?>" class="card-link"><?php echo $moreButton; ?></a>
			</div>
		</div>
	</div>
<?php endforeach;?>


<!-- Pagination -->
<nav class="pagination__td text-center w-100" aria-label="Page navigation example mt-5">
    <ul class="pagination justify-content-end">
            <li class="page-item <?php if($s_page <= 1){ echo 'disabled'; } ?>">
                <a class="page-link"  id="<?php echo $s_page-1;?>"
                    href="<?php if($s_page <= 1){ echo '#'; } else { echo "" . $s_prev; } ?>"><span aria-hidden="true">‹</span></a>
            </li>

            <?php if($s_totoalPages <= $s_maxPagePoint) { ?>
                <?php for($i = 1; $i <= $s_totoalPages; $i++ ): ?>
                <li class="page-item <?php if($s_page == $i) {echo 'active'; } ?>">
                    <a class="page-link" id="<?php echo $i ?>" href=""> <?= $i; ?> </a>
                </li>
                <?php endfor; ?>
            <?php } elseif($s_totoalPages > $s_maxPagePoint) { ?>
            	<?php if($s_page <= $s_offsetMaxPagePoint) { ?>
            		<?php
				 	for ($counter = 1; $counter < $sperr; $counter++){		 
						if ($counter == $s_page) {
					   		echo "<li class='page-item active'><a id='".$counter."' class='page-link'>$counter</a></li>";	
						} else {
			           		echo "<li class='page-item'><a id='".$counter."' class='page-link' href=''>$counter</a></li>";
						}
			        }
					echo "<li class='page-item'><a class='page-link'>...</a></li>";
					echo "<li class='page-item'><a id='".$q_second_last."' class='page-link' href=''>$q_second_last</a></li>";
					echo "<li class='page-item'><a id='".$s_totoalPages."' class='page-link' href=''>$s_totoalPages</a></li>";
					?>
            	<?php } elseif($s_page > $s_offsetMaxPagePoint && $s_page < $s_totoalPages - $s_offsetMaxPagePoint) { ?>
					<?php
					echo "<li class='page-item'><a id='1' class='page-link' href=''>1</a></li>";
					echo "<li class='page-item'><a id='2' class='page-link' href=''>2</a></li>";
			        echo "<li class='page-item'><a class='page-link'>...</a></li>";
			        for ($counter = $s_page - $s_adjacents; $counter <= $s_page + $s_adjacents; $counter++) {			
			            if ($counter == $s_page) {
					   		echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
					    } else {
			           		echo "<li class='page-item'><a id='".$counter."' class='page-link' href=''>$counter</a></li>";
					    }                  
			       }
			       echo "<li class='page-item'><a class='page-link'>...</a></li>";
				   echo "<li class='page-item'><a id='".$q_second_last."' class='page-link' href=''>$q_second_last</a></li>";
				   echo "<li class='page-item'><a id='".$s_totoalPages."' class='page-link' href=''>$s_totoalPages</a></li>";
				   ?>
            	<?php } else { ?>
					<?php
			        echo "<li class='page-item'><a id='1' class='page-link' href=''>1</a></li>";
					echo "<li class='page-item'><a id='2' class='page-link' href=''>2</a></li>";
			        echo "<li class='page-item'><a class='page-link'>...</a></li>";

			        for ($counter = $s_totoalPages - $sperr2; $counter <= $s_totoalPages; $counter++) {
			          if ($counter == $s_page) {
					   		echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
					   } else {
			           		echo "<li class='page-item'><a id='".$counter."' class='page-link' href=''>$counter</a></li>";
					   }                   
			        }
			        ?>
            	<?php } ?>
            <?php } ?>


            <li class="page-item <?php if($s_page >= $s_totoalPages) { echo 'disabled'; } ?>">
                <a class="page-link"  id="<?php echo $s_page+1; ?>"
                    href="<?php if($s_page >= $s_totoalPages){ echo '#'; } else {echo "". $s_next; } ?>"><span aria-hidden="true">›</span></a>
            </li>
    </ul>
</nav
