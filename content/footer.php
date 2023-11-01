<?php 


session_start();
$_SESSION["token_anmelden"] = bin2hex(random_bytes(32));
$_SESSION["token_abmelden"] = bin2hex(random_bytes(32));
$_SESSION["token-expire"] = time() + 3600;




if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}

if( ($content[0] == 'activate' && is_numeric($content[1])) ||($content[0] == 'abmeldung_confirm') || ($content[0] == 'anmeldung') ) {
	$langLink = 'de';
}

switch($langLink) {
	case 'de':
		$newsletterText = 'Damit Sie immer auf dem Laufenden sind und über aktuelle Themen informiert werden: Unser Newsletter erscheint hierzu in unregelmäßigen Abständen.';
		$captchaError = "Bitte verifizieren Sie sich über das Captcha.";
	break;
	case 'en':
		$newsletterText = 'For being always up to date and informed about current topics: Our newsletter is published at irregular intervals.';
		$captchaError = "Please verify yourself via the Captcha.";
	break;	

}
$langPrefixURL = $langLink;

?>
<div class="main-content">
	<div class="container">
		<div class="row">

			<?php if($messageNewsletterForm) { ?>
			<div class="col-md-12 col-sm-12 col-12 pb-5 errorNewsletter_section" id="errNewsletter">
				<?php echo $messageNewsletterForm;?>
			</div>
			<?php } ?>

			<?php if($htmlUnsubMessage) { ?>
			<div class="col-md-12 col-sm-12 col-12 pb-5 errorNewsletter_section" id="errNewsletter">
				<?php echo $htmlUnsubMessage;?>
			</div>
			<?php } ?>


			<div class="col-md-6 col-sm-12 col-12">
				<h2 class="newsletter-title">Newsletter</h2>
				<p class="newsletter-descr"><?php echo $newsletterText; ?></p>
			</div>
			<div class="col-md-6 col-sm-12 col-12 n-form">

				<div class="input-group"> <!-- change form tag to div -->
					<div class="input-group flex-nowrap mb-0">
						<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/svg/inputemail.svg"></span>
						<input type="email" class="form-control rounded-0 shadow-none border-start-0" name="newsletter-email" placeholder="<?php echo $LANG['footer']['emailPlaceholder']; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
						
						<input name="send-newsletter" data-bs-toggle="modal" data-bs-target="#newsletterSubscribeModal" class="btn btn-outline-secondary rounded-0 shadow-none" type="submit" value="<?php echo $LANG['footer']['newsletterButton']; ?>">
					</div>
					<span class="preTitleSub"><?php echo $LANG['footer']['newsletterLabel']; ?></span>
				</div>

			</div>
		</div>
	</div>
