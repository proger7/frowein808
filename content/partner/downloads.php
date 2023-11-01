<?php
$getUserName = $DB->query_fetch('SELECT user_name FROM newsletter_users WHERE kundennummer="'.$KUNDENNUMMER.'" AND user_pass="'.$PASSWORT.'" AND status = 1 LIMIT 1;');

if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}
switch ($langLink) {
  case "de":
    $tableColName1 = "Artikel";
    $tableColName2 = "Typ";
    $tableColName3 = "Produkt-<br>Information";
    $tableColName4 = "Sicherheits-<br>Datenblatt";
    $tableNewItem = "Packungs-<br>beilage";
    $tableColName5 = "Gebrauchs-<br>anweisung";
    $startpage = 'Startseite';
    $lang_id = 1;
    $item1 = 'Allgemein';
    $item2 = 'Produktübersicht';
    $item3 = 'Informationsmaterial';
    $item4 = 'Persönliche Daten';
    $logAsName = 'Angemeldet als';
    $logout = 'Ausloggen';
  break;
  case "en":
    $tableColName1 = "Article";
    $tableColName2 = "Type";
    $tableColName3 = "Product <br>Information";
    $tableColName4 = "Safety Data<br> Sheet";
    $tableNewItem = "Package insert";
    $tableColName5 = "Encoder usage<br>instruction";
    $startpage = 'Home';
    $lang_id = 2;
    $item1 = 'General';
    $item2 = 'Product overview';
    $item3 = 'Information material';
    $item4 = 'Personal data';
    $logAsName = 'Logged in as';
    $logout = 'Log out';
  break;
}

?>
<div class="breadcrumbs py-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $startpage; ?></a></li>
        <li class="breadcrumb-item active" aria-current="page">PARTNER-NET</li>
      </ol>
    </nav>
</div>
<nav class="navbar navbar-expand-lg pt-0">
   <div class="container">
      <div class="collapse navbar-collapse border-bottom" id="navbarText">
         <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="site-navigation">
            <li class="nav-item menu-item-1 me-1">
               <a class="nav-link" aria-current="page" href="/<?php echo $langLink; ?>/partner/"><?php echo $item1; ?></a>
            </li>
            <li class="nav-item menu-item-2 me-1">
               <a class="nav-link active" href="/<?php echo $langLink; ?>/partner/downloads/"><?php echo $item2; ?></a>
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
                <li class="breadcrumb-item" aria-current="page"><?php echo $logAsName; ?> <b><?php echo $getUserName['user_name'];?></b></li>
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
<nav class="navbar navbar-expand-lg pt-0">
   <div class="container">
      <div class="collapse navbar-collapse pt-5 d-flex justify-content-start" id="navbarText">
          <div class="mo__full-width search-box"  style="width: 927px; margin: 0;">
             <form method="GET" action="" class="mb-0 me-md-3">
                <input style="height: 50px" autocomplete="off" type="text" class="search-field form-control full_search-width" id="search-overview-header" name="s1" placeholder="<?php echo $search; ?>">
                <div class="result"></div>
             </form>
          </div>
      </div>
   </div>
</nav>
<div class="container pt-0" id="mobileTableHide">
    <!-- Static HTML -->
    <div class="bootstrap-table bootstrap5">
      <table id="table-overview"
       data-toggle="table"
       data-search="true"
       >
           <thead>
              <th data-field="article"><?php echo $tableColName1; ?></th>
              <th data-field="type"><?php echo $tableColName2; ?></th>
              <th data-field="information"><?php echo $tableColName3; ?></th>
              <th data-field="safetydata"><?php echo $tableColName4; ?></th>
              <th data-field="newItem"><?php echo $tableNewItem; ?></th>
              <th data-field="userguide"><?php echo $tableColName5; ?></th>
           </thead>
           <tbody class="productInfoList">

           </tbody>
      </table> 
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
  $(document).ready(function(){

    function lodetable(page){
        var actionForm = "/content/partner/product-info-data.php";
          $.ajax({
            url : actionForm,
            type : 'POST',
            data : {page_no:page},
            success : function(data) {
              $('.productInfoList').html(data);
            }
          });
      }
      lodetable();

    $(document).on("click",".pagination__td ul.pagination li > a",function(e) {
        e.preventDefault();
        var page_id = $(this).attr("id");
        lodetable(page_id);
    });


    /* Live Search */
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();

        var resultDropdown = $(this).siblings(".result");

        if(inputVal.length){
            $.get("/content/partner/actionSearch.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });



  // $('#search-overview-header').keyup(function () {
  //   var rex = new RegExp($(this).val(), 'i');
  //   $('#table-overview tbody tr').hide();
  //   $('#table-overview tbody tr').filter(function () {
  //       return rex.test($(this).text());
  //   }).show();
  // });


  });
});
</script>