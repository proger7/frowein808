<?php
if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}


if($content[0] == 'activate' && is_numeric($content[1]) && !isset($content[2])) {
  ?>
  <style type="text/css">
    .bg-image, .btn-link-error.container { display: none !important; }
  </style>
  <?php 
}
?>
<div class="bg-image">
	<div class="d-flex align-items-center justify-content-center vh-100">
	    <div class="text-center">
	        <h1 class="display-1 error-title mb-0"><?=$LANG['404']['main_title'];?></h1>
	        <p class="lead error-text"><?=$LANG['404']['short_text'];?></p>
	    </div>
	</div>
</div>
<div class="btn-link-error container text-center">
	<a href="/" class="error-button mt-0"><?=$LANG['404']['button'];?></a>
</div>