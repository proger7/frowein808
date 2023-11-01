<?php
$getUserName = $DB->query_fetch('SELECT user_name FROM newsletter_users WHERE kundennummer="'.$KUNDENNUMMER.'" AND user_pass="'.$PASSWORT.'" AND status = 1 LIMIT 1;');

if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}

switch ($langLink) {
  case "de":
    $tableTh1 = "Auswahlen";
    $tableTh2 = "Titel";
    $tableTh3 = "Bezeichnung";
    $selectlang = 1;
    $startpage = 'Startseite';
    $item1 = 'Allgemein';
    $item2 = 'Produktübersicht';
    $item3 = 'Informationsmaterial';
    $item4 = 'Persönliche Daten';
    $logAsName = 'Angemeldet als';
    $logout = 'Ausloggen';
    $value = "Bestellen";
  break;
  case "en":
    $tableTh1 = "Choose";
    $tableTh2 = "Title";
    $tableTh3 = "Designation";
    $selectlang = 2;
    $startpage = 'Home';
    $item1 = 'General';
    $item2 = 'Product overview';
    $item3 = 'Information material';
    $item4 = 'Personal data';
    $logAsName = 'Logged in as';
    $logout = 'Log out';
    $value = "order";
  break;
}


$query = 'SELECT p.id AS p_id,
           p.news_headline AS p_news_headline,
         p.news_subline AS p_news_subline,
         c.cat_name AS c_cat_name
        FROM orderinfo_text AS p,
         orderinfo_categories AS c
       WHERE c.id = p.news_cat_id
         AND c.status = 1
         AND p.status = 1
       AND c.language_id = '.$selectlang.'
    ORDER BY c.order_id,p.order_id
       ';
$rows = $DB->select($query);
$num = $DB->affected($res);

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
               <a class="nav-link" href="/<?php echo $langLink; ?>/partner/downloads/"><?php echo $item2; ?></a>
            </li>
            <li class="nav-item menu-item-3 me-1">
               <a class="nav-link active" href="/<?php echo $langLink; ?>/partner/order/"><?php echo $item3; ?></a>
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
          <form class="mo__full-width"   style="width: 927px; margin: 0;" method="get" action="" >
             <div class="mb-0 me-md-3">
                <input style="height: 50px" type="text" class="search-field form-control" id="search-field-header" name="s" placeholder="Search">
             </div>
          </form>
      </div>
   </div>
</nav>
<div class="container pt-0" id="mobileTableHide">
  <div class="bootstrap-table bootstrap5">

      <form name="order" method="POST" action="../order_send/">
          <table id="table"
           data-toggle="table"
           data-search="true"
           >
               <thead>
                  <th data-field="id"><?php echo $tableTh1; ?></th>
                  <th data-field="name"><?php echo $tableTh2; ?></th>
                  <th data-field="description"><?php echo $tableTh3; ?></th>
               </thead>
               <tbody class="orderList">
                  <?php foreach($rows as $row): ?>
                      <?php if ($lastcat != $row["c_cat_name"]): ?>
                        <tr>
                            <td colspan="3" rowspan="1" class="categoryHead"><?php echo $row["c_cat_name"];?></td>
                        </tr>
                      <?php endif;?>
                      <tr>
                          <td>
          
                            <label class="like">
                              <input type="checkbox" name="<?php echo 'auswahl_'.$row["p_id"];?>" class="form-check-input">
                            </label>

                          </td>
                          <td><?php echo $row["p_news_headline"]; ?></td>
                          <td><?php echo $row["p_news_subline"];?></td>
                      </tr>
                      <?php $lastcat = $row["c_cat_name"]; ?>
                  <?php endforeach; ?>
                  <tr class="noHover">
                    <td colspan="3" rowspan="1" class="button_order">
                      <input type="submit" value="<?php echo $value;?>" id="send_order_btn">
                      <input type="hidden" name="SPRACHE" value="<?php echo $SPRACHE;?>">
                    </td>
                  </tr>
               </tbody>
          </table>
      </form>

  </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
  $(document).ready(function(){

      $('#search-field-header').keyup(function () {
          var rex = new RegExp($(this).val(), 'i');
          $('#table tbody tr').hide();
          $('#table tbody tr').filter(function () {
              return rex.test($(this).text());
          }).show();
      });

  });
});
</script>