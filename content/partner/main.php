<?php

$getUserName = $DB->query_fetch('SELECT user_name,user_nachname FROM newsletter_users WHERE kundennummer="'.$KUNDENNUMMER.'" AND user_pass="'.$PASSWORT.'" AND status = 1 LIMIT 1;');


if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}
switch ($langLink) {
  case "de":
    $lang_id = 1;
    $item1 = 'Allgemein';
    $item2 = 'Produktübersicht';
    $item3 = 'Informationsmaterial';
    $item4 = 'Persönliche Daten';
    $logAsName = 'Angemeldet als';
    $logout = 'Ausloggen';
    $titleMainNews = 'interner news bereich';
    $text1 = "Herzlich willkommen im partner-net der FROWEIN GMBH & CO. KG";
    $text2 = "Dieser Bereich steht ausschließlich \"808\"-Kunden zur Verfügung und ist direkt mit Ihren Zugangsdaten zu erreichen. Unter der Rubrik <a href=\"/de/partner/pers_daten/\">persönliche Daten</a> können Sie jederzeit Ihr persönliches Passwort ändern.";
    $text3 = "Bei Fragen, Anregungen oder Problemen rufen Sie uns einfach an oder schicken uns eine <a href=\"mailto:info@frowein808.de\">E-Mail</a>.";
    $text4 = "Zum Betrachten unserer Downloads benötigen Sie den Adobe Acrobat Reader, welchen Sie sich <a target=\"_blank\" href=\"http://www.adobe.de/products/acrobat/readstep.html\">hier</a> downloaden können.";
  break;
  case "en":
    $lang_id = 2;
    $item1 = 'General';
    $item2 = 'Product overview';
    $item3 = 'Information material';
    $item4 = 'Personal data';
    $logAsName = 'Logged in as';
    $logout = 'Log out';
    $titleMainNews = 'internal news area';
    $text1 = "Welcome to the partner-net of FROWEIN GMBH & CO. KG";
    $text2 = "This area is only available to \"808\" customers and can be accessed directly with your access data. Under the heading <a href=\"/en/partner/pers_daten/\">personal data</a> you can change your personal password at any time.";
    $text3 = "If you have any questions, suggestions or problems, simply give us a call or send us an <a href=\"mailto:info@frowein808.de\">e-mail</a>.";
    $text4 = "To view our downloads you need Adobe Acrobat Reader, which you can download <a target=\"_blank\" href=\"http://www.adobe.de/products/acrobat/readstep.html\">here</a> can download.";
  break;
}

$maxPagePoint = 10;
$offsetMaxPagePoint = 4;
$adjacents = "2";
$perr = 8;
$perr2 = 6;

$limit = 5;
$page = (isset($content[2]) && is_numeric($content[2]) ) ? $content[2] : 1;
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
<nav class="navbar navbar-expand-lg pt-0">
   <div class="container">
      <div class="collapse navbar-collapse border-bottom" id="navbarText">
         <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item menu-item-1 me-1">
               <a class="nav-link active" aria-current="page" href="/<?php echo $langLink; ?>/partner/"><?php echo $item1; ?></a>
            </li>
            <li class="nav-item menu-item-2 me-1">
               <a class="nav-link" href="/<?php echo $langLink; ?>/partner/downloads/"><?php echo $item2; ?></a>
            </li>
            <li class="nav-item menu-item-3 me-1">
               <a class="nav-link" href="/<?php echo $langLink; ?>/partner/order/"><?php echo $item3; ?></a>
            </li>
            <li class="nav-item menu-item-4 me-1">
               <a class="nav-link" href="/<?php echo $langLink; ?>/partner/pers_daten/"><?php echo $item4; ?></a>
            </li>
         </ul>
         <span class="navbar-text border-start" id="formLogout">
		    <nav style="--bs-breadcrumb-divider: '|';" aria-label="/?logout" class="container logout__block">
		      <ol class="breadcrumb">
		      	<li class="breadcrumb-item" aria-current="page"><?php echo $logAsName; ?> <b><?php echo $getUserName['user_name'] . ' ' . $getUserName['user_nachname'];?></b></li>
		        <li class="breadcrumb-item">
		        	<form action="" method="POST" class="mb-0 needs-validation" novalidate>
		        		<input type="hidden" name="logout" value="y">
		        		<input type="submit" name="slogout" value="<?php echo $logout; ?>">
		        	</form>
		        </li>
		      </ol>
		    </nav>
         </span>
      </div>
   </div>