</div>
<footer class="footer mt-auto">
	<div class="basicFooter">
		<div class="container">
		   <div class="f-logo foo-item">
		      <div class="logo-text logo-pb">
		         <?php echo $LANG['footer']['trademark']; ?>
		      </div>
		      <div class="f-img" id="left_float-logo">
		         <div class="logo-img">
		            <img src="/images/svg/image-000 2.svg">
		         </div>
		      </div>

		   </div>
		   <div class="f-adress foo-item">
		   	  <h2 class="title-address"><?php echo $LANG['footer']['contact']; ?></h2>

		      <div class="logo-text">
		         FROWEIN<br> GmbH & Co. KG
		      </div>

		      <div class="ad">Am Reislebach 83</div>
		      <div class="ad">D-72461 Albstadt</div>
		      <div class="ad pt-ad"><a href="https://www.frowein808.de/<?php echo $langPrefixURL;?>" target="_blank">www.frowein808.de</a></div>
		   </div>
		   <div class="f-cont foo-item">
		   		<h2 class="title-cont"><?php echo $LANG['footer']['info']; ?></h2>
		   		<ul class="cont_list">
		   			<li><a href="/<?=$langPrefixURL;?>/agb/"><?php echo $LANG['footer']['agb']; ?></a></li>
                    <!--
		   			<li><a href="/" data-bs-toggle="modal" data-bs-target="#cookiesDataModal"><?php echo $LANG['footer']['cookies']; ?></a></li>
		   			-->
		   			<li><a  id="changePreferences" class="changePreferences"><?php echo $LANG['footer']['cookies']; ?></a></li>
		   			<li><a href="/<?=$langPrefixURL;?>/impressum/"><?php echo $LANG['footer']['imprint']; ?></a></li>
		   			<li><a href="/<?=$langPrefixURL;?>/datenschutz/"><?php echo $LANG['footer']['privacy_policy']; ?></a></li>
		   			<li><a href="/<?=$langPrefixURL;?>/contact/"><?php echo $LANG['footer']['contact']; ?></a></li>
		   		</ul>
		   </div>
		   <div class="f-adress foo-item">
		   		<h2 class="title-nav"><?php echo $LANG['footer']['navigation']; ?></h2>
		   		<ul class="cont_list">
		   			<li><a href="/<?=$langPrefixURL;?>/"><?php echo $LANG['footer']['startsite']; ?></a></li>
		   			<li><a href="/<?=$langPrefixURL;?>/about/"><?php echo $LANG['footer']['company']; ?></a></li>
		   			<li><a href="/<?=$langPrefixURL;?>/products/"><?php echo $LANG['footer']['products']; ?></a></li>
		   			<li><a href="/<?=$langPrefixURL;?>/news/"><?php echo $LANG['footer']['news']; ?></a></li>
		   			<li><a href="/<?=$langPrefixURL;?>/anmeldung/"><?php echo $LANG['footer']['newsletter']; ?></a></li>
		   		</ul>
		   </div>
		   <div class="f-follow foo-item">
		   		<h2 class="title-followus-f"><?php echo $LANG['footer']['followus']; ?></h2>
				<div class="social">
				   <a href="http://www.facebook.com/frowein808" class="facebook-link" target="_blank">

				   </a>
				   <a href="http://www.youtube.com/user/FroweinGmbH?feature=mhum" class="youtube-link" target="_blank">

				   </a>
				   <a href="http://www.linkedin.com/company/frowein-gmbh-&amp;-co-kg?trk=hb_tab_compy_id_2876431" class="linkedin-link" target="_blank">
				   </a>
				</div>
		   		<img src="/images/svg/cepa 1.svg" class="d-none cepa-mo">
		   </div>
		   <div class="cepa foo-item">
		      <div class="cepa-logo">
		         <img src="/images/svg/cepa 1.svg">
		      </div>
		   </div>
		</div>
	</div>
    <div class="bottomFooter">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-12 col-12 items_top">
                  <div class="container paddingZero">
                    <div class="row fullWidth">
                        <div class="col-md-3 col-sm-12 col-12 supportRight">
                          <a href="/<?=$langPrefixURL;?>/support/" class="support-link"><img src="/images/svg/support icon.svg"><?php echo $LANG['support']['title']; ?></a>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12 tel">
                          <a href="tel:+49 7432 956-0" class="tel-link"><img src="/images/svg/tel.svg">+49 7432 956-0</a>
                        </div>
                        <div class="col-md-5 col-sm-12 col-12 email">
                          <a href="mailto:info@frowein808.de" class="email-link"><img src="/images/svg/mail.svg">info@frowein808.de</a>
                        </div>
                    </div> 


                <div class="d-md-none col-sm-12 col-12">
                    <img class="w-100" src="/images/svg/moLinesFooter.svg">
                </div>

                  </div>
                </div> 
                <div class="col-md-5 col-sm-12 col-12 hideLines">
                    <img id="footer_right" src="/images/svg/lines.svg">
                </div> 
            </div>
        </div>
    </div>

