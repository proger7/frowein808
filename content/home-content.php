<?php

if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}

switch ($langLink) {
	case "de":
		$perfomanceRangeTitle = "Leistungsspektrum";
		$mehrButton = "Mehr erfahren";
		$homeNews = $DB->select("SELECT * FROM news_text WHERE news_headline != '' AND status = 1 AND language_id = 1 AND news_mainpage = 0 ORDER BY `id` DESC LIMIT 3;");
	break;
	case "en":
		$perfomanceRangeTitle = "Range of services";
		$mehrButton = "Learn more";
		$homeNews = $DB->select("SELECT * FROM news_text WHERE news_headline != '' AND status = 1 AND language_id = 2 AND news_mainpage = 0 ORDER BY `id` DESC LIMIT 3;");
	break;
}



// $homeLinkedInPosts = $DB->select("SELECT `text` FROM `linkedin_posts` ORDER BY `id` DESC LIMIT 1;");

$home_linked_in_posts = (function() use ($DB) {

	$posts123 = $DB->select("SELECT * FROM `linkedin_posts` ORDER BY `id` DESC LIMIT 3");

	if(!isset($posts123)) {
		return null;
	}
		
	$symbols = "\x{1F100}-\x{1F1FF}" // Enclosed Alphanumeric Supplement
		."\x{1F300}-\x{1F5FF}" // Miscellaneous Symbols and Pictographs
		."\x{1F600}-\x{1F64F}" //Emoticons
		."\x{1F680}-\x{1F6FF}" // Transport And Map Symbols
		."\x{1F900}-\x{1F9FF}" // Supplemental Symbols and Pictographs
		."\x{2600}-\x{26FF}" // Miscellaneous Symbols
		."\x{2700}-\x{27BF}"; // Dingbats
	
	foreach($posts123 as &$post)
	{

		$post['text'] = preg_replace('/['. $symbols . ']+/u', '', $post['text']);
		$post['text'] = str_replace('????', '', $post['text']);
		if(strlen($post['text']) > 100)
			$post['text'] = substr($post['text'], 0, 100) . '<br><a target="_blank" href="https://www.linkedin.com/feed/update/urn:li:share:' . $post['post_id'] . '">'.$mehrButton.'...</a>';
		
		$ago = "Gestern Heute";
		$startOfDay = strtotime(date("Y-m-d 00:00:00"));
		if($startOfDay > $post['post_created_at']){
			$current_time = time();
			$diff_time = time() - $post['post_created_at'];
			$diff_dates = $diff_time / (60 * 60 * 24);
			if($diff_dates < 30){
				$ago = "Vor " . (int)$diff_dates . " Tagen";
			}else{
				$diff_monthes = $diff_time / (60 * 60 * 24 * 30);
				
				if($diff_monthes < 12){
					$ago = "Vor " . (int)$diff_monthes . " Monat";
				}
			}
		}
		
		$post['ago'] = $ago;
	}
	// echo '<pre>'; var_dump($posts123); exit;
	return $posts123;
})();


?>

