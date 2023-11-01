<?php 

require("./../includes/general.inc.php");

if($LANG["language"]["shortname"] == "de" || $LANG["language"]["shortname"] == "") {
  $langLink = 'de';
  $s_lang_id = 1;
  $mButton = 'Mehr erfahren..';
} elseif($LANG["language"]["shortname"] == "en") {
  $langLink = 'en';
  $s_lang_id = 2;
  $mButton = 'Learn more..';
}


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
	
  	$addCondition = " AND news_tags REGEXP '[[:<:]]".$storage_filter."[[:>:]]'";
}



$newsArray = $DB->select("SELECT id,news_picture,news_headline,news_subline FROM news_text WHERE news_headline != '' AND status = 1 AND language_id = ".$s_lang_id." AND news_mainpage = 0 ".$addCondition." ORDER BY `id` DESC LIMIT $s_paginationStart, $s_limit");



// Get total records
if( isset($_POST['tag']) ) {
	$s_sql = " AND news_tags REGEXP '[[:<:]]".$storage_filter."[[:>:]]'";
}
$s_sql_tag = "SELECT count(id) AS id FROM news_text  WHERE news_headline != '' AND status = 1 AND language_id = ".$s_lang_id." AND news_mainpage = 0" . $s_sql;
$s_sql = $DB->select($s_sql_tag);
$sallRecrods = $s_sql[0]['id'];

// Calculate total pages
$s_totoalPages = ceil($sallRecrods / $s_limit);
$q_second_last = $s_totoalPages - 1;

// Prev + Next
$s_prev = $s_page - 1;
$s_next = $s_page + 1;



foreach ($newsArray as $news_entity){ ?>
	<?php $sLink =  '/' . $langLink . '/news/'. $news_entity["id"] . '/'; ?>
	<div class="col">
		<div class="card">
			<a href="<?php echo $sLink; ?>">
				<?php if($news_entity['news_picture']){ ?>
					<img src="<?php echo $URL_ROOT.'uploads/'.$news_entity['news_picture'];?>" class="img-fluid">
				<?php } else { ?>
					<img src="<?php echo $URL_ROOT.'uploads/no-photo.png';?>" class="img-fluid">
				<?php } ?>
			</a>
			<div class="card-body">
				<h5 class="card-title"><a href="<?php echo $sLink; ?>"><?php echo $news_entity["news_headline"];?></a></h5>
				<p class="card-text"><?php echo cut_txt(strip_tags($news_entity["news_subline"]),300);?></p>
				<a href="<?php echo $sLink; ?>" class="card-link"><?php echo $mButton; ?></a>
			</div>
		</div>
	</div>
	
<?php } ?>

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
</nav>