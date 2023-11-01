<?php

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
    $search = 'Suchen'; 
  break;
  case "en":
    $tableColName1 = "Article";
    $tableColName2 = "Type";
    $tableColName3 = "Product <br>Information";
    $tableColName4 = "Safety Data<br> Sheet";
    $tableNewItem = "Package<br> insert";
    $tableColName5 = "Encoder usage<br>instruction";
    $startpage = 'Home';
    $lang_id = 2;
    $item1 = 'General';
    $item2 = 'Product overview';
    $item3 = 'Information material';
    $item4 = 'Personal data';
    $logAsName = 'Logged in as';
    $logout = 'Log out';
    $search = 'Search';
  break;
}

?>
<div class="breadcrumbs py-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $startpage; ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $item2; ?></li>
      </ol>
    </nav>
</div>

<nav class="navbar navbar-expand-lg pt-0">
   <div class="container">
      <div class="collapse navbar-collapse border-bottom pt-5 d-flex justify-content-end" id="navbarText">
          <form class="mo__full-width"  style="width: 35%" method="get" action="" >
             <div class="mb-0 me-md-3">
                <input style="height: 50px" type="text" class="search-field form-control full_search-width" id="search-overview-header" name="s1" placeholder="<?php echo $search; ?>">
             </div>
          </form>
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
        var actionForm = "/content/product-info/downloads/frowein808-pagination-data.php";
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


  $('#search-overview-header').keyup(function () {
    var rex = new RegExp($(this).val(), 'i');
    $('#table-overview tbody tr').hide();
    $('#table-overview tbody tr').filter(function () {
        return rex.test($(this).text());
    }).show();
  });


  });
});
</script>