<!-- Newsletter Sunscribe Data Modal -->
<div class="modal fade" id="newsletterSubscribeModal" tabindex="-1" aria-labelledby="newsletterSubscribeLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content px-5 py-4" id="unsubModal">
      <div class="modal-header pb-0" id="noBottomLine">
        <h2 class="newsletter-unsub mb-0"><?php echo $LANG['newsletter']['anmeldenTitle']; ?></h2>
        <button type="button" class="btn-close" id="nCloseButton" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<p class="newsletter_unsub_text mb-0"><?php echo $LANG['newsletter']['anmeldenDescr']; ?></p>
      	<form action="/processAnmeldenForm.php" method="POST" class="pAnmeldenForm input-group needs-validation w-50 pt-4 pb-0 mb-0 needs-validation" novalidate>

			<!-- CSRF Token -->
			<input type="hidden" name="token_anmelden" value="<?=$_SESSION["token_anmelden"]?>">
			<!-- CSRF Token END -->


      		<div class="row mb-4 w-100">
				  <div class="col-md-6 pe-md-0 ps-md-0">
						<select name="gender-newsletter" class="form-select" id="gender">
							<option value=""><?php echo $LANG['newsletter']['anrede']; ?></option>
							<option value="frau" <?php echo $frau_sel;?>><?php echo $LANG['newsletter']['anredeVal1']; ?></option>
							<option value="herr" <?php echo $herr_sel;?>><?php echo $LANG['newsletter']['anredeVal2']; ?></option>
						</select>
				  </div>
				  <div class="col-md-6">
				  </div>
	      	</div>
	      	<div class=" row mb-4 mt-2 w-100">
				  <div class="col-md-6 ps-md-0">
				  		<span class="nLabel">*<?php echo $LANG['newsletter']['vorname']; ?></span>
						<div class="input-group flex-nowrap mb-0">
							<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/svg/faceInput.svg"></span>
							<input type="text" class="form-control rounded-0 shadow-none border-start-0 pHeight" name="newsletter-vorname" value="<?php echo $_POST['newsletter-vorname'];?>" required>
						</div>
				  </div>
				  <div class="col-md-6 pe-md-0">
				  		<span class="nLabel">*<?php echo $LANG['newsletter']['name']; ?></span>
						<div class="input-group flex-nowrap mb-0">
							<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/svg/faceInput.svg"></span>
							<input type="text" class="form-control rounded-0 shadow-none border-start-0 pHeight" name="newsletter-name" value="<?php echo $_POST['newsletter-name'];?>" required>
						</div>
				  </div>
	      	</div>
	      	<div class=" row mb-4 mt-2 w-100">
				  <div class="col-12 px-0">
				  		<span class="nLabel">*<?php echo $LANG['newsletter']['email']; ?></span>
						<div class="input-group flex-nowrap mb-0">
							<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/svg/inputemail.svg"></span>
							<input type="email" class="form-control rounded-0 shadow-none border-start-0 pHeight" name="newsletter-pemail" value="<?php echo $_POST['newsletter-pemail'];?>" required>
						</div>
				  </div>
	      	</div>

	      	<!-- Secure Form  -->
            <input type="text" id="secNewsletter" name="secNewsletter"/>
            
            <label for="honeypotNewsletter" aria-hidden="true" class="visually-hidden">
            	Honeypot <input type="radio" name="honeypotNewsletter" id="honeypotNewsletter" style="display:none" value="1">
            </label>

			<div class="math-captcha mt-4 mb-3">
				<img class="capcap" src="/captcha/code_math.php">
				<img src="/captcha/update.png" class="cap_refresh">
				<input class="input_cap" type="text" name="kapcha" required>
				<div class="invalid-feedback"><?php echo $captchaError; ?></div>
			</div>
			<!-- Secure Form END -->

	      	<div class="anmeldenMessage"></div>
	      	<div class=" row mt-4 w-100">
	      		<input type="submit" name="sendNewsletter" value="<?php echo $LANG['newsletter']['button']; ?>">
	      	</div>
      	</form>
      </div>
    </div>
  </div>
</div>
<!-- Newsletter Unsubscribe Data Modal -->
<div class="modal fade" id="newsletterUnsubscribeModal" tabindex="-1" aria-labelledby="newsletterUnsubscribeLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content px-5 py-4" id="unsubModal">
      <div class="modal-header pb-0" id="noBottomLine">
        <h2 class="newsletter-unsub mb-0"><?php echo $LANG['newsletter']['abmeldemTitle']; ?></h2>
        <button type="button" class="btn-close" id="nCloseButton" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<p class="newsletter_unsub_text mb-0"><?php echo $LANG['newsletter']['abmeldenDescr	']; ?></p>
      	<div class="abmeldenMessage"></div>

		<form action="/processAbmeldenForm.php" method="POST" class="pAbmeldenForm input-group needs-validation w-50 pt-4 pb-3" novalidate>
			<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/svg/inputemail.svg"></span>

			<!-- CSRF Token -->
			<input type="hidden" name="token_abmelden" value="<?=$_SESSION["token_abmelden"]?>">
			<!-- CSRF Token END -->

	      	<!-- Secure Form  -->
            <input type="text" id="secUnsubscribe" name="secUnsubscribe"/>
            
            <label for="honeypotUnsubscribe" aria-hidden="true" class="visually-hidden">
            	Honeypot <input type="radio" name="honeypotUnsubscribe" id="honeypotUnsubscribe" style="display:none" value="1">
            </label>
			<!-- Secure Form END -->

			<input type="email" class="form-control rounded-0 shadow-none border-start-0" name="newsletter-ubsub-email" placeholder="<?php echo $LANG['footer']['emailPlaceholder']; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
			<input name="send-newsletter-unsub" class="btn btn-outline-secondary rounded-0 shadow-none" type="submit" value="<?php echo $LANG['newsletter']['abmeldenButton']; ?>">
		</form>

      </div>
    </div>
  </div>