</nav>
<div class="partner-index__main-container pt-5">
	<div class="container pt-1 pb-5">
		<div class="row">
			<div class="col-md-6 col-sm-12 col-12 pe-modify-4">
				<p class="lead partner__main-content"><?php echo $text1; ?></p>
				<p class="lead partner__main-content"><?php echo $text2; ?></p>
				<p class="lead partner__main-content"><?php echo $text3; ?></p>
				<p class="lead partner__main-content"><?php echo $text4; ?></p>
			</div>
			<div class="col-md-6 col-sm-12 col-12 ps-md-3">
				<h2 class="partner-index__title"><?php echo $titleMainNews; ?></h2>
				<?php if($_GET['archiv'] == "" && $archiv_array): ?>
				<table class="table table-borderless news__item-col" id="newsMainPagination">

				</table>

        <!-- Pagination -->
        <nav class="pagination__td">
            <ul class="pagination justify-content-center">

              <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                  <a class="page-link"  id="<?php echo $page-1;?>"
                      href="<?php if($page <= 1){ echo '#'; } else { echo "" . $s_prev; } ?>"><span aria-hidden="true">‹</span></a>
              </li>

              <?php if($totoalPages <= $maxPagePoint) { ?>
                  <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                  <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                      <a class="page-link" id="<?php echo $i ?>" href=""> <?= $i; ?> </a>
                  </li>
                  <?php endfor; ?>
              <?php } elseif($totoalPages > $maxPagePoint) { ?>
                <?php if($page <= $offsetMaxPagePoint) { ?>
                  <?php
            for ($counter = 1; $counter < $perr; $counter++){    
              if ($counter == $page) {
                  echo "<li class='page-item active'><a id='".$counter."' class='page-link'>$counter</a></li>"; 
              } else {
                      echo "<li class='page-item'><a id='".$counter."' class='page-link' href=''>$counter</a></li>";
              }
                }
            echo "<li class='page-item'><a class='page-link'>...</a></li>";
            echo "<li class='page-item'><a id='".$second_last."' class='page-link' href=''>$second_last</a></li>";
            echo "<li class='page-item'><a id='".$totoalPages."' class='page-link' href=''>$totoalPages</a></li>";
            ?>
                <?php } elseif($page > $offsetMaxPagePoint && $page < $totoalPages - $offsetMaxPagePoint) { ?>
            <?php
            echo "<li class='page-item'><a id='1' class='page-link' href=''>1</a></li>";
            echo "<li class='page-item'><a id='2' class='page-link' href=''>2</a></li>";
                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {     
                    if ($counter == $page) {
                  echo "<li class='page-item active'><a class='page-link'>$counter</a></li>"; 
                } else {
                      echo "<li class='page-item'><a id='".$counter."' class='page-link' href=''>$counter</a></li>";
                }                  
               }
               echo "<li class='page-item'><a class='page-link'>...</a></li>";
             echo "<li class='page-item'><a id='".$second_last."' class='page-link' href=''>$second_last</a></li>";
             echo "<li class='page-item'><a id='".$totoalPages."' class='page-link' href=''>$totoalPages</a></li>";
             ?>
                <?php } else { ?>
            <?php
                echo "<li class='page-item'><a id='1' class='page-link' href=''>1</a></li>";
            echo "<li class='page-item'><a id='2' class='page-link' href=''>2</a></li>";
                echo "<li class='page-item'><a class='page-link'>...</a></li>";

                for ($counter = $totoalPages - $perr2; $counter <= $totoalPages; $counter++) {
                  if ($counter == $page) {
                  echo "<li class='page-item active'><a class='page-link'>$counter</a></li>"; 
               } else {
                      echo "<li class='page-item'><a id='".$counter."' class='page-link' href=''>$counter</a></li>";
               }                   
                }
                ?>
                <?php } ?>
              <?php } ?>


              <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                  <a class="page-link"  id="<?php echo $page+1; ?>"
                      href="<?php if($page >= $totoalPages){ echo '#'; } else {echo "". $s_next; } ?>"><span aria-hidden="true">›</span></a>
              </li>

            </ul>
        </nav>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
  $(document).ready(function(){

    function lodetable(page){
    	  var actionUrl = "/content/partner/main-pagination-data.php";
          $.ajax({
            url : actionUrl,
            type : 'POST',
            data : {page_no:page},
            success : function(data) {
              $('#newsMainPagination').html(data);
            }
          });
      }
      lodetable();

    $(document).on("click",".pagination__td ul.pagination li > a",function(e) {
        e.preventDefault();
        var page_id = $(this).attr("id");
        lodetable(page_id);
    });

  });
});
</script>