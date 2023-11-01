<?php

require("./../../includes/general.inc.php");

$getUserName = $DB->query_fetch('SELECT user_name,user_nachname FROM newsletter_users WHERE kundennummer="'.$KUNDENNUMMER.'" AND user_pass="'.$PASSWORT.'" AND status = 1 LIMIT 1;');

if($LANG["language"]["shortname"] == "de" || $LANG["language"]["shortname"] == "") {
	$lang_id = 1;
	$p1 = 'Mehr erfahren..';
	$langLink = 'de';
} elseif($LANG["language"]["shortname"] == "en") {
	$lang_id = 2;
	$p1 = 'Learn more..';
	$langLink = 'en';
}



$maxPagePoint = 10;
$offsetMaxPagePoint = 4;
$adjacents = "2";
$perr = 8;
$perr2 = 6;

$limit = 5;
$page = isset($_POST['page_no']) ? $_POST['page_no'] : 1;
$paginationStart = ($page - 1) * $limit;
$archiv_array = $DB->select("SELECT * FROM news_text WHERE status = 1 AND language_id = ".$lang_id." AND news_mainpage = 1 ORDER BY `order` LIMIT $paginationStart, $limit");

// Get total records
$sql = $DB->select("SELECT count(id) AS id FROM news_text  WHERE status = 1 AND language_id = ".$lang_id." AND news_mainpage = 1");
$allRecrods = $sql[0]['id'];


// Calculate total pages
$totoalPages = ceil($allRecrods / $limit);
$second_last = $totoalPages - 1;

// Prev + Next
$prev = $page - 1;
$next = $page + 1;

?>

<?php foreach ($archiv_array as $archiv_entity): ?>
	<tr>
		<td>
			<div class="px-2 pb-0 pe-2">
				<div class="row">
					<span class="partner-news__date-top"><?php echo date("d/m/Y", strtotime($archiv_entity['update']));?></span>
					<!-- <p class="partner__main-tags mb-2"><a href="/">#test</a> <a href="/">#category</a></p> -->
					<?php if ($archiv_entity["news_headline"]): ?>
						<p class="news__title-about"><a target="_blank" href="/<?php echo $langLink; ?>/news/<?php echo $archiv_entity["id"] . '/';?>"><?php echo $archiv_entity["news_headline"];?></a></p>
					<?php endif; ?>
					<span class="news__mini-descr"><?php echo cut_txt(strip_tags($archiv_entity["news_subline"]),120);?></span>
					<a href="/<?php echo $langLink; ?>/news/<?php echo $archiv_entity["id"] . '/';?>" class="pt-3 card-link__partner text-start"><?php echo $p1; ?></a>
				</div>
			</div>
		</td>
		<td width="45%">
			<?php if($archiv_entity['news_picture']){ ?>
				<p class="text-end pb-0 pe-1 mb-2 img-container">
					<img src="<?php echo $URL_ROOT.'uploads/'.$archiv_entity['news_picture'];?>" class="img-fluid w-100 topMain_img">
				</p>
			<?php } else { ?>
				<p class="text-end pb-0 pe-1 mb-2 img-container">
					<img src="<?php echo $URL_ROOT.'uploads/no-photo.png';?>" class="img-fluid">
				</p>
			<?php } ?>
		</td>
	</tr>
<?php endforeach; ?>