</div>
<!-- Cookies Data Modal -->
<div class="modal fade" id="cookiesDataModal" tabindex="-1" aria-labelledby="cookiesDataLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-auto py-2" id="cookiesDataLabel">Cookie Instellungen</h5>
        <button type="button" class="btn-close" id="nCloseButton" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
      	<div class="container-fluid">
      		<div class="row">
      			<div class="col-md-3 col-sm-12 col-12 border-end px-0 bg-grey-color">
      				<div class="bg_left-side">
						<div class="list-group list-group-flush">
						  <a class="list-group-item list-group-item-action py-075 ps-4 active" data-value="cookie1">
						    Ihre Privatsphare
						  </a>
						  <a class="list-group-item list-group-item-action py-075 ps-4" data-value="cookie2">Unverzichtbare Cookies</a>
						  <a class="list-group-item list-group-item-action py-075 ps-4" data-value="cookie3">Marketing Und Re-Targeting.</a>
						  <a class="list-group-item list-group-item-action py-075 ps-4" data-value="cookie4">Datenanalyse Und Statistiken</a>
						</div>
      				</div>
      			</div>
      			<div class="col-md-9 col-sm-12 col-12">
      				<div class="bg_main-content py-075 px-5 mb-5" id="cookie1">
      					<h2 class="bg_cookie-title pb-3 pt-3">Ihre Privatsphäre ist uns wichtig</h2>
      					<p class="bg_cookie-content">Cookies sind sehr kleine Textdateien, die auf Ihrem Rechner gespeichert werden, wenn Sie eine Website besuchen. Wir verwenden Cookies für eine Reihe von Auswertungen, um damit Ihren Besuch auf unserer Website kontinuierlich zu verbessern zu können (z. B. damit Ihnen Ihre Login-Daten erhalten bleiben).</p>
      					<p class="bg_cookie-content">Sie können Ihre Einstellungen ändern und verschiedenen Arten von Cookies erlauben, auf Ihrem Rechner gespeichert zu werden, während Sie unsere Webseite besuchen. Sie können auf Ihrem Rechner gespeicherte Cookies ebenso weitgehend wieder entfernen. Bitte bedenken Sie aber, dass dadurch Teile unserer Website möglicherweise nicht mehr in der gedachten Art und Weise nutzbar sind.</p>
      					<p class="bg_cookie-content">Details zu den Cookies jeder Gruppe, deren Zweck und Dienste von Drittanbietern können Sie im Cookie-Richtlinie erfahren.</p>
      					<div class="text-end pb-3">
      						<button type="button" class="btn_cookie mt-5">Einstellungen speichern</button>
      					</div>
      				</div>
      				<div class="bg_main-content py-075 px-5 mb-5" id="cookie2">
      					<h2 class="bg_cookie-title pb-3 pt-3">Unverzichtbare Cookies</h2>
      					<p class="bg_cookie-content">Diese Cookies sind für das vollständige Funktionieren der Website <a href="#">www.frowein808.de</a> erforderlich und können nicht abgeschaltet werden. Sie enthalten die Einstellungen, die Sie für sich auf der Website <a href="#">www.frowein808.de</a> vorgenommen haben, also bspw. Sprache, Währung, Login-Sitzung (um zwischen Seitenwechseln eingeloggt zu bleiben), Privatsphäreneinstellungen.</p>
						<div class="form-check form-switch">
							<input class="form-check-input cookieSwitcher1" type="checkbox" role="switch" id="cookieSwitcher" checked>
							<label class="form-check-label ps-2" for="cookieSwitcher">Immer aktiv</label>
						</div>
      					<div class="text-end pb-3">
      						<button type="button" class="btn_cookie mt-5">Einstellungen speichern</button>
      					</div>
      				</div>
      				<div class="bg_main-content py-075 px-5 mb-5" id="cookie3">
      					<h2 class="bg_cookie-title pb-3 pt-3">Marketing Und Re-Targeting</h2>
      					<p class="bg_cookie-content">Mit diesen Cookies erfassen wir die Besuchsstatistiken der Website <a href="#">www.frowein808.de</a>, also bspw. welche Artikel wie oft angeklickt und anschließend gekauft wurden. Die Analyse dieser Daten hilft uns, das Warenangebot unserer Website <a href="#">www.frowein808.de</a> besser den Kundenwünschen anzupassen.</p>
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" role="switch" id="cookieSwitcher" checked>
							<label class="form-check-label ps-2" for="cookieSwitcher">Aktiv</label>
						</div>
      					<div class="text-end pb-3">
      						<button type="button" class="btn_cookie mt-5">Einstellungen speichern</button>
      					</div>
      				</div>
      				<div class="bg_main-content py-075 px-5 mb-5" id="cookie4">
      					<h2 class="bg_cookie-title pb-3 pt-3">Datenanalyse Und Statistiken</h2>
      					<p class="bg_cookie-content">Die Analyse dieser Daten hilft uns, das Warenangebot unserer Website <a href="#">www.frowein808.de</a> besser den Kundenwünschen anzupassen.</p>
						<div class="form-check form-switch">
							<input class="form-check-input cookieSwitcher3" type="checkbox" role="switch" id="cookieSwitcher" checked>
							<label class="form-check-label ps-2" for="cookieSwitcher">Aktiv</label>
						</div>
      					<div class="text-end pb-3">
      						<button type="button" class="btn_cookie mt-5">Einstellungen speichern</button>
      					</div>
      				</div>
      			</div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>

