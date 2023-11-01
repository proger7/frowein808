<?php
if ( !isset($content[1]) ) {
$categories = $DB->select("SELECT * FROM products_categories WHERE status = 1 AND language_id = 1 ORDER BY `order`;");
?>
<div class="produktkategorien__main-container pt-md-5">
	<div class="container pt-4 pb-5">
		<div class="row">
			<div class="col-md-auto">
				<ul class="produkt__list-nav pt-4 ps-3 pe-3 pb-1">
					<li class="all_categories"><a href="/products/">Produktübersicht</a></li>
					<?php foreach ($categories as $cat):?>
					<li class="<?php echo $cat['cat_icon_class'];?>">
						<a href="<?php echo $URL_ROOT.'products/'.$cat['name'];?>"><?php echo $cat['name'];?></a>
					</li>
					<?php endforeach; ?>
				</ul>
				<div class="produkt__kontakt p-3 mt-md-5">
					<p class="produkt__headphones">Kontakt</p>
					<p class="py-1 produkt__headphones-text">Sie haben Fragen zur<br>Produktlinie? Kontaktieren<br>Sie uns.</p>
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
					<a href="/contact/" class="produkt__headphones-link">Kontakt aufnehmen</a>
				</div>
			</div>
			<div class="col">
				<h2 class="kategorien__label container ps-0 pb-md-4">Produktkategorien</h2>
				<div class="kategorien__main-list">
					<div class="row row-cols-1 row-cols-md-3 g-4">
						<?php foreach ($categories as $category): 
					        $name = $category['name'];
					        $img = $IMAGE->get_image($category['cat_image']);
					        $link = $URL_ROOT.'products/'.$category['name'];
					        $shortText = strip_tags($category['short_text']);
						?>
						<div class="col">
							<div class="card">
								<a href="<?php echo $link;?>">
									<?php echo $img;?>
								</a>
								<div class="card-body">
									<h5 class="card-title"><a href="<?php echo $link;?>"><?php echo $name;?></a></h5>
									<p class="card-text"><?php echo $shortText;?></p>
									<a href="<?php echo $link;?>" class="card-link">Mehr erfahren..</a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else if( !isset($content[2]) ) {
	$category = $DB->query_fetch("SELECT * FROM products_categories WHERE name = '".urldecode($content[1])."' LIMIT 1;");
	$products = $DB->select("SELECT * FROM products WHERE category = ".$category["id"]." AND status = 1 order by `order`");
	?>
    <div class="breadcrumbs py-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/">Startseite</a></li>
            <li class="breadcrumb-item"><a href="/products/">PRODUKTKATEGORIEN</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $category['name'];?></li>
          </ol>
        </nav>
    </div>
	<div class="produkt-list__main-container pt-md-5">
		<div class="container pt-4 pb-md-5">
			<div class="row">
				<div class="col-md-auto">
					<ul class="produkt__list-nav pt-4 ps-3 pe-3 pb-1">
						<li class="all_categories"><a href="/products/">Produktübersicht</a></li>
						<?php foreach ($categories as $cat):?>
						<li class="<?php echo $cat['cat_icon_class'];if($cat[name] == $category[name]) echo ' active';?>">
							<a href="<?php echo $URL_ROOT.'products/'.$cat['name'];?>"><?php echo $cat['name'];?></a>
						</li>
						<?php endforeach; ?>
					</ul>
					<div class="produkt__kontakt p-3 mt-md-5">
						<p class="produkt__headphones">Kontakt</p>
						<p class="py-1 produkt__headphones-text">Sie haben Fragen zur<br>Produktlinie? Kontaktieren<br>Sie uns.</p>
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
						<a href="/contact/" class="produkt__headphones-link">Kontakt aufnehmen</a>
					</div>
				</div>
				<div class="col">
					<h2 class="produkt-list__label container ps-0 pb-4">Produkte</h2>
					<div class="produkt-list__main">
						<div class="row row-cols-1 row-cols-md-3 g-4">
							<?php foreach ($products as $product):?>
								<?php $productLink = '/products/'.$content[1].'/'.$product['seo_url'];?>
								<div class="col">
									<div class="card">
										<a href="<?php echo $productLink;?>">
											<?php echo $IMAGE->get_image($product[image]);?>
										</a>
										<div class="card-body">
											<h5 class="card-title"><a href="<?php echo $productLink;?>"><?php echo $product['name'];?></a></h5>
											<p class="card-text"><?php echo strip_tags($product['red_text']);?></p>
											<a href="<?php echo $productLink;?>" class="card-link">Mehr erfahren..</a>
										</div>
									</div>
								</div>
							<?php endforeach;?>
						</div>
					</div>
				</div>
				<nav aria-label="Product listing pagination" class="produkt__pagination">
				  <ul class="pagination mb-0 justify-content-end pt-md-5 pb-3 paginationTopSpaceMobile">
				    <li class="page-item">
				      <a class="page-link" href="#" aria-label="Previous">
				        <span aria-hidden="true">&lsaquo;</span>
				      </a>
				    </li>
				    <li class="page-item active"><a class="page-link" href="#">1</a></li>
				    <li class="page-item"><a class="page-link" href="#">2</a></li>
				    <li class="page-item"><a class="page-link" href="#">3</a></li>
				    <li class="page-item"><span>...</span></li>
				    <li class="page-item"><a class="page-link" href="#">15</a></li>
				    <li class="page-item">
				      <a class="page-link" href="#" aria-label="Next">
				        <span aria-hidden="true">&rsaquo;</span>
				      </a>
				    </li>
				  </ul>
				</nav>
			</div>
		</div>
	</div>
	<div class="produkt-list__content">
		<div class="container">
			<?php echo $category['description'];?>
			<?php $decodeCatUrl = urldecode($content[1]); ?>
			<?php if( ( $decodeCatUrl=="INSEKTENBEKÄMPFUNG") || ($decodeCatUrl=="SCHADNAGERBEKÄMPFUNG") || ($decodeCatUrl=="BETTWANZENBEKÄMPFUNG") || ($content[1]=="DESINFEKTIONS-%20&%20PFLEGEMITTEL") || ($decodeCatUrl=="HNprofiLine") || ($decodeCatUrl=="SPEZIALPRODUKTE") ): ?>
			<div id="biozid">
				<p class="produkt-list__high-text lead">Biozidprodukte vorsichtig verwenden. Vor Gebrauch stets Etikett und Produktinformation lesen. Pflanzenschutzmittel vorsichtig verwenden. Vor Gebrauch stets Etikett und Produktinformation lesen.</p>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
} else if( isset($content[2]) ) {
	$categoryInProduct = $DB->query_fetch("SELECT * FROM products_categories WHERE name = '".urldecode($content[1])."' LIMIT 1;");
	$product =  $DB->query_fetch("SELECT * FROM products WHERE seo_url='".$content[2]."'");
	$catAllinProduct = $DB->select("SELECT * FROM products_categories WHERE status = 1 AND language_id = 1 ORDER BY `order`;");
	?>
    <div class="breadcrumbs py-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/">Startseite</a></li>
            <li class="breadcrumb-item"><a href="/products/">PRODUKTKATEGORIEN</a></li>
            <li class="breadcrumb-item"><a href="/products/<?php echo $content[1];?>/"><?php echo $categoryInProduct['name'];?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $product['name'];?></li>
          </ol>
        </nav>
    </div>
	<div class="produkt__main-container pt-md-5">
		<div class="container pt-4 pb-md-5">
			<div class="row">
				<div class="col-md-auto equalWidth">
					<ul class="produkt__list-nav pt-4 ps-3 pe-3 pb-1">
						<li class="all_categories"><a href="/products/">Produktübersicht</a></li>

							<?php foreach ($catAllinProduct as $catProd):?>
							<li class="<?php echo $catProd['cat_icon_class'];if($catProd[name] == $categoryInProduct[name]) echo ' active';?>">
								<a href="<?php echo $URL_ROOT.'products/'.$catProd['name'];?>"><?php echo $catProd['name'];?></a>
							</li>
							<?php endforeach; ?>

					</ul>
				</div>
				<div class="col">
					<h2 class="product__label container ps-0 pb-md-4"><?php echo $product['name'];?></h2>
					<div class="product-details">
						<div class="container pt-4 px-0 pb-3">
							<div class="row px-4">
								<div class="col-md-5 col-sm-12 col-12 ps-1">
									<?php echo $IMAGE->get_image($product['image']);?>
								</div>
								<div class="col-md-7 col-sm-12 col-12">
									<div class="red_product_text">
										<?php echo $product['red_text'];?>
									</div>
									<div class="full_product_text">
										<?php echo $product['description'];?>
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
						<p class="produkt__headphones">Kontakt</p>
						<p class="py-1 produkt__headphones-text">Sie haben Fragen zur<br>Produktlinie? Kontaktieren<br>Sie uns.</p>
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
						<a href="/contact/" class="produkt__headphones-link">Kontakt aufnehmen</a>
					</div>
				</div>
				<div class="col">
					<div class="row">
						<div class="col-md-auto">
							<ul class="produkt__list-details">
								<li class="item1 px-4 active"><a data-value="info1">Produktinformation</a></li>
								<li class="item2 px-4"><a data-value="info2">Besonderheiten</a></li>
								<li class="item3 px-4"><a data-value="info3">Anwendungsbereich</a></li>
								<li class="item5 px-4"><a data-value="info5">Sicherheitsdatenblätter</a></li>
							</ul>
						</div>
						<div class="col">
							<div id="info1">
								<div class="row row-cols-2 px-md-5 d-none">
									<div class="col py-4 d-flex align-items-center justify-content-left">
										<p class="produkt__columns-icon">
											<img src="/images/products/list/HOHE LEBENSDAUER.svg">
											<span>HOHE<br>LEBENSDAUER</span>
										</p>
									</div>
									<div class="col py-4 d-flex align-items-center justify-content-left">
										<p class="produkt__columns-icon">
											<img src="/images/products/list/HOHER WIRKUNGSGRAD.svg">
											<span>HOHER<br>WIRKUNGSGRAD</span>
										</p>
									</div>
									<div class="col py-4 d-flex align-items-center justify-content-left">
										<p class="produkt__columns-icon">
											<img src="/images/products/list/MODULARES BAUKASTENSYSTEM.svg">
											<span>MODULARES<br>BAUKASTENSYSTEM</span>
										</p>
									</div>
									<div class="col py-4 d-flex align-items-center justify-content-left">
										<p class="produkt__columns-icon">
											<img src="/images/products/list/GERÄUSCHARM UND OPTIMALE LAUFRUHE.svg">
											<span>GERÄUSCHARM UND<br>OPTIMALE LAUFRUHE</span>
										</p>
									</div>
								</div>
								<p class="produkt__main-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore.</p>
							</div>
							<div class="col" id="info2">
								<p>Besonderheiten</p>
							</div>
							<div class="col" id="info3">
								<p>Anwendungsbereich</p>
							</div>
							<div class="col" id="info5">
								<p>Sicherheitsdatenblätter</p>
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