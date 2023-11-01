<?php

if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}

$tags = $DB->select("SELECT product_tags FROM products WHERE product_tags <> '' AND status = 1 ORDER BY `order`;");

switch ($langLink) {
	case "de":
		$cLabel1 = 'KONTAKT';
		$cLabel2 = "Sie haben Fragen zur<br>Produktlinie? Kontaktieren<br>Sie uns.";
		$cLabel3 = 'Kontakt aufnehmen';
		$allVal = 'Alles zurücksetzen';
		$application = 'ANWENDUNGEN';
		$p1 = 'Produktübersicht';
		$p2 = 'Kategorie Übersicht';
		$allTitle = 'Alle Produkte';
		$categories = $DB->select("SELECT name as pname, cat_icon_class FROM products_categories WHERE status = 1 ORDER BY `order`;");
	break;
	case "en":
		$cLabel1 = 'CONTACT';
		$cLabel2 = "Do you have questions about the<br>product line? Contact us.";
		$cLabel3 = 'Make contact';
		$allVal = 'Reset all';
		$application = 'APPLICATIONS';
		$p1 = 'Product overview';
		$p2 = 'Category overview';
		$allTitle = 'All products';
		$categories = $DB->select("SELECT name_en as pname, cat_icon_class FROM products_categories WHERE status = 1 ORDER BY `order`;");
	break;
}


$products = $DB->select("SELECT * FROM products WHERE status = 1 order by `update` DESC");


$arr = [];
foreach ($tags as $k => $tag) {
	$expTags = explode(',', $tag['product_tags']);

	foreach ($expTags as $key => $expTag) {
		$tagno = (string)$expTag;
		$arr[] = $tagno . '<br>';
	}
}
?>
<div class="produkt-list__main-container pt-md-5">
	<div class="container pt-4 pb-md-5">
		<div class="row">
			<div class="col-md-auto">
				<ul class="produkt__list-nav pt-4 ps-3 pe-3 pb-1">
					<li class="nav-all_products" id="list_products"><a href="/<?php echo $langLink; ?>/products/"><?php echo $p2; ?></a></li>
					<li class="nav-all_products" id="list_products"><a href="/<?php echo $langLink; ?>/produkt-uebersicht/"><?php echo $p1; ?></a></li>
					
					<?php foreach ($categories as $cat):?>
					<li class="<?php echo $cat['cat_icon_class'];if($cat[pname] == $category[name]) echo ' active';?>">
						<a href="<?php echo $URL_ROOT. $langLink .'/products/'.$cat['pname'];?>"><?php echo $cat['pname'];?></a>
					</li>
					<?php endforeach; ?>
				</ul>

				<div id="produkt_filter" class="pt-4 ps-3 pe-3 pb-4">
					<div class="d-flex justify-content-between pb-3">
						<div>
							<span class="pFilter_title"><?php echo $application; ?></span>
						</div>
						<div>
							<a class="tags_reset" href=""><?php echo $allVal; ?></a>
						</div>
					</div>
					<?php if($tags): ?>
						<?php $arr = array_unique($arr); ?>

						<?php $i = 0; ?>
						<?php foreach($arr as $k => $t): ?>
							<?php $val = strip_tags(trim($t)); ?>
							<?php $query = "SELECT count(*) as tag_count FROM products WHERE product_tags REGEXP '[[:<:]]".$val."[[:>:]]'";?>


							<?php
							switch ($langLink) {
								case "de":
									$query2 = "SELECT t1.product_tags,t1.name as product_name,t2.id as category_id,t2.name as category_name,t2.cat_image as category_image,t2.short_text as category_short_description FROM products as t1 JOIN products_categories as t2 ON t1.category = t2.id WHERE t1.product_tags REGEXP '[[:<:]]".$val."[[:>:]]'";
								break;
								case "en":
									$query2 = "SELECT t1.product_tags,t1.name_en as product_name,t2.id as category_id,t2.name_en as category_name,t2.cat_image as category_image,t2.short_text_en as category_short_description FROM products as t1 JOIN products_categories as t2 ON t1.category = t2.id WHERE t1.product_tags REGEXP '[[:<:]]".$val."[[:>:]]'";
								break;
							}
							?>

							<?php $count = $DB->select($query2);
							$countArr = count($count);
							?>
							<?php if($i < 10): ?>
							<div class="form-check f-center">
							  <input class="form-check-input tag_input product_tag" type="checkbox" id="<?php echo $val;?>" data-id="<?php echo $k;?>" val="<?php echo $val;?>">
							  <label class="form-check-label tag_label" for="<?php echo $val;?>">
							    <?php echo $val . ' ' . '('. $countArr . ')';?>
							  </label>
							</div>
							<?php endif; ?>
							<?php $i++; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>

				<div class="produkt__kontakt p-3 mt-md-5">
					<p class="produkt__headphones"><?php echo $cLabel1; ?></p>
					<p class="py-1 produkt__headphones-text"><?php echo $cLabel2; ?></p>
						<div style="padding-left: 45px;">
							<table class="table table-borderless kontakt__item-col">
								<tbody>
									<tr>
										<td class="px-0">
											<p class="text-left mb-0"><img src="/images/svg/contact/kicon2.svg" class="img-fluid"></p>
										</td>
										<td>
											<a class="k-telephone" href="tel:+49 7432 956-0">+49 7432 956-0</a>
										</td>
									</tr>
									<tr>
										<td class="px-0">
											<p class="text-left mb-0"><img src="/images/svg/contact/kicon4.svg" class="img-fluid"></p>
										</td>
										<td>
											<a class="k-email" href="mailto:info@frowein808.de">info@frowein808.de</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					<a href="/<?php echo $langLink; ?>/contact/" class="produkt__headphones-link"><?php echo $cLabel3; ?></a>
				</div>
			</div>
			<div class="col">
				<h2 class="produkt-list__label container ps-0 pb-4"><?php echo $allTitle; ?></h2>
				<div class="produkt-list__main">
					<div class="row row-cols-1 row-cols-md-3 g-4 filter__product-data" id="productPagination">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
  	jQuery(function($){

	    filter_data();

	    function filter_data(page)
	    {
	        // $('.filter_data').html('<div id="loading" style="" ></div>');
	        var action = 'fetch_data_all_products';
	        var tag = get_filter('product_tag');
	        $.ajax({
	            url:"/content/fetch_data_all_products.php",
	            method:"POST",
	            data:{action:action, tag:tag,page_no:page},
	            success:function(data){
	                $('.filter__product-data').html(data);
	            }
	        });
	    }

	    function get_filter(class_name)
	    {
	        var filter = [];
	        $('.'+class_name+':checked').each(function(){
	            filter.push($(this).attr('id'));
	        });
	        return filter;
	    }

	    $('.tag_input').click(function(){
	        filter_data();
	    });

		$(".tags_reset").click(function(ev) {
			ev.preventDefault();
			
		    $('.tag_input').prop('checked', false);
		    filter_data();
		});

	    $(document).on("click",".pagination__td ul.pagination li .page-link",function(e) {
	        e.preventDefault();
	        var page_id = $(this).attr("id"); 
	        filter_data(page_id);
	    });

  });
});
</script>

<script type="text/javascript">
	jQuery(document).ready(function($){
	    jQuery(function($){
	        $('#produktFilterValues').multiSelect();
	    });
	});
</script>
