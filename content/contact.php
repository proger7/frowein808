
<?php


session_start();
$_SESSION["token"] = bin2hex(random_bytes(32));
$_SESSION["token-expire"] = time() + 3600;


if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}



switch ($langLink) {
	case "de":
		$vorname = "Vorname";
		$nachname = "Nachname";
		$company = "Unternehmen";
		$formMessage = "Nachricht";

		$captchaError = "Bitte verifizieren Sie sich über das Captcha.";


		$norway = 'NORWEGEN';
		$sweden = 'SCHWEDEN';
		$italy = 'ITALIEN';
		$holland = 'NIEDERLANDE';
		$belgium = 'BELGIEN';
		$poland = 'POLEN';
		$france = 'FRANKREICH';
		$czech = 'TSCHECHIEN';
		$switzerland = 'SCHWEIZ';
		$austria = 'ÖSTERREICH';
		$slovenia = 'SLOWENIEN';
		$slovakia = 'SLOWAKISCHE REPUBLIK';
		$hungary = 'UNGARN';
		$bulgaria = 'BULGARIEN';
		$romania = 'RUMÄNIEN';


		$inputPlaceholder = "Bitte PLZ eingeben";
		$germany = "Deutschland";
		$europe = "Europa";
		$title1 = "Ihre Ansprchpartner im innendienst";
		$title2 = "Kontaktformular";
		$button1 = "Suchen";
		$button2 = "Senden";
	break;
	case "en":
		$vorname = "First Name";
		$nachname = "Surname";
		$company = "Company";
		$formMessage = "Message";

		$captchaError = "Please verify yourself via the Captcha.";


		$norway = 'NORWAY';
		$sweden = 'SWEDEN';
		$italy = 'ITALY';
		$holland = 'NETHERLANDS';
		$belgium = 'BELGIUM';
		$poland = 'POLAND';
		$france = 'FRANCE';
		$czech = 'CZECH REPUBLIC';
		$switzerland = 'SWITZERLAND';
		$austria = 'AUSTRIA';
		$slovenia = 'SLOVENIA';
		$slovakia = 'SLOVAK REPUBLIC';
		$hungary = 'HUNGARY';
		$bulgaria = 'BULGARIA';
		$romania = 'ROMANIA';


		$inputPlaceholder = "Please enter zip code";
		$germany = "Germany";
		$europe = "Europe";
		$title1 = "Your contacts in the office";
		$title2 = "Contact us";
		$button1 = "Search";
		$button2 = "Send";
	break;
}
?>