</footer>
<script type="text/javascript">
jQuery(document).ready(function($) {

    $(".cap_refresh").on("click", function(){
        d = new Date();
        $(".capcap").attr("src", "https://frowein808.de/captcha/code_math.php?"+d.getTime());
    });

	// ABMELDEN FORM (UNSUBSCRIBE)
	$(".pAbmeldenForm").submit(function(e) {
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
	        		$('.abmeldenMessage').html(data);
	        	}
	        }
	    });
	});

	// ANMELDEN FORM
	$(".pAnmeldenForm").submit(function(e) {
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
	        		$('.anmeldenMessage').html(data);
	        	}
	        }
	    });
	});

	$('input[name="newsletter-email"]').blur(function()
	{
	    if( $(this).val() ) {
	        $('input[name="newsletter-pemail"]').val( $('input[name="newsletter-email"]').val() );
	    } else {
	    	$('input[name="newsletter-pemail"]').val('');
	    }
	});

	var cookieContainer = $('#cookiesDataModal .modal-content .modal-body .container-fluid');
	var cookieListHeight = $('#cookiesDataModal .modal-content .modal-body .container-fluid .row .bg-grey-color');
	$('#cookiesDataModal').on('shown.bs.modal', function(){
		var modalDialogHeight = cookieContainer.height();
		cookieContainer.height(modalDialogHeight);
		cookieListHeight.height(modalDialogHeight);
	});

	$('.btn_cookie').click(function() {
	    $('#cookiesDataModal').modal('hide');
	});

	$('#cookie2, #cookie3, #cookie4').hide();
	$('.bg_left-side .list-group a').click(function(eventDefault) {
		var cookieValue = eventDefault.target.attributes[1].value;
		$("#" + cookieValue).show().siblings().hide();
	    $('.list-group a').removeClass("active");
	    $(this).addClass("active");
	});
});

jQuery(document).ready(function($) {
	(function() {
	  'use strict';
	  window.addEventListener('load', function() {
	    var forms = document.getElementsByClassName('needs-validation');
	    var validation = Array.prototype.filter.call(forms, function(form) {
	      form.addEventListener('submit', function(event) {
	        if (!form.checkValidity()) {
	          event.preventDefault();
	          event.stopPropagation();
	          $('.newsletter-form div.t').addClass('pos-icon_mail');
	        } 
	        
	        form.classList.add('was-validated');
	      }, false);
	    });
	  }, false);
	})();


});
</script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        cookieconsent.run({
            notice_banner_type:'interstitial',
            consent_type:'express',
            palette:'light',
            change_preferences_selector:'#changePreferences',
            language:'de',
            website_name:'www.frowein808.de',
            cookies_policy_url:'/datenschutz/'
        });
    });
</script>

