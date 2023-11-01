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
    $support = 'SUPPORT';
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
?>
<?php if( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'about' ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $ps1; ?></li>
        </ol>
      </nav>
  </div>
<?php elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'contact' ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $i1; ?></li>
        </ol>
      </nav>
  </div>
<?php elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'news' && !isset($content[2]) ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $n1; ?></li>
        </ol>
      </nav>
  </div>
<?php elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'partner' && !isset($content[2]) ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page">Partner-net</li>
        </ol>
      </nav>
  </div>
<?php elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'products' && !isset($content[2]) ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $cat; ?></li>
        </ol>
      </nav>
  </div>
<?php elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'support' ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $support; ?></li>
        </ol>
      </nav>
  </div>
<?php elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'agb'  ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $agb; ?></li>
        </ol>
      </nav>
  </div>
<?php elseif(  ($content[0]=='de' || $content[0]=='en') && $content[1] == 'datenschutz' ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $privacy; ?></li>
        </ol>
      </nav>
  </div>
<?php elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'impressum' ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $imprint; ?></li>
        </ol>
      </nav>
  </div>
<?php elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'anmeldung' ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $anmeldung; ?></li>
        </ol>
      </nav>
  </div>
<?php elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'produkt-uebersicht' ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $allproducts; ?></li>
        </ol>
      </nav>
  </div>
<?php elseif( ($content[0]=='de' || $content[0]=='en') && $content[1] == 'search' ): ?>
  <div class="breadcrumbs py-4">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $p1; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $search; ?></li>
        </ol>
      </nav>
  </div>
<?php endif; ?>