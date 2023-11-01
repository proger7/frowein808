<?php if ( ($content[0] == 'de' || $content[0] == 'en') && ($content[1] == 'about') && !isset($content[2]) ) { ?>
<div class="unternehmen pt-md-5">
	<div class="container pt-4">
		<h2 class="title-unternehmen"><?=$LANG['about']['title']?></h2>

		<div id="background_grey">
			<div class="container pt-md-3 pb-md-4">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-12 pe-md-5 no__padding-image">
						<img src="/images/about/SteffenKönig_Hocker11.jpg" class="img-fluid">
						<span class="contentForImage"><?=$LANG['about']['imgText']?></span>
					</div>
					<div class="col-md-6 col-sm-12 col-12 mission_block">
						<p class="about-full-descr"><?=$LANG['about']['text']?></p>
						<p class="about-full-descr_Mobile"><?=$LANG['about']['textMobile']?></p>
					</div>
				</div>

				<div class="row mt-md-5 about__list px-md-5rem py-md-2">
					<div class="col-md-6 col-sm-12 col-12">
						<ul class="list-dist pt-sm-4" id="about__fontsize-list">
							<li class="pb-md-3"><?=$LANG['about']['aboutListItem1']?></li>
							<li class="pb-md-3"><?=$LANG['about']['aboutListItem2']?></li>
							<li><?=$LANG['about']['aboutListItem3']?></li>
						</ul>
					</div>
					<div class="col-md-6 col-sm-12 col-12">
						<ul class="list-dist pt-sm-4">
							<li class="pb-md-3"><?=$LANG['about']['aboutListItem4']?></li>
							<li class="pb-md-3"><?=$LANG['about']['aboutListItem5']?></li>
							<li><?=$LANG['about']['aboutListItem6']?></li>
						</ul>
					</div>
				</div>

			</div>
		</div>




		<h2 class="title-direkt pt-md-5" style="padding-top: 4.5rem"><?=$LANG['about']['mission']?></h2>

		<div>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-12 pe-md-5 no__padding-image">
						<img src="/images/road.svg" id="road_img" class="img-fluid" style="height: 650px;width: 100%; object-fit: cover;">
					</div>
					<div class="col-md-6 col-sm-12 col-12 mission_block">
						<ul class="list-dist pt-sm-4 " id="about__fontsize-list">
						   <li class="pb-md-3"><?=$LANG['about']['missionItem1']?></li>
						   <li class="pb-md-3"><?=$LANG['about']['missionItem2']?></li>
						   <li class="pb-md-3"><?=$LANG['about']['missionItem3']?></li>
						   <li class="pb-md-3"><?=$LANG['about']['missionItem4']?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<h2 class="title-unternehmen pt-md-5 pb-md-2" style="padding-top: 4.5rem"><?=$LANG['about']['aTitle']?></h2>
		
	<div id="background_grey">
		<div class="container">
			<div class="row mt-md-2 px-md-5rem py-md-2">
				<div class="col-md-6 col-sm-12 col-12 pb-md-5">
					<div class="d-flex justify-content-start align-items-center">
						<div>
							<span class="aboutUpperNumber">1</span>
						</div>
						<div class="aboutPoint"><?=$LANG['about']['sItem1']?></div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-12 pb-md-5">
					<div class="d-flex justify-content-start align-items-center">
						<div>
							<span class="aboutUpperNumber">2</span>
						</div>
						<div class="aboutPoint"><?=$LANG['about']['sItem2']?></div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-12">
					<div class="d-flex justify-content-start align-items-center">
						<div>
							<span class="aboutUpperNumber">3</span>
						</div>
						<div class="aboutPoint"><?=$LANG['about']['sItem3']?></div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-12">
					<div class="d-flex justify-content-start align-items-center">
						<div>
							<span class="aboutUpperNumber">4</span>
						</div>
						<div class="aboutPoint"><?=$LANG['about']['sItem4']?></div>
					</div>
				</div>
			</div>
		</div>
	</div>


		<h2 class="title-direkt pt-md-5" style="padding-top: 4.5rem"><?=$LANG['about']['bTitle']?></h2>
		<div class="row pb-md-4">
			<div class="col-md-12 col-sm-12 col-12">
				<img src="<?php if($content[0]=='de'){echo '/images/1.png';} elseif ($content[0]=='en'){echo '/images/xv1.png';} ?>" class="img-fluid">
			</div>
		</div>


		<h2 class="title-direkt pt-md-5" style="padding-top: 4.5rem"><?=$LANG['about']['cTitle']?></h2>

		<div id="background_grey">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-12 pe-md-5">
						<img src="/images/20210524_praesentation_frowein_unternehmensvorstellung_deutsch_page-0007 1 1.svg" class="img-fluid" id="road_img" style="height: 650px;width: 100%; object-fit: cover;">
					</div>
					<div class="col-md-6 col-sm-12 col-12 list__kunden">
						<ul class="list-dist pt-sm-4 " id="about__fontsize-list">
						   <li class="pb-md-3"><?=$LANG['about']['psItem1']?></li>
						   <li class="pb-md-3"><?=$LANG['about']['psItem2']?></li>
						   <li class="pb-md-3"><?=$LANG['about']['psItem3']?></li>
						   <li class="pb-md-3"><?=$LANG['about']['psItem4']?></li>
						   <li class="pb-md-3"><?=$LANG['about']['psItem5']?></li>
						   <li><?=$LANG['about']['psItem6']?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>


	</div>
</div>
<?php } elseif(isset($content[1]) && $content[1] == "produktportfolio") { ?>
<div class="unternehmen pt-md-5">
	<div class="container pt-4">
		<h2 class="title-unternehmen">Produktportfolio</h2>
		<div class="row pt-md-3">
			<div class="col-md-6 col-sm-12 col-12">
				<img src="/images/about/about-img.png" class="img-fluid img__full-height">
			</div>
			<div class="col-md-6 col-sm-12 col-12 ps-md-5">
				<p class="about-full-descr">Vor über 80 Jahren wurden mit einer später patentierten Falle in einer einzigen Nacht achthundertacht Schaben gefangen. Wir kauften das Patent und ließen diese Zahl als internationales Markenzeichen schützen. Heute gilt "808" als Symbol für moderne Biozide zur Bekämpfung von Hygiene-, Material- und Vorratsschädlingen in Räumen. Professionelle Anwender finden bei uns sämtliche Produkte, die den hohen Anforderungen der Schädlingsbekämpfung in Räumen gerecht werden: Insektizide, Rodentizide, Monitoring-Systeme und zweckoptimierte Anwendungsgeräte. Ihre Entwicklung, ihre Fertigung und der Vertrieb ist durch unsere DIN EN ISO 9001:2015 Zertifizierung qualitätsüberwacht. Biozide von "808" sind Produkte mit hoher Wirksamkeit, zugleich aber zeit- und umweltkonform. Sie werden bevorzugt von professionellen Schädlingsbekämpfern in Nahrungs- und Genußmittelbetrieben, Lagerhäusern, Großküchen, Cateringbetrieben sowie in öffentlichen und privaten Räumen aller Art eingesetzt. Behörden bevorzugen den Einsatz von "808"-Bioziden in öffentlichen Einrichtungen und bei angeordneten Bekämpfungsmaßnahmen.</p>
				<ul class="list-about">
					<li>Gegründet 1934</li>
					<li>Über drei Generationen eigentümergeführt</li>
					<li>2019 Übernahme durch Steffen König, Management-Buy-Out</li>
					<li>Standort Albstadt, Baden-Württemberg</li>
					<li>Eigene Produktion und Entwicklung</li>
					<li>Zertifiziert nach DIN EN ISO 9001:2015</li>
				</ul>
			</div>
		</div>

		<h2 class="title-direkt pt-md-5">Direkt und indirekt</h2>
		<div class="row pb-md-4">
			<div class="col-md-12 col-sm-12 col-12">
				<img src="/images/about/full-map.svg" class="img-fluid">
			</div>
		</div>
	</div>
</div>
<?php } elseif(isset($content[1]) && $content[1] == "unser-team") { ?>
<div class="unternehmen pt-md-5">
	<div class="container pt-4">
		<h2 class="title-unternehmen">Unser Team</h2>
		<div class="row pt-md-3">
			<div class="col-md-6 col-sm-12 col-12">
				<img src="/images/about/about-img.png" class="img-fluid img__full-height">
			</div>
			<div class="col-md-6 col-sm-12 col-12 ps-md-5">
				<p class="about-full-descr">Vor über 80 Jahren wurden mit einer später patentierten Falle in einer einzigen Nacht achthundertacht Schaben gefangen. Wir kauften das Patent und ließen diese Zahl als internationales Markenzeichen schützen. Heute gilt "808" als Symbol für moderne Biozide zur Bekämpfung von Hygiene-, Material- und Vorratsschädlingen in Räumen. Professionelle Anwender finden bei uns sämtliche Produkte, die den hohen Anforderungen der Schädlingsbekämpfung in Räumen gerecht werden: Insektizide, Rodentizide, Monitoring-Systeme und zweckoptimierte Anwendungsgeräte. Ihre Entwicklung, ihre Fertigung und der Vertrieb ist durch unsere DIN EN ISO 9001:2015 Zertifizierung qualitätsüberwacht. Biozide von "808" sind Produkte mit hoher Wirksamkeit, zugleich aber zeit- und umweltkonform. Sie werden bevorzugt von professionellen Schädlingsbekämpfern in Nahrungs- und Genußmittelbetrieben, Lagerhäusern, Großküchen, Cateringbetrieben sowie in öffentlichen und privaten Räumen aller Art eingesetzt. Behörden bevorzugen den Einsatz von "808"-Bioziden in öffentlichen Einrichtungen und bei angeordneten Bekämpfungsmaßnahmen.</p>
				<ul class="list-about">
					<li>Gegründet 1934</li>
					<li>Über drei Generationen eigentümergeführt</li>
					<li>2019 Übernahme durch Steffen König, Management-Buy-Out</li>
					<li>Standort Albstadt, Baden-Württemberg</li>
					<li>Eigene Produktion und Entwicklung</li>
					<li>Zertifiziert nach DIN EN ISO 9001:2015</li>
				</ul>
			</div>
		</div>
		<h2 class="title-direkt pt-md-5">Direkt und indirekt</h2>
		<div class="row pb-md-4">
			<div class="col-md-12 col-sm-12 col-12">
				<img src="/images/about/full-map.svg" class="img-fluid">
			</div>
		</div>
	</div>
</div>
<?php } ?>