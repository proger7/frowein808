<?php 

if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}

switch ($langLink) {
	case "de":
		$lang_id = 1;
		$an = 'AKTUELLE NEWS 2022';
		$pStartPage = 'Startseite';
		$ls1 = 'Zeitraum';
		$ls2 = 'Alle Tags anzeigen';
	break;
	case "en":
		$lang_id = 2;
		$an = 'LATEST NEWS 2022';
		$pStartPage = 'Home';
		$ls1 = 'Period';
		$ls2 = 'Show all tags';
	break;
}

$maxPagePoint = 10;
$offsetMaxPagePoint = 4;
$adjacents = "2";
$perr = 8;
$perr2 = 6;


$limit = 9;
$page = (isset($content[3]) && is_numeric($content[3]) ) ? $content[3] : 1;
$paginationStart = ($page - 1) * $limit;



// Get total records
$sql = $DB->select("SELECT count(id) AS id FROM news_text  WHERE news_headline != '' AND status = 1 AND language_id = ".$lang_id."  AND news_mainpage = 0");
$allRecrods = $sql[0]['id'];

// Calculate total pages
$totoalPages = ceil($allRecrods / $limit);
$second_last = $totoalPages - 1;

// Prev + Next
$prev = $page - 1;
$next = $page + 1;


$tags = $DB->select("SELECT news_tags FROM news_text WHERE  news_headline != '' AND news_mainpage = 0 AND  news_tags != '' AND status = 1 AND language_id = ".$lang_id." ORDER BY `update` DESC;");

$arr = [];
foreach ($tags as $k => $tag) {
	$expTags = explode(',,;, ', $tag['news_tags']);

	foreach ($expTags as $key => $expTag) {
		$tagno = (string)$expTag;
		$arr[] = $tagno . '<br>';
	}
}


