<?php
// $getURL = $content[0];
$lang = $LANG["language"]["shortname"];
switch ($lang) {
	case "de":
		echo <<<END
		<div id="demo" class="carousel slide" data-bs-ride="carousel">
		  <div class="carousel-inner">
		    <div class="carousel-item active">
		      <img src="/images/slider/slider1-1.png" class="d-block" style="width:100%">
		    </div>
		</div>
		END;
		include 'home-content.php'; 
	break;

	case "en":
		echo <<<END
		<div id="demo" class="carousel slide" data-bs-ride="carousel">
		  <div class="carousel-inner">
		    <div class="carousel-item active">
		      <img src="/images/slider/slider1-1.png" class="d-block" style="width:100%">
		    </div>
		</div>
		END;
		include 'home-content.php';
	break;
}