
<?php

if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}

switch ($langLink) {
	case "de":
		$docname = 'Sicherheitsdatenblätter';
		$productinfo = 'Produktinformation';
		$besonderheiten = 'Besonderheiten';
		$psLabel1 = 'Startseite';
		$psLabel2 = 'PRODUKTKATEGORIEN';
		$tab1 = 'Produktinformation';
		$tab2 = 'Besonderheiten';
		$tab3 = 'Anwendungsbereich';
		$tab4 = 'Sicherheitsdatenblätter';
		$filter1 = 'Anwendungen';
		$filter2 = 'Alles zurücksetzen';
		$txt1 = "Sie haben Fragen zur<br>Produktlinie? Kontaktieren<br>Sie uns.";
		$txt2 = "Kontakt";
		$txt3 = "Kontakt aufnehmen";
		$title = 'Produktkategorien';
		$x1 = 'Kategorie Übersicht';
		$x2 = 'Produktübersicht';
		$categories = $DB->select("SELECT cat_icon_class, name as c1 FROM products_categories WHERE status = 1 ORDER BY `order`;");
	break;
	case "en":
		$docname = 'Safety data sheets';
		$productinfo = 'Product information';
		$besonderheiten = 'Particularities';
		$psLabel1 = 'Home';
		$psLabel2 = 'PRODUCT CATEGORIES';
		$tab1 = 'Product information';
		$tab2 = 'Particularities';
		$tab3 = 'Scope of application';
		$tab4 = 'Safety data sheets';
		$filter1 = 'Applications';
		$filter2 = 'Reset all';
		$txt1 = "Do you have questions about the<br>product line? Contact us.";
		$txt2 = "Contact";
		$txt3 = "Make contact";
		$title = 'Product categories';
		$x1 = 'Category overview';
		$x2 = 'Product overview';
		$categories = $DB->select("SELECT cat_icon_class, name_en as c1 FROM products_categories WHERE status = 1 ORDER BY `order`;");
	break;
}


$tags = $DB->select("SELECT product_tags FROM products WHERE product_tags <> '' AND status = 1 ORDER BY `order`;");

$arr = [];
foreach ($tags as $k => $tag) {
	$expTags = explode(',', $tag['product_tags']);

	foreach ($expTags as $key => $expTag) {
		$tagno = (string)$expTag;
		$arr[] = $tagno . '<br>';
	}
}


