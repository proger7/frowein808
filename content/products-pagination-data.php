<?php
require("./../includes/general.inc.php");


$s_lang_id = 1;

$s_maxPagePoint = 10;
$s_offsetMaxPagePoint = 4;
$s_adjacents = "2";
$sperr = 8;
$sperr2 = 6;


$s_limit = 9;
$s_page = isset($_POST['page_no'])  ? $_POST['page_no'] : 1;
$s_paginationStart = ($s_page - 1) * $s_limit;

$category = $DB->query_fetch("SELECT * FROM products_categories WHERE name = '".urldecode($_POST['page_url'])."' LIMIT 1;");

$products = $DB->select("SELECT * FROM products WHERE category = ".$category["id"]." AND status = 1 order by `order` LIMIT $s_paginationStart, $s_limit");

// Get total records

$s_sql = $DB->select("SELECT count(id) AS id FROM products WHERE category = ".$category["id"]." AND status = 1");
$sallRecrods = $s_sql[0]['id'];

// Calculate total pages
$s_totoalPages = ceil($sallRecrods / $s_limit);
$q_second_last = $s_totoalPages - 1;

// Prev + Next
$s_prev = $s_page - 1;
$s_next = $s_page + 1;

?>
<?php foreach ($products as $product):?>
	<?php $productLink = '/products/'.$_POST['page_url'].'/'.$product['seo_url'];?>
	<div class="col">
		<div class="card">
			<a href="<?php echo $productLink;?>">
				<?php echo $IMAGE->get_image($product['image']);?>
			</a>
			<div class="card-body">
				<h5 class="card-title"><a href="<?php echo $productLink;?>"><?php echo $product['name'];?></a></h5>
				<p class="card-text"><?php echo strip_tags($product['red_text']);?></p>
				<a href="<?php echo $productLink;?>" class="card-link">Mehr erfahren..</a>
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
</nav>