<div class="contact-map" id="ansprechpartner">
	<div class="container">
		<h2 class="title__contact-left container ps-0 changeWord"><?php echo $title1; ?></h2>
		<div class="row pt-md-4">
			<div class="col-md-6 col-sm-12 col-12 pe-md-0">

					<div class="row europe__item-col">
			
							<div class="col-md-6 col-sm-12 col-12 contentMap mapMobile d-inline-block">
								<div class="partner_address"></div>
								<div class="international_adress">
									<p class="c__label-2 flag-de"><?php echo $germany; ?></p>
									<table class="table table-borderless kontakt__item-col">
										<tr>
											<td width="6%" class="px-0">	
												<p class="text-left mb-0"><img src="/images/svg/contact/kicon1.svg" class="img-fluid"></p>
											</td>
											<td>
												<p class="k-address mb-0">Frowein GmbH & Co. KG<br>Am Reislebach 83<br>D-72461 Albstadt</p>
											</td>
										</tr>
										<tr>
											<td class="px-0">
												<p class="text-left mb-0"><img src="/images/svg/contact/kicon2.svg" class="img-fluid"></p>
											</td>
											<td>
												<a class="k-telephone" href="tel:+49 7432 956-0">+49 7432 956-0</a>
											</td>
										</tr>

										<tr>
											<td class="px-0">
												<p class="text-left mb-0"><img src="/images/svg/contact/kicon4.svg" class="img-fluid"></p>
											</td>
											<td>
												<a class="k-email" href="mailto:vertrieb@frowein808.de">vertrieb@frowein808.de</a>
											</td>
										</tr>
										<tr>
											<td class="px-0" id="siteIcon">
												<p class="text-left mb-0"><img src="/images/svg/contact/kicon5.svg" class="img-fluid"></p>
											</td>
											<td>
												<a class="k-siteurl" target="_blank" href="https://www.frowein808.de">www.frowein808.de</a>
											</td>
										</tr>
									</table>

								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-12 pe-md-0 pt-0 mapForm mapMobile d-inline-block">
								<select class="form-select" id="choose">
									<option value="map-DE" selected><?php echo $germany; ?></option>
									<option value="map-EU"><?php echo $europe; ?></option>
									<option value="map-WORLD">International</option>
								</select>
								<form action="/processContact.php" method="post" name="psuche" class="psucheForm">
									<input type="text" name="PKEY" id="PKEY" placeholder="<?php echo $inputPlaceholder; ?>" class="mt-3 pkeyParam w-100" value="<?php echo $PKEY;?>">
									<input type="submit" class="mt-3 pKeySendBtn w-50" value="<?php echo $button1; ?>">
								</form>
							</div>
					
					</div>
			</div>
			<div class="col-md-6 col-sm-12 col-12 ps-md-0 pe-md-0 position-relative">
				<div id="map-DE" class="ps-md-4">
					<div id="vmap" class="position-relative" style="width: 600px; height: 400px;">
						<div class="position-absolute top-80 start-38 width-25">
							<img src="/images/svg/header_logo.svg">
						</div>
					</div>
				</div>
				<div id="map-EU" class="ps-md-4">
					<div id="euvmap" style="width: 600px; height: 400px;"></div>
				</div>
				<div id="map-WORLD" class="ps-md-4">
					<div id="worldvmap" style="width: 600px; height: 400px;"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="contact-about pt-md-5">
	<div class="container pt-md-4 pb-md-5 contTopSpace">


				<h2 class="title__contact-right container ps-0"><?php echo $title2; ?></h2>

				<div class="contactMessage"></div>

				<form action="/processContactForm.php" method="POST" class="pContactForm row kontakt-form needs-validation" novalidate>

					<!-- CSRF Token -->
					<input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
					<!-- CSRF Token END -->


					<div class="col-md-6 col-sm-12 col-12 pe-md-5">
						<div class="ts">
					  		<span class="nLabel"><?php echo $vorname; ?>*</span>
							<div class="input-group flex-nowrap mb-0">
								<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/svg/faceInput.svg"></span>
								<input type="text" class="form-control rounded-0 shadow-none border-start-0 mt-0" name="vorname" required>
							</div>
							<div class="invalid-feedback">Bitte geben Sie einen vornamen ein.</div>
						</div>
						<div class="ts">

					  		<span class="nLabel"><?php echo $nachname; ?>*</span>
							<div class="input-group flex-nowrap mb-0">
								<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/svg/faceInput.svg"></span>
								<input type="text" class="form-control rounded-0 shadow-none border-start-0 mt-0" name="nachname" required>
							</div>
							<div class="invalid-feedback">Bitte geben Sie einen nachnamen ein.</div>

						</div>
						<div class="ts">
					  		<span class="nLabel"><?php echo $company; ?></span>
							<div class="input-group flex-nowrap mb-0">
								<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/icons-new/Unternehmen.svg"></span>
								<input type="text" class="form-control rounded-0 shadow-none border-start-0 mt-0" name="unternehmen">
							</div>
						</div>


                        <!-- <div class="frc-captcha mt-4" data-sitekey="FCMOLAB9T9TNJL82"></div> -->


                        <input type="text" id="sec" name="sec"/>
                        
                        <label for="honeypot" aria-hidden="true" class="visually-hidden">
                        	Honeypot <input type="radio" name="honeypot" id="honeypot" style="display:none" value="1">
                        </label>


						<div class="math-captcha mt-4">
							<img class="capcap" src="/captcha/code_math.php">
							<img src="/captcha/update.png" class="cap_refresh">
							<input class="input_cap" type="text" name="kapcha" required>
							<div class="invalid-feedback"><?php echo $captchaError; ?></div>
						</div>

						<div class="ts pt-4">
							<input type="submit" name="sendkontakt" value="<?php echo $button2; ?>">
						</div>

					</div>
					<div class="col-md-6 col-sm-12 col-12 pe-md-5">

						<div class="ts">

					  		<span class="nLabel">E-Mail*</span>
							<div class="input-group flex-nowrap mb-0">
								<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/icons-new/e-mail.svg"></span>
								<input type="email" class="form-control rounded-0 shadow-none border-start-0 mt-0" name="email-p" required>
							</div>
							<div class="invalid-feedback">Bitte geben Sie eine E-Mail-Adresse ein.</div>

						</div>

						<div class="ts">

							<span class="nLabel"><?php echo $formMessage; ?></span>
							<div class="input-group flex-nowrap mb-0" style="position: relative;">
								<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon" style="position: absolute;z-index: 999999;bottom: 10px;right: 8px;border: none"><img src="/images/icons-new/Nachricht.svg"></span>
								<textarea name='nachricht' class="form-control rounded-0 shadow-none mt-0"></textarea>
							</div>

						</div>

					</div>
				</form>


	</div>