if ( !isset($content[2]) ) {

?>


<div class="produktkategorien__main-container pt-md-5">
	<div class="container pt-4 pb-5">
		<div class="row">
			<div class="col-md-auto">
				<ul class="produkt__list-nav pt-4 ps-3 pe-3 pb-1">
					<li class="nav-all_products" id="list_products"><a href="/<?php echo $langLink;?>/products/"><?php echo $x1;?></a></li>
					<li class="nav-all_products" id="list_products"><a href="/<?php echo $langLink; ?>/produkt-uebersicht/"><?php echo $x2;?></a></li>
					
					<?php foreach ($categories as $cat):?>
					<li class="<?php echo $cat['cat_icon_class'];?>">
						<a href="<?php echo $URL_ROOT. $langLink .'/products/'.$cat['c1'];?>"><?php echo $cat['c1'];?></a>
					</li>
					<?php endforeach; ?>
				</ul>


				<div class="produkt__kontakt p-3 mt-md-5">
					<p class="produkt__headphones"><?php echo $txt2; ?></p>
					<p class="py-1 produkt__headphones-text"><?php echo $txt1; ?></p>
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
					<a href="/<?php echo $langLink; ?>/contact/" class="produkt__headphones-link"><?php echo $txt3; ?></a>
				</div>
			</div>
			<div class="col">
				<h2 class="kategorien__label container ps-0 pb-md-4"><?php echo $title;?></h2>
				<div class="kategorien__main-list">
					<div class="row row-cols-1 row-cols-md-3 g-4 filter_data">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
	    jQuery(function($){

		    filter_data();

		    function filter_data()
		    {
		        // $('.filter_data').html('<div id="loading" style="" ></div>');
		        var action = 'fetch_data';
		        var tag = get_filter('tag');
		        $.ajax({
		            url:"/content/fetch_data.php",
		            method:"POST",
		            data:{action:action, tag:tag},
		            success:function(data){
		                $('.filter_data').html(data);
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

	        $('#produktFilterValues').multiSelect();
	    });
	});
</script>
<?php } else if( !isset($content[3]) ) {


	switch ($langLink) {
		case "de":
			$category = $DB->query_fetch("SELECT id, name as p1, description as p2 FROM products_categories WHERE name = '".urldecode($content[2])."' LIMIT 1;");

			// $products = $DB->select("SELECT * FROM products WHERE category = ".$category["id"]." AND status = 1 order by `order`");
		break;
		case "en":


			$category = $DB->query_fetch("SELECT id, name_en as p1, description_en as p2 FROM products_categories WHERE name_en = '".urldecode($content[2])."' LIMIT 1;");

			// $products = $DB->select("SELECT * FROM products WHERE category = ".$category["id"]." AND status = 1 order by `order`");
		break;
	}


	?>
    <div class="breadcrumbs py-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $psLabel1; ?></a></li>
            <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/products/"><?php echo $psLabel2; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $category['p1'];?></li>
          </ol>
        </nav>
    </div>
	<div class="produkt-list__main-container pt-md-5">
		<div class="container pt-4 pb-md-5">
			<div class="row">
				<div class="col-md-auto">
					<ul class="produkt__list-nav pt-4 ps-3 pe-3 pb-1">
						<li class="nav-all_products" id="list_products"><a href="/<?php echo $langLink;?>/products/"><?php echo $x1;?></a></li>
						<li class="nav-all_products" id="list_products"><a href="/<?php echo $langLink; ?>/produkt-uebersicht/"><?php echo $x2;?></a></li>
						
						<?php foreach ($categories as $cat):?>
						<li class="<?php echo $cat['cat_icon_class'];if($cat[c1] == $category[p1]) echo ' active';?>">
							<a href="<?php echo $URL_ROOT. $langLink .'/products/'.$cat['c1'];?>"><?php echo $cat['c1'];?></a>
						</li>
						<?php endforeach; ?>
					</ul>

					<div id="produkt_filter" class="pt-4 ps-3 pe-3 pb-4">
						<div class="d-flex justify-content-between pb-3">
							<div>
								<span class="pFilter_title"><?php echo $filter1; ?></span>
							</div>
							<div>
								<a class="tags_reset" href=""><?php echo $filter2; ?></a>
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
										$query2 = "SELECT t1.product_tags,t1.name as product_name,t2.id as category_id,t2.name as category_name,t2.cat_image as category_image,t2.short_text as category_short_description FROM products as t1 JOIN products_categories as t2 ON t1.category = t2.id WHERE t1.product_tags REGEXP '[[:<:]]".$val."[[:>:]]' AND t2.name = '".urldecode($content[2])."'";
									break;
									case "en":
										$query2 = "SELECT t1.product_tags,t1.name_en as product_name,t2.id as category_id,t2.name_en as category_name,t2.cat_image as category_image,t2.short_text_en as category_short_description FROM products as t1 JOIN products_categories as t2 ON t1.category = t2.id WHERE t1.product_tags REGEXP '[[:<:]]".$val."[[:>:]]' AND t2.name_en = '".urldecode($content[2])."'";
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
						<p class="produkt__headphones"><?php echo $txt2; ?></p>
						<p class="py-1 produkt__headphones-text"><?php echo $txt1; ?></p>
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
						<a href="/<?php echo $langLink; ?>/contact/" class="produkt__headphones-link"><?php echo $txt3; ?></a>
					</div>
				</div>
				<div class="col">
					<h2 class="produkt-list__label container ps-0 pb-4">Produkte</h2>
					<div class="produkt-list__main">
						<div class="row row-cols-1 row-cols-md-3 g-4 filter__product-data" id="productPagination">

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if( !empty($category['p2']) ): ?>
		<div class="produkt-list__content">
			<div class="container">
				<?php echo $category['p2'];?>
				<?php $decodeCatUrl = urldecode($content[2]); ?>
				<?php if( ( $decodeCatUrl=="INSEKTENBEKÄMPFUNG") || ($decodeCatUrl=="SCHADNAGERBEKÄMPFUNG") || ($decodeCatUrl=="BETTWANZENBEKÄMPFUNG") || ($content[2]=="DESINFEKTIONS-%20&%20PFLEGEMITTEL") || ($decodeCatUrl=="HNprofiLine") || ($decodeCatUrl=="SPEZIALPRODUKTE") || ( $decodeCatUrl=="INSECT CONTROL" ) || ( $decodeCatUrl=="RODENT CONTROL" ) || ( $decodeCatUrl=="BED BUG CONTROL" ) || ( $content[2]=="Products for disinfection and care" ) || ( $decodeCatUrl=="SPECIAL PRODUCTS" ) ): ?>
						<?php
						switch ($langLink) {
							case "de":
								echo <<<END
									<div id="biozid">
										<p class="produkt-list__high-text lead">Biozidprodukte vorsichtig verwenden. Vor Gebrauch stets Etikett und Produktinformation lesen. Vor Gebrauch stets Etikett und Produktinformation lesen.</p>
									</div>
								END;
							break;
							case "en":
								echo <<<END
									<div id="biozid">
										<p class="produkt-list__high-text lead">Use biocidal products with care. Always read the label and product information before use. Always read the label and product information before use.</p>
									</div>
								END;
							break;
						}
						?>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
	  	jQuery(function($){

		    filter_data();

		    function filter_data(page)
		    {
		    	var pageUrl = "<?php echo urldecode($content[2]);?>";
		    	var countItems = "<?php echo $countArr;?>";
		        // $('.filter_data').html('<div id="loading" style="" ></div>');
		        var action = 'fetch_data_product';
		        var tag = get_filter('product_tag');
		        $.ajax({
		            url:"/content/fetch_data_product.php",
		            method:"POST",
		            data:{action:action, tag:tag, page_url:pageUrl,page_no:page, countItems:countItems},
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
	<?php
} else if( isset($content[3]) ) {



	switch ($langLink) {
		case "de":
			$categoryID = $DB->query_fetch("SELECT id FROM products_categories WHERE name ='".urldecode($content[2])."'");
			$psLabel1 = 'Startseite';
			$psLabel2 = 'PRODUKTKATEGORIEN';
			$categoryInProduct = $DB->query_fetch("SELECT name as y1 FROM products_categories WHERE name = '".urldecode($content[2])."' LIMIT 1;");
			$product =  $DB->query_fetch("SELECT name as px1, short_description as yy1, article_id, tab_text as pxy1 , image, red_text as px2, description as px3, product_tags, pdf_file1_de as pdf1, pdf_file2_de as pdf2, pdf_file3_de as pdf3  FROM products WHERE seo_url='".$content[3]."' AND category = '".$categoryID["id"]."'");
			$catAllinProduct = $DB->select("SELECT name as kx1, cat_icon_class FROM products_categories WHERE status = 1 ORDER BY `order`;");
		break;
		case "en":


			$categoryNameReplaceSpace = str_replace('+', ' ', $content[2]);

			$categoryID = $DB->query_fetch("SELECT id FROM products_categories WHERE name_en ='".$categoryNameReplaceSpace."'");

			$psLabel1 = 'Home';
			$psLabel2 = 'PRODUCT CATEGORIES';
			$categoryInProduct = $DB->query_fetch("SELECT name_en as y1 FROM products_categories WHERE name_en = '".$categoryNameReplaceSpace."' LIMIT 1;");
			$product =  $DB->query_fetch("SELECT name_en as px1, short_description_en as yy1, article_id, tab_text_en as pxy1, image, red_text_en as px2, description_en as px3, product_tags, pdf_file1_en as pdf1, pdf_file2_en as pdf2, pdf_file3_en as pdf3 FROM products WHERE seo_url='".$content[3]."' AND category = '".$categoryID["id"]."'");
			$catAllinProduct = $DB->select("SELECT name_en as kx1, cat_icon_class FROM products_categories WHERE status = 1 ORDER BY `order`;");
		break;
	}



	if(!empty($product['pdf1']) || !empty($product['pdf2']) || !empty($product['pdf3'])) {
		$pdf1 = $product['pdf1'];
		$pdf2 = $product['pdf2'];
		$pdf3 = $product['pdf3'];
	}


	?>
    <div class="breadcrumbs py-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $psLabel1; ?></a></li>
            <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/products/"><?php echo $psLabel2; ?></a></li>
            <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/products/<?php echo $content[2];?>/"><?php echo $categoryInProduct['y1'];?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $product['px1'];?></li>
          </ol>
        </nav>
    </div>
	<div class="produkt__main-container pt-md-5">
		<div class="container pt-4 pb-md-5">
			<div class="row">
				<div class="col-md-auto equalWidth">
					<ul class="produkt__list-nav pt-4 ps-3 pe-3 pb-1">
						<li class="nav-all_products" id="list_products"><a href="/<?php echo $langLink;?>/products/"><?php echo $x1;?></a></li>
						<li class="nav-all_products" id="list_products"><a href="/<?php echo $langLink; ?>/produkt-uebersicht/"><?php echo $x2;?></a></li>
						
							<?php foreach ($catAllinProduct as $catProd):?>
							<li class="<?php echo $catProd['cat_icon_class'];if($catProd[kx1] == $categoryInProduct[y1]) echo ' active';?>">
								<a href="<?php echo $URL_ROOT. $langLink .'/products/'.$catProd['kx1'];?>"><?php echo $catProd['kx1'];?></a>
							</li>
							<?php endforeach; ?>
					</ul>

				</div>
				<div class="col">
					<h2 class="product__label container ps-0 pb-md-4"><?php echo $product['px1'];?></h2>
					<div class="product-details">
						<div class="container pt-4 px-0 pb-3">
							<div class="row px-4">
								<div class="col-md-5 col-sm-12 col-12 ps-1">

									<?php if($product['image']){ ?>
										<?php echo $IMAGE->get_image($product['image']);?>
									<?php } else { ?>
										<img src="<?php echo $URL_ROOT.'uploads/no-photo.png';?>" class="img-fluid">
									<?php } ?>
								</div>
								<div class="col-md-7 col-sm-12 col-12">
									<p><?php echo $product['article_id']; ?></p>
									<div>
										<?php echo $product['yy1']; ?>
									</div>
									<div class="red_product_text">
										<?php echo $product['px2'];?>
									</div>

							
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row pt-md-5 contactProductTopSpace">
				<div class="col-md-auto equalWidth">
					<div class="produkt__kontakt p-3">
						<p class="produkt__headphones"><?php echo $txt2; ?></p>
						<p class="py-1 produkt__headphones-text"><?php echo $txt1; ?></p>
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
						<a href="/<?php echo $langLink; ?>/contact/" class="produkt__headphones-link"><?php echo $txt3; ?></a>
					</div>
				</div>
				<div class="col">
					<div class="row">
						<div class="col-md-auto">
							<ul class="produkt__list-details">
								<li class="item1 px-4 active"><a data-value="info1"><?php echo $tab1; ?></a></li>
								<li class="item2 px-4"><a data-value="info2"><?php echo $tab2; ?></a></li>
								<li class="item3 px-4"><a data-value="info3"><?php echo $tab3; ?></a></li>
								<li class="item5 px-4"><a data-value="info5"><?php echo $tab4; ?></a></li>
							</ul>
						</div>
						<div class="col">
							<div id="info1">
								<div class="ps-3 pe-4 py-4">
									<div class="d-flex justify-content-between">
										<div>
											<span class="tag_title"><?php echo $productinfo; ?></span>
										</div>
									</div>	

									<div class="full_product_text">
										<?php echo $product['px3'];?>
									</div>							
								</div>
							</div>
							<div class="col" id="info2">
								<div class="ps-3 pe-4 py-4">
									<div class="d-flex justify-content-between">
										<div>
											<span class="tag_title"><?php echo $besonderheiten; ?></span>
										</div>
									</div>	
									<div class="full_product_text">
										<?php echo $product['pxy1'];?>
									</div>							
								</div>
							</div>
							<div class="col" id="info3">
								<div class="ps-3 pe-4 py-4">
									<div class="d-flex justify-content-between">
										<div>
											<span class="tag_title"><?php echo $filter1; ?></span>
										</div>
									</div>
									<?php if($product['product_tags']) { ?>
										<?php $exp_tags = explode(',', trim($product['product_tags'])) ?>
										<p class="news__tags pt-3">
											<?php foreach($exp_tags as $tag) { $tag=trim($tag); ?>
												<span><?php echo $tag ?></span>
											<?php } ?>
										</p>
									<?php } ?>									
								</div>
							</div>
							<div class="col" id="info5">


								<div class="ps-3 pe-4 py-4">
									<div class="d-flex justify-content-between">
										<div>
											<span class="tag_title"><?php echo $docname; ?></span>
										</div>
									</div>
								</div>
								
								<?php if($pdf1): ?>
									<?php $filepath1 = $URL_ROOT.'uploads/'.$pdf1; ?>

									<div class="d-flex ps-3 pe-4 py-0">



										<div class="p-2 flex-shrink-1">
											<img src="/images/pdf.svg" class="img-fluid" style="width: 30px">
										</div>
										<div class="p-2 w-100">
											<div>
												<p class="pdf__title mb-0"><?php echo $pdf1 ?></p>
												<p class="pdf__title-size mb-2">pdf - PDF File  Größe: <?php echo formattingFilesize($filepath1); ?></p>
											</div>
											<div class="d-flex flex-row">
												<div class="pe-4">
													<a class="download__button" href="<?php echo $filepath1;?>" download>
														Download
													</a>
												</div>
												<div>
													<a target="_blank" class="view__button" href="<?php echo $filepath1;?>">
														View
													</a>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if($pdf2): ?>
									<?php $filepath2 = $URL_ROOT.'uploads/'.$pdf2; ?>
									<div class="d-flex ps-3 pe-4 py-0">
										<div class="p-2 flex-shrink-1">
											<img src="/images/pdf.svg" class="img-fluid" style="width: 30px">
										</div>
										<div class="p-2 w-100">
											<div>
												<p class="pdf__title mb-0"><?php echo $pdf2 ?></p>
												<p class="pdf__title-size mb-2">pdf - PDF File  Größe: <?php echo formattingFilesize($filepath2); ?></p>
											</div>
											<div class="d-flex flex-row">
												<div class="pe-4">
													<a class="download__button" href="<?php echo $filepath2;?>" download>
														Download
													</a>
												</div>
												<div>
													<a target="_blank" class="view__button" href="<?php echo $filepath2;?>">
														View
													</a>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if($pdf3): ?>
									<?php $filepath3 = $URL_ROOT.'uploads/'.$pdf3; ?>
									<div class="d-flex ps-3 pe-4 py-0">
										<div class="p-2 flex-shrink-1">
											<img src="/images/pdf.svg" class="img-fluid" style="width: 30px">
										</div>
										<div class="p-2 w-100">
											<div>
												<p class="pdf__title mb-0"><?php echo $pdf3 ?></p>
												<p class="pdf__title-size mb-2">pdf - PDF File  Größe: <?php echo formattingFilesize($filepath3); ?></p>
											</div>
											<div class="d-flex flex-row">
												<div class="pe-4">
													<a class="download__button" href="<?php echo $filepath3;?>" download>
														Download
													</a>
												</div>
												<div>
													<a target="_blank" class="view__button" href="<?php echo $filepath3;?>">
														View
													</a>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#info2, #info3, #info4, #info5').hide();
		$('.produkt__list-details li a').click(function(eventInfo) {
			var tab = eventInfo.target.attributes[0].value;
			$("#" + tab).show().siblings().hide();
		});
		var selector = '.produkt__list-details li';

		$(selector).on('click', function(){
		    $(selector).removeClass('active');
		    $(this).addClass('active');
		});
	});
	</script>
	<?php
}