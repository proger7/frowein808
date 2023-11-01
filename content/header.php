<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="de">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--
    <meta http-equiv="Content-Security-Policy" content="default-src 'none'; object-src 'self'; frame-src 'self ';">
    <meta name="referrer" content="no-referrer, same-origin">
    -->




    <?php include("tab-title.php"); ?>
    <title>Frowein 808 <?php echo $delimiter . ' ' . $tabtitle; ?></title>

    <meta name="keywords" content="<?=$keywords?>">
    <meta name="description" content="Anwender finden bei uns sämtliche Produkte: Insektizide, Rodentizide, Monitoring-Systeme und zweckoptimierte Anwendungsgeräte.">

    <link href="<?php echo $URL_ROOT;?>style/fonts.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $URL_ROOT;?>style/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo $URL_ROOT;?>style/fontawesome/css/fontawesome.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $URL_ROOT;?>style/fontawesome/css/brands.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $URL_ROOT;?>style/fontawesome/css/solid.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $URL_ROOT;?>style/bootstrap-table.min.css">

    <!-- Map Styles -->
    <link href="<?php echo $URL_ROOT;?>style/jqvmap-master/jqvmap.css" media="screen" rel="stylesheet" type="text/css"/>

    <!-- Datepicker Styles -->
    <link rel='stylesheet' href='<?php echo $URL_ROOT;?>style/bootstrap-datepicker.min.css'>

    <?php foreach ($css_files as $css){?>
    	<link rel="stylesheet" type="text/css" media="screen,projection" href="<?=$css?>" />  
    <?php } ?>

    <script src="/js/jquery.min.js"></script>
    <!--<script src="/js/api-de.js"></script>-->

    <script>
        jQuery.noConflict();
    </script>

    <?php if($page['id'] =='31') { ?>
        <script type="text/javascript" src="/js/prototype.js"></script>
    <?php } ?>
    
    <?php foreach ($js_files as $js){?>
    	<script type="text/javascript" src="<?=$js?>"></script>  
    <?php }  ?>

    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/js/hide.password.js"></script>
    <script type="text/javascript" src="/js/carousel.js"></script>
    <script type="text/javascript" src="/js/search.js"></script>



    <script type="text/javascript" src="/js/bootstrap-table.min.js"></script>
    <script type="text/javascript" src="/js/select2.js"></script>
    <script type="text/javascript" src="/js/language.js"></script>
    <script type="text/javascript" src="/js/personalForm.js"></script>

    <!-- Datepicker -->
    <script type="text/javascript" src='/js/bootstrap-datepicker.min.js'></script>
    <!-- Select Change Item -->
    <script type="text/javascript" src='/js/select-change-item-content.js'></script>
    <!-- Germany Map -->
    <script type="text/javascript" src="/js/jqvmap-master/jquery.vmap.js"></script>
    <script type="text/javascript" src="/js/jqvmap-master/maps/jquery.vmap.germany.js"></script>
    <script type="text/javascript" src="/js/jqvmap-master/jquery.vmap.europe-better.js"></script>
    <script type="text/javascript" src="/js/jqvmap-master/maps/jquery.vmap.world.js"></script>
    <script type="text/javascript" src="/js/jqvmap-master/jquery.vmap.sampledata.js"></script>
    <!--  Submenu -->
    <script type="text/javascript" src="/js/submenu.js"></script>



    <!-- from unpkg -->
    <!-- <script type="module" src="https://unpkg.com/friendly-challenge@0.9.9/widget.module.min.js" async defer></script>
    <script nomodule src="https://unpkg.com/friendly-challenge@0.9.9/widget.min.js" async defer></script> -->

    <!-- OR from jsdelivr -->
    <!-- <script
      type="module"
      src="https://cdn.jsdelivr.net/npm/friendly-challenge@0.9.9/widget.module.min.js"
      async
      defer
    ></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/friendly-challenge@0.9.9/widget.min.js" async defer></script> -->



    <!-- Multiselect -->
    <script type="text/javascript" src="/js/multiselect/jquery.multi-select.js"></script>
    <link rel="stylesheet" type="text/css" href="/style/multiselect/example-styles.css">

    <!-- Mobile Select -->
    <script type="text/javascript" src="/js/mobileSelect/bootstrap-fullscreen-select.js"></script>
    <link rel="stylesheet" type="text/css" href="/style/mobileSelect/bootstrap-fullscreen-select.css">

    <script type="text/javascript">
    jQuery(function ($){


      var full_url = window.location.pathname;
      var rest = full_url.split('/');
      var l = rest.length - 1; 
      var subUrl = rest[rest.length - l];


      var url_parts = full_url.replace(/\/\s*$/,'').split('/'); 
      url_parts.shift(); 
      console.log(url_parts);

      var uri = window.location.href;


      $('#id_select2_example').on('change', function () {
          var url = $(this).val();
          if (url) {

              if( ( url_parts[0] == "de" || url_parts[0] == "en" ) && url_parts[1] == "products" && url_parts[2] !== "" && url_parts[3] !== "" && url_parts.length == 4 ) {
                  if(subUrl == 'de') {


                    var str1 = '/' + url_parts[2] + '/';
                    if( str1 == '/APPLIKATIONSGER%C3%84TE/' ) {
                      var y = uri.replace('/de/', '/en/').replace(str1, '/APPLICATION+EQUIPMENT/');
                    } else if( str1 == '/BETTWANZENBEK%C3%84MPFUNG/' ) {
                      var y = uri.replace('/de/', '/en/').replace(str1, '/BED+BUG+CONTROL/');
                    } else if( str1 == '/DESINFEKTIONS-+%26+PFLEGEMITTEL/' ) {
                      var y = uri.replace('/de/', '/en/').replace(str1, '/Products+for+disinfection+and+care/');
                    } else if( str1 == '/INSEKTENBEK%C3%84MPFUNG/' ) {
                      var y = uri.replace('/de/', '/en/').replace(str1, '/INSECT+CONTROL/');
                    } else if( str1 == '/SCHADNAGERBEK%C3%84MPFUNG/' ) {
                      var y = uri.replace('/de/', '/en/').replace(str1, '/RODENT+CONTROL/');
                    } else if( str1 == '/SPEZIALPRODUKTE/' ) {
                      var y = uri.replace('/de/', '/en/').replace(str1, '/SPECIAL+PRODUCTS/');
                    } else if( str1 == '/TAUBENABWEHR/' ) {
                      var y = uri.replace('/de/', '/en/').replace(str1, '/PIGEON+REPELLENT/');
                    }
                    
                    window.location = y;

                  } else if(subUrl == 'en') {

                    var str1 = '/' + url_parts[2] + '/';
                    if( str1 == '/APPLICATION+EQUIPMENT/' ) {
                      var y = uri.replace('/en/', '/de/').replace(str1, '/APPLIKATIONSGER%C3%84TE/');
                    } else if( str1 == '/BED+BUG+CONTROL/' ) {
                      var y = uri.replace('/en/', '/de/').replace(str1, '/BETTWANZENBEK%C3%84MPFUNG/');
                    } else if( str1 == '/Products+for+disinfection+and+care/' ) {
                      var y = uri.replace('/en/', '/de/').replace(str1, '/DESINFEKTIONS-+%26+PFLEGEMITTEL/');
                    } else if( str1 == '/INSECT+CONTROL/' ) {
                      var y = uri.replace('/en/', '/de/').replace(str1, '/INSEKTENBEK%C3%84MPFUNG/');
                    } else if( str1 == '/RODENT+CONTROL/' ) {
                      var y = uri.replace('/en/', '/de/').replace(str1, '/CHADNAGERBEK%C3%84MPFUNG/');
                    } else if( str1 == '/SPECIAL+PRODUCTS/' ) {
                      var y = uri.replace('/en/', '/de/').replace(str1, '/SPEZIALPRODUKTE/');
                    } else if( str1 == '/PIGEON+REPELLENT/' ) {
                      var y = uri.replace('/en/', '/de/').replace(str1, '/TAUBENABWEHR/');
                    }

                    window.location = y;

                  }
                    
                  
              } else {
                  if(subUrl == 'de') {
                    var x = full_url.replace('de', 'en');
                    window.location = x;

                  } else if(subUrl == 'en') {
                    var x = full_url.replace('en', 'de');
                    window.location = x;
                  }
              }
              
          }
          return false;
      });



      $('.submenu_items #list_products').each( function(i,v) {
        $(this).hover(function () {
              var id = $(this).attr('data-id');
              var allProd = $(this).attr('data-prod');
              var allCat = $(this).attr('data-cat');

              $.ajax({
                  url:"/content/show_submenu_products.php",
                  method:"POST",
                  data:{product_id:id,prod_checker:allProd,cat_checker:allCat},
                  success:function(data){
                      $('.productlist_show').html(data);
                  }
              });

              $.ajax({
                  url:"/content/show_submenu_catdesc.php",
                  method:"POST",
                  data:{product_id:id,cat_checker:allCat},
                  success:function(data){
                      $('.category_desc').html(data);
                  }
              });

          });
      });
    });
    </script>
    <script type="text/javascript" src="/js/cookiePro.js"></script>
    <script type="text/javascript" src="/js/jquery.cookie.js"></script>

    <!-------------------------------------------------------------------------------------------->



    <?php
        $cookie_arr = explode('&', $_COOKIE['cookie_consent_level']);
        $x1 = json_decode($cookie_arr[0], true);
        foreach($cookie_arr as $coo){
            $x = explode('=', $coo);
            $cookies[$x[0]] = $x[1];
        }

        if(isset($_COOKIE['cookie_consent_user_accepted']) && $x1['functionality'] == 1 && $x1['tracking'] == 1){
            ?>
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106478721-1"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments)};
                gtag('js', new Date());
                gtag('config', 'UA-106478721-1');
                <!-- Global site tag (gtag.js) - Google Analytics -->


                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-106478721-1']);
                _gaq.push(['_setCampaignCookieTimeout', 0]);
                _gaq.push(['_trackPageview']);

                (function() {
                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                })();
            </script>
        <?php } ?>
    <!-------------------------------------------------------------------------------------------->