</div>


<script type="text/javascript">
jQuery(document).ready(function($) {
	$(document).ready(function(){

		$('.cap_refresh').click();

  		// if($(window).width() >= 768 && $(window).width() < 992) {
  		// 	$('#choose').mobileSelect();
  		// }

		// CONTACT FORM
		$(".pContactForm").submit(function(e) {
		    e.preventDefault();

		    var form = $(this);
		    var actionUrl = form.attr('action');
		    
		    $.ajax({
		        type: "POST",
		        url: actionUrl,
		        data: form.serialize(),
		        success: function(data)
		        {
		        	if(data) {
		        		$('.contactMessage').html(data);
		        	}
		        }
		    });
		});


	    $(".cap_refresh").on("click", function(){
            d = new Date();
            $(".capcap").attr("src", "https://frowein808.de/captcha/code_math.php?"+d.getTime());
        });

		$(".psucheForm").submit(function(e) {
		    e.preventDefault();

		    var form = $(this);
		    var actionUrl = form.attr('action');
		    
		    $.ajax({
		        type: "POST",
		        url: actionUrl,
		        data: form.serialize(),
		        success: function(data)
		        {
		        	if(data) {
			        	$('.partner_address').html(data);
		        	}
		        }
		    });


		    $('#choose').change(function(event) {
		    	if( this.value == 'map-EU' || this.value == 'map-WORLD' ) {
		    		$('.partner_address').hide();
		    		$('.international_adress').show();		
		    	} else {
		    		$('.partner_address').show();
		    		$('.international_adress').hide();
		    	}
		    });

		});

	});
});