<div class="main-portfolio">
	<h2 class="title-portfolio container"><?php echo $perfomanceRangeTitle; ?></h2>
	<div class="inner__main-portfolio">
		<div class="container overflow-hidden">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-12 gx-5 py-3">
					<div class="item-col text-center px-5 py-4 equal__height">
						<figure class="figure">
							<span class="portfolio1"></span>
							<figcaption class="figure-caption text-center"><?=$LANG['startpage']['icon1'];?></figcaption>
						</figure>
					</div>
				</div>
				<div class="col-md-4 col-sm-12 col-12 gx-5 py-3">
					<div class="item-col text-center px-5 py-4 equal__height">
						<figure class="figure">
							<span class="portfolio2"></span>
							<figcaption class="figure-caption text-center"><?=$LANG['startpage']['icon2'];?></figcaption>
						</figure>
					</div>
				</div>
				<div class="col-md-4 col-sm-12 col-12 gx-5 py-3">
					<div class="item-col text-center px-5 py-4 equal__height">
						<figure class="figure">
							<span class="portfolio3"></span>
							<figcaption class="figure-caption text-center"><?=$LANG['startpage']['icon3'];?></figcaption>
						</figure>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-12 col-12 gx-5 py-3">
					<div class="item-col text-center px-5 py-4 equal__height">
						<figure class="figure">
							<span class="portfolio4"></span>
							<figcaption class="figure-caption text-center"><?=$LANG['startpage']['icon4'];?></figcaption>
						</figure>
					</div>
				</div>
				<div class="col-md-4 col-sm-12 col-12 gx-5 py-3">
					<div class="item-col text-center px-5 py-4 equal__height">
						<figure class="figure">
							<span class="portfolio5"></span>
							<figcaption class="figure-caption text-center"><?=$LANG['startpage']['icon5'];?></figcaption>
						</figure>
					</div>
				</div>
				<div class="col-md-4 col-sm-12 col-12 gx-5 py-3">
					<div class="item-col text-center px-5 py-4 equal__height">
						<figure class="figure">
							<span class="portfolio6"></span>
							<figcaption class="figure-caption text-center"><?=$LANG['startpage']['icon6'];?></figcaption>
						</figure>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="main-distinguish pt-5">
	<div class="container">
		<h2 class="title-dist"><?=$LANG['startpage']['title3'];?></h2>
		<div class="row pb-5">
			<div class="col-md-8 col-sm-12 col-12">
				<img src="/images/svg/distinguish.svg" class="img-fluid f-height">
			</div>
			<div class="col-md-4 col-sm-12 col-12 ps-md-5 pe-md-0 position-relative" id="spaceLeft_tablet">
				<ul class="list-dist pt-sm-4">
					<li><?=$LANG['startpage']['item1'];?></li>
					<li><?=$LANG['startpage']['item2'];?></li>
					<li><?=$LANG['startpage']['item3'];?></li>
					<li><?=$LANG['startpage']['item4'];?></li>
				</ul>
				<a href="/<?=$langLink;?>/about/" class="unt-button pos-button1 bottom-0"><?=$LANG['startpage']['companyButton'];?></a>
			</div>
		</div>
	</div>