<script type="text/javascript">
    var $ = jQuery;
    $(document).ready(function(){

        function getCookie(name){
            var dc = document.cookie;
            var prefix = name + "=";
            var begin = dc.indexOf("; ", +prefix);
            if(begin == -1) {
                begin = dc.indexOf(prefix);
                if(begin !=0) return null;
            } else {
                begin +=2;
                var end = document.cookie.indexOf(';', begin);
                if(end == -1){
                    end = dc.length;
                }
            }
            return decode.uri(dc.substring(begin + prefix.length, end));
        }
        function getCookieNew(name) {
            var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }
        var cook = getCookieNew("cookie_consent_level");
         var obj = jQuery.parseJSON( cook );
        console.log( obj);
        console.log("cook cookie_consent_level strictly-necessary= "+obj['strictly-necessary']);
        console.log("cook cookie_consent_level functionality = "+obj['functionality']);
        console.log("cook cookie_consent_level tracking= "+obj['tracking']);
        console.log("cook cookie_consent_level targeting= "+obj['targeting']);

        $("#strictly-necessary").prop("disabled" , true);
        $(document).delegate("#changePreferences", "click", function(){
            if(obj['functionality'] === true ){
                setTimeout(function(){
                    $("#functionality").prop("checked" , true);
                }, 300);
            }
            if(obj['targeting'] === true ){
                setTimeout(function(){
                    $("#targeting").prop("checked" , true);
                }, 300);
            }
            if(obj['tracking'] === true ){
                setTimeout(function(){
                    $("#tracking").prop("checked" , true);
                }, 300);
            }
        });
    });

    $(document).delegate("._brlbs-btn", 'click', function(){
        if($(this).parent().next().find('input[name=unblockAll]').prop('checked') === true){
            var date = new Date();
            date.setTime(date.getTime()+(60*24*60*60*1000));
            var expires = " expires="+date.toGMTString();
            document.cookie = "cookie_consent_level = %7B%22strictly-necessary%22%3Atrue%2C%22functionality%22%3Atrue%2C%22tracking%22%3Afalse%2C%22targeting%22%3Afalse%7D; path=/;" + expires;
            location.reload();
        } else {
            document.cookie = "cookie_consent_level = strictly-necessary=true&functionality=false&tracking=false&targeting=false; path=/;" + expires;
        }
    });

    $(document).delegate('#accept_all', 'click', function(){
        $("#functionality1").prop("checked", "checked");
        $("#tracking1").prop("checked", "checked");
        var date = new Date();
        var str = '';
        date.setTime(date.getTime()+(60*24*60*60*1000));
        var expires = " expires="+date.toGMTString();
        str = "cookie_consent_level = %7B%22strictly-necessary%22%3Atrue%2C%22functionality%22%3Atrue%2C%22tracking%22%3Atrue%2C%22targeting%22%3Atrue%7D; path=/;" + expires;
        document.cookie = "cookie_consent_level = %7B%22strictly-necessary%22%3Atrue%2C%22functionality%22%3Atrue%2C%22tracking%22%3Atrue%2C%22targeting%22%3Atrue%7D; path=/;" + expires;
        document.cookie = "cookie_consent_user_accepted = true; path=/;" + expires;

        $.ajax({
            type: 'POST',
            url: '/ajax.php',
            data: "cookie_stats=true&cookie_str="+str,
            success: function(result) {
                location.reload();
            },
            error:  function(xhr, str){

            }
        });

    });
    $(document).delegate(".cc_cp_f_save button", 'click', function(){
        if($('#functionality').prop('checked') === true){
            var date = new Date();
            date.setTime(date.getTime()+(60*24*60*60*1000));
            var expires = " expires="+date.toGMTString();
            document.cookie = "cookie_consent_level = %7B%22strictly-necessary%22%3Atrue%2C%22functionality%22%3Atrue%2C%22tracking%22%3Afalse%2C%22targeting%22%3Afalse%7D; path=/;" + expires;
            var str = "cookie_consent_level = %7B%22strictly-necessary%22%3Atrue%2C%22functionality%22%3Atrue%2C%22tracking%22%3Afalse%2C%22targeting%22%3Afalse%7D; path=/;" + expires;
            $.ajax({
                type: 'POST',
                url: '/ajax.php',
                data: "cookie_stats=true&cookie_str="+str,
                success: function(result) {
                    location.reload();
                },
                error:  function(xhr, str){

                }
            });
        }
    });




</script>
</body>
</html>