jQuery('#vmap').vectorMap({
    map: 'germany_en',
    backgroundColor: null,
    color: '#fff',
    hoverColor: '#e2001a',
    selectedColor: '#e2001a',
    borderColor: '#000',
    enableZoom: false,
    showTooltip: true,
    normalizeFunction: 'polynomial'
});
jQuery('#euvmap').vectorMap({
    map: 'europe_en',
    backgroundColor: null,
    color: '#fff',
    hoverColor: '#e2001a',
    enableZoom: false,
    showTooltip: true,
    selectedColor: '#e2001a',
    selectedRegions: ['DE','NO','SE','PL','RO','BG','SK','HU','CZ','AT','SI','CH','IT','FR','NL','BE'],
    borderColor: '#000',
    onRegionClick: function(event, code, region)
    {
    	jQuery('#siteIcon').show();
        if (code == 'de') {
        	jQuery('.partner_address .uppTitle').hide();
        	var germanyCountry = "<?php echo $germany; ?>";
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html(germanyCountry);
        	jQuery('.contentMap .k-address').html('Frowein GmbH & Co. KG<br>Am Reislebach 83<br>D-72461 Albstadt');
        	jQuery('.contentMap .k-telephone').html('+49 7432 956-0').attr('href', 'tel:+49 7432 956-0');
        	jQuery('.contentMap .k-fax').html('+49 7432 956-138').attr('href', 'fax:+49 7432 956-138');
        	jQuery('.contentMap .k-email').html('vertrieb@frowein808.de').attr('href', 'mailto:vertrieb@frowein808.de');
        	jQuery('.contentMap .k-siteurl').html('www.frowein808.de').attr('href', 'https://www.frowein808.de/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-de');
        } else if (code == 'no') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$norway;?>");
        	jQuery('.contentMap .k-address').html('Frowein GmbH & Co. KG<br>Am Reislebach 83<br>D-72461 Albstadt');
        	jQuery('.contentMap .k-telephone').html('+49 7432 956-0').attr('href', 'tel:+49 7432 956-0');
        	jQuery('.contentMap .k-fax').html('+49 7432 956-138').attr('href', 'fax:+49 7432 956-138');
        	jQuery('.contentMap .k-email').html('vertrieb@frowein808.de').attr('href', 'mailto:vertrieb@frowein808.de');
        	jQuery('.contentMap .k-siteurl').html('www.frowein808.de').attr('href', 'https://www.frowein808.de/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-norwegen');
        } else if(code == 'se') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$sweden;?>");
        	jQuery('.contentMap .k-address').html('Frowein GmbH & Co. KG<br>Am Reislebach 83<br>D-72461 Albstadt');
        	jQuery('.contentMap .k-telephone').html('+49 7432 956-0').attr('href', 'tel:+49 7432 956-0');
        	jQuery('.contentMap .k-fax').html('+49 7432 956-138').attr('href', 'fax:+49 7432 956-138');
        	jQuery('.contentMap .k-email').html('vertrieb@frowein808.de').attr('href', 'mailto:vertrieb@frowein808.de');
        	jQuery('.contentMap .k-siteurl').html('www.frowein808.de').attr('href', 'https://www.frowein808.de/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-sweden');	
        } else if(code == 'it') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$italy;?>");
        	jQuery('.contentMap .k-address').html('Merkur Chemical S.r.l.<br>Albrecht-Dürer-Str. 18/Bd<br>39100 BOZEN');
        	jQuery('.contentMap .k-telephone').html('+390 471 934212').attr('href', 'tel:+390 471 934212');
        	jQuery('.contentMap .k-fax').html('+390 471 204127').attr('href', 'fax:+390 471 204127');
        	jQuery('.contentMap .k-email').html('info@mcbz.it').attr('href', 'mailto:info@mcbz.it');
        	jQuery('.contentMap .k-siteurl').html('www.mcbz.it').attr('href', 'http://www.mcbz.it/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-italy');
        } else if(code == 'nl') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$holland;?>");
        	jQuery('.contentMap .k-address').html('Killgerm Benelux NV<br>Koeybleuken 12<br>2300 TURNHOUT');
        	jQuery('.contentMap .k-telephone').html('+32 14 442276').attr('href', 'tel:+32 14 442276');
        	jQuery('.contentMap .k-fax').html('+32 14 479348').attr('href', 'fax:+32 14 479348');
        	jQuery('.contentMap .k-email').html('marc.vanzanten@killgerm.com').attr('href', 'mailto:marc.vanzanten@killgerm.com');
        	jQuery('.contentMap .k-siteurl').html('www.killgerm.com/be').attr('href', 'https://www.killgerm.com/be-prepared-with-the-code-of-best-practice-humane-use-of-rodent-glue-boards-course/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-netherland');
        } else if(code == 'be') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$belgium;?>");
        	jQuery('.contentMap .k-address').html('Killgerm Benelux NV<br>Koeybleuken 12<br>2300 TURNHOUT');
        	jQuery('.contentMap .k-telephone').html('+32 14 442276').attr('href', 'tel:+32 14 442276');
        	jQuery('.contentMap .k-fax').html('+32 14 479348').attr('href', 'fax:+32 14 479348');
        	jQuery('.contentMap .k-email').html('marc.vanzanten@killgerm.com').attr('href', 'mailto:marc.vanzanten@killgerm.com');
        	jQuery('.contentMap .k-siteurl').html('www.mcbz.it').attr('href', 'http://www.mcbz.it/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-belgium');
        } else if(code == 'pl') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$poland;?>");
        	jQuery('.contentMap .k-address').html('AGRO-TRADE Sp.z o.o.<br>Gowarzewo, ul. Akacjowa 3<br>63-004 TULCE');
        	jQuery('.contentMap .k-telephone').html('+48 61 8208595').attr('href', 'tel:+48 61 8208595');
        	jQuery('.contentMap .k-fax').html('+48 61 8208670').attr('href', 'fax:+48 61 8208670');
        	jQuery('.contentMap .k-email').html('info@agro-trade.com.pl').attr('href', 'mailto:info@agro-trade.com.pl');
        	jQuery('.contentMap .k-siteurl').html('www.agro-trade.com.pl').attr('href', 'https://www.agro-trade.pl/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-poland');
        } else if(code == 'fr') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$france;?>");
        	jQuery('.contentMap .k-address').html('Frowein GmbH & Co. KG<br>Am Reislebach 83<br>D-72461 Albstadt');
        	jQuery('.contentMap .k-telephone').html('+49 7432 956-0').attr('href', 'tel:+49 7432 956-0');
        	jQuery('.contentMap .k-fax').html('+49 7432 956-138').attr('href', 'fax:+49 7432 956-138');
        	jQuery('.contentMap .k-email').html('vertrieb@frowein808.de').attr('href', 'mailto:vertrieb@frowein808.de');
        	jQuery('.contentMap .k-siteurl').html('www.frowein808.de').attr('href', 'https://www.frowein808.de//');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-france');
        } else if(code == 'cz') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$czech;?>");
        	jQuery('.contentMap .k-address').html('de Wolf Group s.r.o.<br>Americká 2452/14<br>35002 CHEB');
        	jQuery('.contentMap .k-telephone').html('+420 354 435130').attr('href', 'tel:+420 354 435130');
        	jQuery('.contentMap .k-fax').html('+420 354 437190').attr('href', 'fax:+420 354 437190');
        	jQuery('.contentMap .k-email').html('dewolf@dewolf.cz').attr('href', 'mailto:dewolf@dewolf.cz');
        	jQuery('.contentMap .k-siteurl').html('www.dewolf.cz').attr('href', 'http://www.dewolf.cz/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-czech');
        } else if(code == 'ch') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$switzerland;?>");
        	jQuery('.contentMap .k-address').html('808 Schweiz AG<br>Bruggacherstraße 18<br>8117 Fällanden');
        	jQuery('.contentMap .k-telephone').html('+41 44 2102005').attr('href', 'tel:+41 44 2102005');
        	jQuery('.contentMap .k-fax').html('+41 76 2102005').attr('href', 'fax:+41 76 2102005');
        	jQuery('.contentMap .k-email').html('808schweiz@808schweiz.ch').attr('href', 'mailto:808schweiz@808schweiz.ch');
        	jQuery('.contentMap .k-siteurl').html('www.808schweiz.ch').attr('href', 'https://www.808schweiz.ch/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-switzerland');
        } else if(code == 'at') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$austria;?>");
        	jQuery('.contentMap .k-address').html('Peter Mühlberger GesmbH<br>Herrmanngasse 2 - 4<br>3100 ST. PÖLTEN');
        	jQuery('.contentMap .k-telephone').html('+43 2742 735030').attr('href', 'tel:+43 2742 735030');
        	jQuery('.contentMap .k-fax').html('+43 2742 735035').attr('href', 'fax:+43 2742 735035');
        	jQuery('.contentMap .k-email').html('office@muehlberger.co.at').attr('href', 'mailto:office@muehlberger.co.at');
        	jQuery('.contentMap .k-siteurl').html('www.muehlberger.co.at').attr('href', 'http://www.muehlberger.co.at/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-austria');
        } else if(code == 'si') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$slovenia;?>");
        	jQuery('.contentMap .k-address').html('MAGNETIK d.o.o.<br>Ulica heroja Verdnika 38A<br>4270 JESENICE');
        	jQuery('.contentMap .k-telephone').html('+386 4 5835500').attr('href', 'tel:+386 4 5835500');
        	jQuery('.contentMap .k-fax').html('+386 4 5835501').attr('href', 'fax:+386 4 5835501');
        	jQuery('.contentMap .k-email').html('magnetik@siol.net').attr('href', 'mailto:magnetik@siol.net');
        	jQuery('.contentMap .k-siteurl').html('www.magnetik.si').attr('href', 'http://www.magnetik.si/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-slovenia');
        } else if(code == 'sk') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$slovakia;?>");
        	jQuery('.contentMap .k-address').html('de Wolf Group s.r.o.<br>Americká 2452/14<br>35002 CHEB');
        	jQuery('.contentMap .k-telephone').html('+420 354 435130').attr('href', 'tel:+420 354 435130');
        	jQuery('.contentMap .k-fax').html('+420 354 437190').attr('href', 'fax:+420 354 437190');
        	jQuery('.contentMap .k-email').html('dewolf@dewolf.cz').attr('href', 'mailto:dewolf@dewolf.cz');
        	jQuery('.contentMap .k-siteurl').html('www.dewolf.cz').attr('href', 'http://www.dewolf.cz/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-slovakia');
        } else if(code == 'hu') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$hungary;?>");
        	jQuery('.contentMap .k-address').html('Biolon Kft<br>Erdész u. 12.<br>8200 VESZPRÉM');
        	jQuery('.contentMap .k-telephone').html('+36 88 329053').attr('href', 'tel:+36 88 329053');
        	jQuery('.contentMap .k-fax').html('+36 88 329053').attr('href', 'fax:+36 88 329053');
        	jQuery('.contentMap .k-email').html('biolonsoterapia@gmail.com').attr('href', 'mailto:biolonsoterapia@gmail.com');
        	jQuery('.contentMap .k-siteurl').html(' ');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-hungary');
        	jQuery('#siteIcon').hide();
        } else if(code == 'bg') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$bulgaria;?>");
        	jQuery('.contentMap .k-address').html('Frowein GmbH & Co. KG<br>Am Reislebach 83<br>D-72461 Albstadt');
        	jQuery('.contentMap .k-telephone').html('+49 7432 956-0').attr('href', 'tel:+49 7432 956-0');
        	jQuery('.contentMap .k-fax').html('+49 7432 956-138').attr('href', 'fax:+49 7432 956-138');
        	jQuery('.contentMap .k-email').html('vertrieb@frowein808.de').attr('href', 'mailto:vertrieb@frowein808.de');
        	jQuery('.contentMap .k-siteurl').html('www.frowein808.de').attr('href', 'https://www.frowein808.de/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-bulgaria');
        } else if(code == 'ro') {
        	jQuery('.partner_address .uppTitle').hide();
        	jQuery('.contentMap').removeClass('invisible').addClass('visible');
        	jQuery('.contentMap .c__label-2').html("<?=$romania;?>");
        	jQuery('.contentMap .k-address').html('Frowein GmbH & Co. KG<br>Am Reislebach 83<br>D-72461 Albstadt');
        	jQuery('.contentMap .k-telephone').html('+49 7432 956-0').attr('href', 'tel:+49 7432 956-0');
        	jQuery('.contentMap .k-fax').html('+49 7432 956-138').attr('href', 'fax:+49 7432 956-138');
        	jQuery('.contentMap .k-email').html('vertrieb@frowein808.de').attr('href', 'mailto:vertrieb@frowein808.de');
        	jQuery('.contentMap .k-siteurl').html('www.frowein808.de').attr('href', 'https://www.frowein808.de/');
        	jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-romania');
        } else {
        	jQuery('.contentMap').addClass('invisible');

        }
    },
});
jQuery('#worldvmap').vectorMap({
    map: 'world_en',
    backgroundColor: null,
    color: '#fff',
    selectedColor: '#666666',
    enableZoom: false,
    showTooltip: true,
    normalizeFunction: 'polynomial',
    hoverColor: '#e2001a',

});

(function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>