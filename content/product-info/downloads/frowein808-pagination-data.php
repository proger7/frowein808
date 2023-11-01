<?php

require("./../../../includes/general.inc.php");


if($LANG["language"]["shortname"] == "de" || $LANG["language"]["shortname"] == "") {
  $selectlang = 1;
} elseif($LANG["language"]["shortname"] == "en") {
  $selectlang = 2;
}


$maxPagePoint = 10;
$offsetMaxPagePoint = 4;
$adjacents = "2";
$perr = 8;
$perr2 = 6;

$limit = 12;
$page = isset($_POST['page_no']) ? $_POST['page_no'] : 1;
$paginationStart = ($page - 1) * $limit;


$queryProductList = "SELECT c.cat_name AS c_name,
               d.download_title AS d_titel,
               d.download_typ AS d_typ,
               d.download_file1 AS d_file1,
               d.download_file2 AS d_file2,
               d.download_file3 AS d_file3,
               d.download_file4 AS d_file4
              FROM download_categories AS c,
               download_text AS d
             WHERE d.download_cat_id = c.id
               AND c.status = 1
               AND d.status = 1
             AND c.language_id = ".$selectlang."
             ORDER BY c.id, d.id
             LIMIT $paginationStart, $limit";


$productsInfoListArray = $DB->select($queryProductList);


// Get total records
$queryAllCount = "SELECT count(*) as id
              FROM download_categories AS c,
               download_text AS d
             WHERE d.download_cat_id = c.id
               AND c.status = 1
               AND d.status = 1
             AND c.language_id = ".$selectlang;


$sql = $DB->select($queryAllCount);
$allRecrods = $sql[0]['id'];


// Calculate total pages
$totoalPages = ceil($allRecrods / $limit);
$second_last = $totoalPages - 1;

// Prev + Next
$prev = $page - 1;
$next = $page + 1;

?>



<?php foreach($productsInfoListArray as $row): ?>
  <?php
    if (!empty($row["d_file1"])) {
      $file1 = '<a class="download" href="'.$URL_ROOT.'uploads/'.$row["d_file1"].'" download><img src="/images/partner/table/downloadicon.svg"></a>';
      $file1 .= '<a class="view" target="_blank" href="'.$URL_ROOT.'uploads/'.$row["d_file1"].'"><img src="/images/partner/table/viewicon.svg"></a>';
    } else {
      $file1 = " ";
    } 
      
    if (!empty($row['d_file2'])) {
      $file2 = '<a class="download" href="'.$URL_ROOT.'uploads/'.$row["d_file2"].'" download><img src="/images/partner/table/downloadicon.svg"></a>';
      $file2 .= '<a class="view" target="_blank" href="'.$URL_ROOT.'uploads/'.$row["d_file2"].'"><img src="/images/partner/table/viewicon.svg"></a>';
    } else {
      $file2 = " ";
    } 
      
    if (!empty($row['d_file3'])) {
      $file3 = '<a class="download" href="'.$URL_ROOT.'uploads/'.$row["d_file3"].'" download><img src="/images/partner/table/downloadicon.svg"></a>';
      $file3 .= '<a class="view" target="_blank" href="'.$URL_ROOT.'uploads/'.$row["d_file3"].'"><img src="/images/partner/table/viewicon.svg"></a>';
    } else {
      $file3 = " ";
    }

    if (!empty($row['d_file4'])) {
      $file4 = '<a class="download" href="'.$URL_ROOT.'uploads/'.$row["d_file4"].'" download><img src="/images/partner/table/downloadicon.svg"></a>';
      $file4 .= '<a class="view" target="_blank" href="'.$URL_ROOT.'uploads/'.$row["d_file4"].'"><img src="/images/partner/table/viewicon.svg"></a>';
    } else {
      $file4 = " ";
    } 
      
  ?>
  <?php if($lastcat != $row["c_name"]):?>
    <tr>
      <td style="text-align: left;" rowspan="1" colspan="6" class="categoryOverviewHead"><?php echo $row["c_name"]; ?></td>
    </tr>
  <?php endif;?>
  <tr>
     <td><?php echo $row["d_titel"]; ?></td>
     <td style="text-transform: capitalize;"><?php echo $row["d_typ"]; ?></td>
     <td>
       <?php echo $file1; ?>
     </td>
     <td>
        <?php echo $file2; ?>
     </td>

     <td>
       <?php echo $file4; ?>
     </td>
     
     <td>
        <?php echo $file3; ?>
     </td>
  </tr>
  <?php $lastcat = $row["c_name"];?>
<?php endforeach; ?>

<tr>
  <td colspan="6" rowspan="1" class="pagination__td py-3">
        <!-- Pagination -->
        <nav class="pagination__td" aria-label="Page navigation example mt-5">
            <ul class="pagination justify-content-end mb-0">

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
  </td>
</tr>