if (isset($content[2]) and $content[2] == 'letters') {

	include "includes/news/$content[2].php";

} elseif( ( !isset($content[2]) ) || (($content[1] == 'news') && ($content[2] == 'page') && is_numeric($content[3])) ) { ?>

<div class="news__main-container pt-md-5">
	<div class="container pt-4 pb-md-5">
		<div class="row">
			<div class="col-md-auto">
				<div class="news__filter py-4 px-3">
					<div class="filter__form mb-0">
						<h3 class="filter__form-title mb-0"><?php echo $ls1; ?></h3>
						<div class="row pt-3 pb-4">
							<div class="col-md-12 col-sm-12 col-12">
								<select name="years" class="form-select filter__select">
									<option value="2022">2022</option>
								</select>
							</div>
						</div>
						<div id="filter__hr"></div>
					</div>
				</div>
				<div class="news__filter py-4 px-3 mt-md-4">
					<div class="filter__form mb-0">
						<div class="d-flex justify-content-between pb-3">
							<div>
								<span class="pFilter_title">News Tags</span>
							</div>
							<div class="d-flex align-items-center">
								<a href="" class="alle_tags"><?php echo $ls2; ?></a>
							</div>
						</div>
						<?php if($tags): ?>
							<?php $arr = array_unique($arr); ?>
							<div class="row pt-1 pb-0">
								<div class="col-md-12 col-sm-12 col-12">
									<ul class="alle__tags-list mb-0">
										<?php foreach($arr as $k => $t): ?>
											<?php $val = strip_tags(trim($t)); ?>

											<?php if ( strpos($val, '#') === false ) { ?>
												<li>
													<input class="form-check-input tag_input news__tag-item" type="checkbox" id="<?php echo $val;?>" data-id="<?php echo $k;?>" val="<?php echo $val;?>">
													<label class="form-check-label tag_label" for="<?php echo $val;?>">
														<?php echo '#'.$val; ?>
													</label>
												</li>
											<?php } else { ?>
												<li>
													<input class="form-check-input tag_input news__tag-item" type="checkbox" id="<?php echo $val;?>" data-id="<?php echo $k;?>" val="<?php echo $val;?>">
													<label class="form-check-label tag_label" for="<?php echo $val;?>"><?php echo $val; ?></label>
												</li>
											<?php } ?>
											
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="col">
				<h2 class="newsmain__label container ps-0 pb-md-4">News</h2>
			
				<div class="aktuelles__main-container">
					<div>
						<div class="row row-cols-md-3 filter_data produkt-list__main" id="newsPagination"></div>
					</div>
				</div>
			
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
  $(document).ready(function(){
  		
  		if($(window).width() >= 992 && $(window).width() < 1200) {
  			$('select[name="years"]').mobileSelect();
  		}
  		

	    filter_data();

	    function filter_data(page)
	    {
	        // $('.filter_data').html('<div id="loading" style="" ></div>');
	        var action = 'fetch_data_news';
	        var tag = get_filter('news__tag-item');
	        $.ajax({
	            url:"/content/fetch_data_news.php",
	            method:"POST",
	            data:{action:action, tag:tag,page_no:page},
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


  		$('ul.alle__tags-list').children('li:gt(9)').hide();
		$('.alle_tags').on('click', function(e){
				e.preventDefault();
		       $('ul.alle__tags-list').children('li:gt(9)').show();
		});


	    $(document).on("click",".pagination__td ul.pagination li > a",function(e) {
	        e.preventDefault();
	        var page_id = $(this).attr("id");
	        filter_data(page_id);
	    });

  });
});
</script>
<?php } elseif($content[2] == "archiv") { ?>

<?php } elseif( $_GET['page'] != "" ) { ?>
	
<?php } else { ?>	
<?php

   $article = $DB->query_fetch('SELECT news_picture,news_pdf,news_link1,news_link2,news_headline,news_tags,news_text,news_subline  FROM news_text WHERE id = '.$content[2].' LIMIT 1;');

   $topProducts = $DB->select('SELECT id,news_picture,`update`,news_tags,news_headline,news_subline,news_picture FROM `news_text` WHERE news_headline != "" AND status = 1 AND language_id = '.$lang_id.' AND news_mainpage = 0  ORDER BY `update` DESC LIMIT 10');

   if (!empty($article["news_picture"]))
      $news_image = '<img src="'.$URL_ROOT.'uploads/'.$article["news_picture"].'" class="float-end imgshadow">';
                        
   // LINK FUR PDF
   if (!empty($article["news_pdf"]))
     $links .= '<a href="'.$URL_ROOT.'uploads/'.$article["news_pdf"].'" target="_blank">Download</a><br><br>';

   // WENN LINKS VORHANDEN
   if (!empty($article["news_link1"]) || !empty($article["news_link2"]))
     $links .=  'Weitere Informationen:<br>';
   // LINK1
   if (!empty($article["news_link1"]))
     $links .=  '<a href="'.$article["news_link1"].'" target="_blank">'.$article["news_link1"].'</a><br>';
   // LINK2
   if (!empty($article["news_link2"]))
     $links .=  '<a href="'.$article["news_link2"].'" target="_blank">'.$article["news_link2"].'</a><br>';


?>
<div class="breadcrumbs py-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $pStartPage; ?></a></li>
        <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/news/">NEWS</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $article["news_headline"];?></li>
      </ol>
    </nav>
</div>
<div class="post-detail__main-container pt-md-5">
	<div class="container">
		<h2 class="post-detail__title"><?php echo $article["news_headline"];?></h2>

		<?php if($article['news_tags']) { ?>
			<?php $exp_tags = explode(',,;,', trim($article['news_tags'])) ?>
			<p class="post-detail__tags">
				<?php foreach($exp_tags as $tag) { $tag=trim($tag); ?>
					<span><?php echo '#'.$tag ?></span> 
				<?php } ?>
			</p>
		<?php } ?>

		<?php if($article["news_text"]) { ?>
			<h3 class="post-detail__label pt-md-4"><?php echo strip_tags($article["news_text"]);?></h3>
		<?php } ?>
	    <div class="row pt-2">
	      <div class="col-lg-12 pt-md-4 pt-lg-0">
	        <?php echo $news_image;?>
	        <?php if($article["news_subline"]) { ?>
	        	<p class="post-detail__content"><?php echo strip_tags($article["news_subline"]);?></p>
	        <?php } ?>
	      </div>

	      <h2 class="neuen__news pt-md-5"><?php echo $an; ?></h2>
			<div id="carouselExampleControls" class="carousel" data-bs-ride="carousel">
			    <div class="carousel-inner">
			    	<?php foreach($topProducts as $tp) { ?>
			    		<?php
						   if (!empty($tp["news_picture"])){
						      $tpImage = '<img src="'.$URL_ROOT.'uploads/'.$tp["news_picture"].'" class="img-fluid">';
						   } else {
						   	  $tpImage = '<img src="'.$URL_ROOT.'uploads/no-photo.png" class="img-fluid no-photo-carousel">';
						   }
			    		?>
				        <div class="carousel-item">
							<div class="col">
								<div class="img-hover-zoom img-hover-zoom--brightness">
									<a href="/<?php echo $langLink; ?>/news/<?php echo $tp["id"] . '/';?>">
										<?php echo $tpImage;?>
									</a>
								</div>
								<div class="news__card">
									<label class="pt-2 news__date-details"><?php echo date("d.m.Y", strtotime($tp['update']));?></label>
									<?php if($tp['news_tags']) { ?>
										<?php $expTags = explode(',,;,', trim($tp['news_tags'])) ?>
										<p class="pt-3 mb-1 news__tags">
											<?php foreach($expTags as $tag) { $tag=trim($tag); ?>
												<span><?php echo '#'.$tag ?></span>
											<?php } ?>
										</p>
									<?php } ?>
									<h3 class="pt-1 news__maintitle"><a href="/<?php echo $langLink; ?>/news/<?php echo $tp["id"] . '/';?>"><?php echo $tp["news_headline"];?></a></h3>
									<p class="news__moretext"><?php echo strip_tags($tp["news_subline"]);?></p>
								</div>
							</div>
				        </div>
			        <?php } ?>
			    </div>
			    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
			        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			        <span class="visually-hidden">Previous</span>
			    </button>
			    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
			        <span class="carousel-control-next-icon" aria-hidden="true"></span>
			        <span class="visually-hidden">Next</span>
			    </button>
			</div>

			<div id="carouselMobile" class="carousel slide" data-bs-ride="carousel">
			   <div class="carousel-inner">
			    <?php foreach($topProducts as $tpkey => $tp) { ?>
			    		<?php
						   if (!empty($tp["news_picture"])){
						      $tpImage = '<img src="'.$URL_ROOT.'uploads/'.$tp["news_picture"].'" class="img-fluid">';
						   } else {
						   	  $tpImage = '<img src="'.$URL_ROOT.'uploads/no-photo.png" class="img-fluid no-photo-carousel">';
						   }
			    		?>
					      <div class="carousel-item <?php if($tpkey==0) echo 'active';?>">
								<div class="col">
									<div class="img-hover-zoom img-hover-zoom--brightness">
										<a href="/<?php echo $langLink; ?>/news/<?php echo $tp["id"] . '/';?>">
											<?php echo $tpImage;?>
										</a>
									</div>
									<div class="news__card">
										<label class="pt-2 news__date-details"><?php echo date("d.m.Y", strtotime($tp['update']));?></label>
										<?php if($tp['news_tags']) { ?>
											<?php $expTags = explode(',,;,', trim($tp['news_tags'])) ?>
											<p class="pt-0 mb-1 news__tags">
												<?php foreach($expTags as $tag) { $tag=trim($tag); ?>
													<span><?php echo '#'.$tag ?></span>
												<?php } ?>
											</p>
										<?php } ?>
										<h3 class="pt-1 news__maintitle"><a href="/<?php echo $langLink; ?>/news/<?php echo $tp["id"] . '/';?>"><?php echo $tp["news_headline"];?></a></h3>
										<p class="news__moretext"><?php echo strip_tags($tp["news_subline"]);?></p>
									</div>
								</div>
					      </div>
			      <?php } ?>
			   </div>
			   <!-- Left and right controls/icons -->
			   <button class="carousel-control-prev ms-3" type="button" data-bs-target="#demo" data-bs-slide="prev">
			   <span class="carousel-control-prev-icon"></span>
			   </button>
			   <button class="carousel-control-next me-3" type="button" data-bs-target="#demo" data-bs-slide="next">
			   <span class="carousel-control-next-icon"></span>
			   </button>
			</div>

	    </div>
	</div>
</div>
<?php } ?>