</head>
<body class="<?=$hierarchy===false?'home':'include'?>">
 
<?php
if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}

if( ($content[0] == 'activate' && is_numeric($content[1])) ||($content[0] == 'abmeldung_confirm') || ($content[0] == 'anmeldung') ) {
  $langLink = 'de';
}

switch ($langLink) {
	case "de":
		$supportLinkHeader = 'Kontaktformular';
		$loginLink = 'Partner Login';
	break;
	case "en":
		$supportLinkHeader = 'Support';
		$loginLink = 'Partner Login';
	break;
}
?>
<header class="header__container">
    <div class="topHeader">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 col-12 hideLines">
                    <img src="/images/svg/lines.svg">
                </div>
                <div class="col-md-7 col-sm-12 col-12 items_top">
                  <div class="container paddingZero">
                    <div class="row fullWidth">
                        <div class="col-md-3 col-sm-12 col-12 support">
                          <a href="/<?=$langLink;?>/support/" class="support-link"><img src="/images/svg/support icon.svg"><?=$supportLinkHeader?></a>
                        </div>
                        <div class="col-md-5 col-sm-12 col-12 tel">
                          <a href="tel:+49 7432 956-0" class="tel-link"><img src="/images/svg/tel.svg">+49 7432 956-0</a>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12 email">
                          <a href="mailto:info@frowein808.de" class="email-link"><img src="/images/svg/mail.svg">info@frowein808.de</a>
                        </div>
                    </div>                    
                  </div>
                </div>  
            </div>
        </div>
    </div>
   <div class="container">
      <div class="top">
         <div class="logo th">
            <a href="<?= $URL_ROOT . $langLink;?>"><img style="width: 70%" class="toplogo" src="/office365/teams/frowein808-msteamslogo.png"></a>
         </div>
         <div class="name th" id="nameLogo">
            FROWEIN GmbH & Co. KG
         </div>

         <div class="name th">
    			<form action="<?php echo $URL_ROOT . $langLink; ?>/search/" method="POST" class="search m-0 text-end" id="top_search">
    				<input type="text" class="rounded-0 shadow-none px-3" name="criteria" placeholder="Suche" required>
    				<button type="button" class="search-button bg-body border-0 rounded-0 shadow-none">
    					<img src="/images/search1.svg">
    				</button>
    			</form>
    		</div>

        <?php if ( isset($_SESSION["_registry"]["frontend_user"]) ): ?>
          <div class="partner th" id="header_logout_btn">
              <form action="/logout.php" method="POST" class="mb-0 needs-validation" novalidate>
                <input type="hidden" name="logout" value="y">
                <input type="submit" name="slogout" value="Ausloggen">
              </form>
          </div>
        <?php endif;?>

        <?php
        if (isset($_SESSION["_registry"]["frontend_user"]["KUNDENNUMMER"]) && isset($_SESSION["_registry"]["frontend_user"]["PASSWORT"])){
                $KUNDENNUMMER = $_SESSION["_registry"]["frontend_user"]["KUNDENNUMMER"];
                $PASSWORT = $_SESSION["_registry"]["frontend_user"]["PASSWORT"];
        }
        $fullName = $DB->query_fetch('SELECT user_name,user_nachname FROM newsletter_users WHERE kundennummer="'.$KUNDENNUMMER.'" AND user_pass="'.$PASSWORT.'" AND status = 1 LIMIT 1;');
        ?>

        <div class="partner th">
            <?php if ( !isset($_SESSION["_registry"]["frontend_user"]) ): ?>
              <a href="/<?=$langLink;?>/partner/"><img src="/images/svg/partner icon.svg"> <?=$loginLink;?></a>
            <?php else: ?>
              <a href="/<?=$langLink;?>/partner/"><img src="/images/svg/partner icon.svg"><b><?php echo $fullName['user_name'] . ' ' . $fullName['user_nachname'];?></b></a>
            <?php endif;?>
        </div>          


         <div class="lang th">
            <select class="form-select lang-switcher" id="id_select2_example">
                <option data-img_src="/images/flags/de.png" <?php if($content[0]=="de"){echo "selected";}?> value="de">DE</option>
                <option data-img_src="/images/flags/en.png" <?php if($content[0]=="en"){echo "selected";  }?> value="en">EN</option>
            </select>
         </div>
      </div>
   </div>

   <div class="bottom">
      <div class="container">
         <nav class="menu">
         	<?php
				switch ($langLink) {
					case "de":
						echo <<<END
						<ul class="top-menu">
						   <li>
						      <a href="/$langLink/"><img src="/images/svg/Startseite.svg"><span class="right-arrows">&raquo;</span><span class="titleHeader">Startseite</span></a>
						   </li>
						   <li>
						      <a href="/$langLink/about/"><img src="/images/svg/Unternehmen.svg"><span class="right-arrows">&raquo;</span><span class="titleHeader">Unternehmen</span></a>
						   </li>
						   <li class="has-submenu">
						    <a href="/$langLink/products/">
						      <img src="/images/svg/allproducts1_red1.svg"><span class="right-arrows">&raquo;</span><span class="titleHeader">Produkte</span>
						    </a>
						  </li>
						   <li>
						      <a href="/$langLink/news/"><img src="/images/svg/aktuelles.svg"><span class="right-arrows">&raquo;</span><span class="titleHeader">News</span></a>
						   </li>
						   <li>
						      <a href="/$langLink/contact/"><img src="/images/svg/Kontakt.svg"><span class="right-arrows">&raquo;</span><span class="titleHeader">Kontakt</span></a>
						   </li>
						</ul>
						END;
					break;
					case "en":
						echo <<<END
						<ul class="top-menu">
						   <li>
						      <a href="/$langLink/"><img src="/images/svg/Startseite.svg"><span class="right-arrows">&raquo;</span><span class="titleHeader">Home</span></a>
						   </li>
						   <li>
						      <a href="/$langLink/about/"><img src="/images/svg/Unternehmen.svg"><span class="right-arrows">&raquo;</span><span class="titleHeader">Company</span></a>
						   </li>
						   <li class="has-submenu">
						    <a href="/$langLink/products/">
						      <img src="/images/svg/allproducts1_red1.svg"><span class="right-arrows">&raquo;</span><span class="titleHeader">Products</span>
						    </a>
						  </li>
						   <li>
						      <a href="/$langLink/news/"><img src="/images/svg/aktuelles.svg"><span class="right-arrows">&raquo;</span><span class="titleHeader">News</span></a>
						   </li>
						   <li>
						      <a href="/$langLink/contact/"><img src="/images/svg/Kontakt.svg"><span class="right-arrows">&raquo;</span><span class="titleHeader">Contact</span></a>
						   </li>
						</ul>
						END;
					break;
				}
         	?>
         </nav>
      </div>
   </div>

    <?php
        switch ($langLink) {
          case "de":
            $categories = $DB->select("SELECT name,cat_icon_class FROM products_categories WHERE status = 1 ORDER BY `order`;");
          break;
          case "en":
            $categories = $DB->select("SELECT name_en,cat_icon_class FROM products_categories WHERE status = 1 ORDER BY `order`;");
          break;
        }
    
    ?>
    <div class="nav-main container" style="display: none;">
      <div class="row w-100">
        <div class="col-auto border-end">
          <ul class="submenu_items pt-4 ps-4 pe-3 pb-3">

            <?php
              switch ($langLink) {
                case "de":
                  $allProducts = 'Produktübersicht';
                  $allCategories = 'Kategorie Übersicht';
                break;
                case "en":
                  $allProducts = 'Product overview';
                  $allCategories = 'Category overview';
                break;
              }
            ?>

            <li class="nav-all_products" id="list_products" data-id="" data-cat="1">
              <a href="/<?=$langLink;?>/products/"><?php echo $allCategories; ?></a>
            </li>
            <li class="nav-all_products" id="list_products" data-id="" data-prod="1">
              <a href="/<?=$langLink;?>/produkt-uebersicht/"><?php echo $allProducts; ?></a>
            </li>


             <?php foreach ($categories as $cat): ?>
              <?php
                switch ($langLink) {
                  case "de":
                    $name = $cat['name'];
                  break;
                  case "en":
                    $name = $cat['name_en'];  
                  break;
                }
              ?>

              <?php if(!empty($name)): ?>
                 <li class="<?php echo $cat['cat_icon_class'];?>" id="list_products" data-id="<?php echo $name ?>">
                    <a href="<?php echo $URL_ROOT.$langLink.'/products/'.$name;?>"><?php echo $name;?> <img src="/images/submenu/arrow1.svg" class="ps-4"></a>
                 </li>
              <?php endif; ?>


             <?php endforeach; ?>
          </ul>
        </div>
        <div class="col border-end">
          <div class="row">
            <div class="col">
              <ul class="submenu_sub-items pt-4 ps-2 pe-3 pb-3 productlist_show">

                <?php

                $countQuery = $DB->query_fetch("SELECT count(*) as c FROM products_categories WHERE status = 1");
                $n = ceil($countQuery['c'] / 2);
                $m = 2 * $n;

                switch ($langLink) {
                    case 'de':
                      $query = "SELECT name as product_name,short_text as product_descr,cat_image FROM products_categories WHERE status = 1 AND (`order` % 2) > 0 ORDER BY `order` ";
                    break;
                    case 'en':
                      $query = "SELECT name_en as product_name,short_text_en as product_descr,cat_image FROM products_categories WHERE status = 1 AND (`order` % 2) > 0 ORDER BY `order` ";
                    break;
                }

                $menuProducts = $DB->select($query);
                foreach($menuProducts as $k => $product):
                    $link = '/'. $langLink .'/products/' .$product['product_name'];
                    $img = $IMAGE->get_image($product['cat_image']);
                    if( !empty($product['product_name']) ) {
                    ?>
                    <div class="row mb-2 subCategoriesItems" style="border: 1px solid #dee2e6;">
                      <div class="col-md-4 col-sm-12 col-12 p-2">
                        <?php // echo $img ?>
                        <?php 
                        switch ($k) {
                          case 0:
                            $imgIcon = '<img src="/images/products/nav/category_icons/INSEKTENBEKAMPFUNGicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 1:
                            $imgIcon = '<img src="/images/products/nav/category_icons/SCHANDAicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 2:
                            $imgIcon = '<img src="/images/products/nav/category_icons/BETTWANZicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 3:
                            $imgIcon = '<img src="/images/products/nav/category_icons/APPLIKATIONicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                        }

                        ?>
                        
                      </div>
                      <div class="col-md-8 col-sm-12 col-12 pt-2" id="verticallyCenter">
                        <a href="<?php echo $link ?>" class="sub__cat-title"><?php echo $product['product_name'] ?></a>
                        <p class="sub__cat-content"><?php echo strip_tags($product['product_descr']);?></p>
                      </div>
                    </div>
                    <?php } ?>
                <?php endforeach;?>

                

              </ul>
            </div>

          </div>
        </div>
        <div class="col">
          <div class="pt-4 ps-3 pe-2 pb-3 category_desc">
            <?php



                switch ($langLink) {
                    case 'de':
                      $mehrLinkSubmenu = 'Alle Kategorien anzeigen';
                      $query = "SELECT name as product_name,short_text as product_descr,cat_image FROM products_categories WHERE (`order` % 2) = 0 and status = 1 AND (`order` % 2) = 0 ORDER BY `order`";
                    break;
                    case 'en':
                      $mehrLinkSubmenu = 'Show all categories';
                      $query = "SELECT name_en as product_name,short_text_en as product_descr,cat_image FROM products_categories WHERE status = 1 AND (`order` % 2) = 0 ORDER BY `order`";
                    break;
                }

                $menuProducts = $DB->select($query);

                foreach($menuProducts as $key => $product):
                    $link = '/' . $langLink . '/products/' .$product['product_name'];
                    $img = $IMAGE->get_image($product['cat_image']);
                    if( !empty($product['product_name']) ) {
                    ?>
                    <div class="row mb-2 subCategoriesItems" style="border: 1px solid #dee2e6;">
                      <div class="col-md-4 col-sm-12 col-12 p-2">
                        <?php // echo $img ?>
                        <?php 
                        switch ($key) {
                          case 0:
                            $imgIcon = '<img src="/images/products/nav/category_icons/SPEZIALPRODUKTEicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 1:
                            $imgIcon = '<img src="/images/products/nav/category_icons/TAUBENABWEHRicon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                          case 2:
                            $imgIcon = '<img src="/images/products/nav/category_icons/DEZINFKTIONSPFLGEMITTEL icon.svg" style="width: 100% !important;">';
                            echo $imgIcon;
                            break;
                        }

                        ?>
                      </div>
                      <div class="col-md-8 col-sm-12 col-12 pt-2" id="verticallyCenter">
                        <a href="<?php echo $link ?>" class="sub__cat-title"><?php echo $product['product_name'] ?></a>
                        <p class="sub__cat-content"><?php echo strip_tags($product['product_descr'])  ?></p>
                      </div>
                    </div>
                    <?php } ?>
                <?php endforeach;?>

              <ul class="submenu_sub-items py-2">
                <li><a style="color: #e3001b" href="/<?=$langLink;?>/products/"><?php echo $mehrLinkSubmenu;?></a></li>
              </ul>
            
          </div>
        </div>
      </div>
    </div>

    <?php include("breadcrumbs.php"); ?>

</header>

<nav class="navbar navbar-expand-lg navbar-light bg-red" id="mobilenav">
   <div class="container-fluid">
      <a class="navbar-brand" href="/">
        <img src="/images/Frowein_808_mit_biozide_White.svg" width="44" height="26">
      </a>

      <div class="lang th men">
         <ul>
            <li><a href="/de/" class="<?php if($content[0]=='de'){ echo 'active-lang'; } ?>">DE</a></li>
            <li><a href="/en/" class="<?php if($content[0]=='en'){ echo 'active-lang'; } ?>">EN</a></li>
         </ul>
      </div>

      <button class="navbar-toggler" id="hamburgerButton" type="button" data-bs-toggle="collapse" data-bs-target="#navMobMenu" aria-controls="navMobMenu" aria-expanded="false">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMobMenu">
         <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center" id="navmobileMenu">
            <li class="nav-item">
               <a class="nav-link active" aria-current="page" href="/<?=$langLink;?>/">Startseite</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/<?=$langLink;?>/about/">Unternehmen</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/<?=$langLink;?>/products/">Produkte</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/<?=$langLink;?>/news/">News</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/<?=$langLink;?>/contact/">Kontakt</a>
            </li>
         </ul>
      </div>
   </div>
</nav>
<h1 style="position:absolute;left:-5000px">Frowein GmbH. Competence in Biocides.</h1>


