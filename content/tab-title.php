<?php

if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}
switch ($langLink) {
  case "de":
    $search = 'Suche';
    $allproducts = 'Produktübersicht';
    $anmeldung = 'ANMELDUNG NEWSLETTER';
    $imprint = 'Impressum';
    $privacy = 'Datenschutz';
    $agb = 'AGB';
    $support = 'DIE UNTERSTÜTZUNG';
    $p1 = 'Startseite';
    $ps1 = 'Unternehmen';
    $i1 = 'Kontakt';
    $n1 = 'News';
    $cat = 'PRODUKTKATEGORIEN';
  break;
  case "en":
    $search = 'Search';
    $allproducts = 'Product overview';
    $anmeldung = 'NEWSLETTER REGISTRATION';
    $imprint = 'Imprint';
    $privacy = 'Privacy policy';
    $agb = 'AGB';
    $support = 'SUPPORT';
    $p1 = 'Home';
    $ps1 = 'Company';
    $i1 = 'Contact';
    $n1 = 'News';
    $cat = 'PRODUCT CATEGORIES';
  break;
}


$delimiter = '';

if( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'about' ) {
	$delimiter = '|';
	$tabtitle = $ps1;
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'contact' ) {
	$delimiter = '|';
	$tabtitle = $i1;
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'news' && !isset($content[2]) ) {
	$delimiter = '|';
	$tabtitle = $n1;	
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'partner' && !isset($content[2]) ) {
	$delimiter = '|';
	$tabtitle = 'Partner-net';
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'products' && !isset($content[2]) ) {
	$delimiter = '|';
	$tabtitle = $cat;
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'support' ) {
	$delimiter = '|';
	$tabtitle = $support;
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'agb'  ) {
	$delimiter = '|';
	$tabtitle = $agb;
} elseif(  ($content[0]=='de' || $content[0]=='en') && $content[1] == 'datenschutz' ) {
	$delimiter = '|';
	$tabtitle = $privacy;
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'impressum' ) {
	$delimiter = '|';
	$tabtitle = $imprint;
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'anmeldung' ) {
	$delimiter = '|';
	$tabtitle = $anmeldung;
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'produkt-uebersicht' ) {
	$delimiter = '|';
	$tabtitle = $allproducts;
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'search' ) {
	$delimiter = '|';
	$tabtitle = $search;
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'products' && isset($content[2]) && !isset($content[3]) ) {
	$delimiter = '|';
	$tabtitle = urldecode($content[2]);
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'products' && isset($content[2]) && isset($content[3]) && !isset($content[4]) ) {
	$delimiter = '|';
	switch ($langLink) {
		case "de":
			$product =  $DB->query_fetch("SELECT name as px1 FROM products WHERE seo_url='".$content[3]."'");
		break;
		case "en":
			$product =  $DB->query_fetch("SELECT name_en as px1 FROM products WHERE seo_url='".$content[3]."'");
		break;
	}
	$tabtitle = $product['px1'];	
} elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'news' && isset($content[2]) && !isset($content[3]) ) {
	$delimiter = '|';
	$news = $DB->query_fetch('SELECT news_headline  FROM news_text WHERE id = '.$content[2].' LIMIT 1;');
	$tabtitle = $news['news_headline'];
}  elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'partner' && isset($content[2]) && !isset($content[3]) ) {
	$delimiter = '|';
	$tabtitle = 'Partner-net';
}