</div>
<div class="main-offer">
	<h2 class="title-offer container"><?=$LANG['startpage']['title4'];?></h2>
	<div class="inner__main-offer">
		<div class="container overflow-hidden">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-12 gx-5 py-3">
					<div class="item-col text-center px-5 py-4">
						<figure class="figure">
							<span class="card1"></span>
							<figcaption class="figure-caption text-center"><?=$LANG['startpage']['bottomIcon1'];?></figcaption>
						</figure>
					</div>
				</div>
				<div class="col-md-4 col-sm-12 col-12 gx-5 py-3">
					<div class="item-col text-center px-5 py-4">
						<figure class="figure">
							<span class="card2"></span>
							<figcaption class="figure-caption text-center"><?=$LANG['startpage']['bottomIcon2'];?></figcaption>
						</figure>
					</div>
				</div>
				<div class="col-md-4 col-sm-12 col-12 gx-5 py-3">
					<div class="item-col text-center px-5 py-4">
						<figure class="figure">
							<span class="card3"></span>
							<figcaption class="figure-caption text-center"><?=$LANG['startpage']['bottomIcon3'];?></figcaption>
						</figure>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="main-news pt-5 pb-5">
	<div class="container overflow-hidden">
		<div class="row">
			<div class="col-md-6 col-sm-12 col-12 pe-md-5">
				<h2 class="title-followus"><?=$LANG['startpage']['followus']?></h2>
				
				<table class="table table-borderless news__item-col" id="linkedinPosts">
					<tr>
						<td colspan="2" id="topHeadName">
							
							<div class="linkedin-fpb">
								<div class="start-part">
									<img src="/images/svg/table/_x38_08.svg" class="img-fluid">
									<span>FROWEIN GMBH & CO. KG</span>
									<div class="post-text"></div>
								</div>
								<div class="end-part">
									<a target="_blank" href="https://www.linkedin.com/company/frowein-gmbh-&-co-kg">
										<img src="/images/svg/table/linkedin.png" class="img-fluid">
									</a>
								</div>
							</div>
						</td>
					</tr>

					<?php foreach($home_linked_in_posts as $post): ?>
						<tr>
							<td>
								<div class="px-3 py-4 pe-5">
									<div class="row">
										<p class="news__title-about">
											<!-- CEPA ernennt neues Sekretariat und peilt für die ... -->
											<?php echo $post['text']; ?>
										</p>
										<span class="news__date"><?php echo $post['ago']; ?></span>
									</div>
								</div>
							</td>
							<td width="40%">
								<p class="text-end pb-0 pe-md-3 mb-0 img-container">

										<img src="<?php echo $post['img']; ?>" class="img-fluid w-100 h-100 soc__image">
			

									
								</p>
							</td>
						</tr>=
					<?php endforeach; ?>
					<tr>
						<td colspan="2" class="text-center py-4 about__td">
							<a href="https://www.linkedin.com/company/frowein-gmbh-&-co-kg/" target="_blank" class="more_about"><?php echo $mehrButton;?></a>
						</td>
					</tr>
				</table>
			</div>
			<div class="col-md-6 col-sm-12 col-12 ps-md-5">
				<h2 class="title-news">News</h2>
				<?php if($homeNews) { ?>
				<table class="table table-borderless news__item-col" id="postsOnStartPage">
					<tr>
						<td>
							<div class="px-3 py-4">
								<div class="row">
									<div class="col-md-2 col-sm-3 col-3 table__logo-item">
										<img src="/images/svg/table/_x38_08.svg" class="img-fluid">
									</div>
									<div class="col-md-10 col-sm-9 col-9 ps-4">
										<p class="mb-1 pre-title">FROWEIN GMBH & CO. KG</p>
									</div>
								</div>
							</div>
						</td>
						<td>
							<p class="text-end py-4 pe-3"><a href="/<?=$langLink;?>/news/"><img src="/images/svg/table/aktuelles123.svg" class="img-fluid"></a></p>
						</td>
					</tr>

					<?php foreach($homeNews as $item){ 
						   if (!empty($item["news_picture"])){
						      $itemImage = '<img src="'.$URL_ROOT.'uploads/'.$item["news_picture"].'" class="img-fluid home__image">';
						   } else {
						   	  $itemImage = '<img src="'.$URL_ROOT.'uploads/no-photo.png" class="img-fluid no-photo-carousel home__image">';
						   }
					?>
							<tr>
								<td>
									<div class="px-3 py-4 pe-5">
										<div class="row">
											
											<p class="news__title-about">
												<?php if($item["news_headline"] && !empty($item["news_headline"])):?>
													<a href="/<?=$langLink;?>/news/<?php echo $item["id"] . '/';?>"><?php echo $item["news_headline"];?></a>
												<?php endif;?>
												<?php if($item["news_subline"] && !empty($item["news_subline"])):?>
													<span class="news__mini-descr"><?php echo strip_tags($item["news_subline"]);?></span>
												<?php endif;?>
												<a href="/<?=$langLink;?>/news/<?php echo $item["id"] . '/';?>" class="pt-3 card-link__startpage text-start"><?php echo $mehrButton; ?>..</a>
											</p>
											
											<span class="news__date-top"><?php echo date("d.m.Y", strtotime($item['update']));?></span>

										</div>
									</div>
								</td>
								<td width="40%">
									<p class="text-end pb-0 pe-md-3 mb-0 img-container">
										<?php echo $itemImage;?>
									</p>
								</td>
							</tr>
					<?php } ?>
					<tr>
						<td colspan="2" class="text-center py-4 about__td">
							<a href="/<?=$langLink;?>/news/" target="_blank" class="more_about"><?php echo $mehrButton; ?></a>
						</td>
					</tr>
				</table>
				<?php } ?>
			</div>
		</div>
	</div>
</div>




<script type="text/javascript">
jQuery(document).ready(function($) {
  $(document).ready(function(){

		var node = $('.title-followus').get(0).nextSibling;
		node.parentNode.removeChild(node);

		var max = 0;    
		$('.news__item-col tr:not(:last-child)').each(function() {
		    max = Math.max($(this).height(), max);
		}).height(max);

		var maxRow = 0;    
		$('.news__item-col tr:not(:first-child):not(:last-child) td:first-of-type div').each(function() {
		    maxRow = Math.max($(this).height(), maxRow);
		}).height(maxRow);

		var maxRowText = 0;    
		$('.news__item-col tr:not(:first-child):not(:last-child) td:first-of-type div p.news__title-about').each(function() {
		    maxRowText = Math.max($(this).height(), maxRowText);
		}).height(maxRowText);

	});
});
</script>