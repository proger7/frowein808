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
		$captchaError = "Bitte verifizieren Sie sich über das Captcha.";
	break;
	case "en":
		$captchaError = "Please verify yourself via the Captcha.";
	break;
}
?>
<?php if( ($content[0]=='de' || $content[0]=='en') && $content[1]=='support' && !isset($content[2]) ): ?>
<div class="support pt-5">
	<div class="container pt-4 pb-5">
		<h2 class="title__support pb-3"><?=$LANG['support']['title'];?></h2>
		<p class="text__support"><?=$LANG['support']['descr'];?></p>

		<div class="supportMessage"></div>

		<form enctype="multipart/form-data" class="pSupportForm row support__form pt-3 mt-5 needs-validation" id="sp-form" action="/processSupportForm.php"  method="POST" novalidate>

			<!-- CSRF Token -->
			<input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
			<!-- CSRF Token END -->

			<div class="col-md-6 col-sm-12 col-12 pe-md-5">
				<fieldset class="row mb-4">
					<legend class="col-form-label pt-0 supp__label">*<?=$LANG['support']['radioLabel'];?></legend>
					<div class="support__radio d-flex w-100 pt-2">
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="supportAddOptions" id="offer" value="option1" checked>
						  <label class="form-check-label" for="offer"><?=$LANG['support']['radioValue1'];?></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="supportAddOptions" id="advisory" value="option2">
						  <label class="form-check-label" for="advisory"><?=$LANG['support']['radioValue2'];?></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="supportAddOptions" id="recall" value="option3">
						  <label class="form-check-label" for="recall"><?=$LANG['support']['radioValue3'];?></label>
						</div>
					</div>
				</fieldset>
				<div class="mb-5 pt-3">
					<textarea class="form-control" name="supp_message" id="support-textarea" rows="13" placeholder="<?=$LANG['support']['textareaPlaceholder'];?>"></textarea>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 col-12 ps-md-5">
				<div class="support-f_column">
					<div class="ts pt-0 mb-4">

				  		<span class="nLabel"><?=$LANG['support']['inputNameLabel'];?>*</span>
						<div class="input-group flex-nowrap mb-0">
							<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/svg/faceInput.svg"></span>
							<input type="text" class="form-control rounded-0 shadow-none border-start-0 mt-0" name="suppname" required>
						</div>
						<div class="invalid-feedback">Bitte geben Sie einen Namen ein.</div>

					</div>
					<div class="ts pt-0 mb-4">

				  		<span class="nLabel"><?=$LANG['support']['inputCompanyLabel'];?>*</span>
						<div class="input-group flex-nowrap mb-0">
							<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/icons-new/Unternehmen.svg"></span>
							<input type="text" class="form-control rounded-0 shadow-none border-start-0 mt-0" name="suppbusiness" required>
						</div>
						<div class="invalid-feedback">Bitte geben Sie ein Unternehmen an.</div>
						<label class="supp_label pt-2"><?=$LANG['support']['inputBottomCompany'];?></label>


					</div>
					<div class="ts pt-0 mb-4">

				  		<span class="nLabel"><?=$LANG['support']['inputEmailLabel'];?>*</span>
						<div class="input-group flex-nowrap mb-0">
							<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/icons-new/e-mail.svg"></span>
							<input type="email" class="form-control rounded-0 shadow-none border-start-0 mt-0" name="suppemail" required>
						</div>
						<div class="invalid-feedback">Bitte geben Sie eine gültige Email-Adresse ein.</div>

					</div>
					<div class="ts pt-0 mb-5">

				  		<span class="nLabel"><?=$LANG['support']['inputPhoneLabel'];?>*</span>
						<div class="input-group flex-nowrap mb-0">
							<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/icons-new/telefon.svg"></span>
							<input type="tel" class="form-control rounded-0 shadow-none border-start-0 mt-0" name="supptel" required>
						</div>
						<div class="invalid-feedback">Bitte geben Sie eine Telefonnummer ein.</div>

					</div>
					<fieldset class="row pt-0 mb-4">
						<legend class="col-form-label pt-0 supp__label"><?=$LANG['support']['radioLabelContact'];?></legend>
						<div class="support__radio d-flex w-100 pt-2">
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="suppVariants" id="suppTelephone" value="opt1">
							  <label class="form-check-label" for="suppTelephone"><?=$LANG['support']['radioLabelContactVal1'];?></label>
							</div>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="suppVariants" id="suppEmail" value="opt2">
							  <label class="form-check-label" for="suppEmail"><?=$LANG['support']['radioLabelContactVal2'];?></label>
							</div>
						</div>
					</fieldset>


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



					<div class="ts-checkbox pt-4">
						<div class="form-check">
							<div>
									<input type="checkbox" class="form-check-input" id="agreesupp" value="yes" name="suppAgreement" required>
									<label for="agreesupp" class="form-check-label"></label>
			
									<label class="checkbox__label1 form-check-label"><?=$LANG['support']['agreeLabel'];?></label>
									<div class="invalid-feedback form-check">
									<?=$LANG['support']['captchaError'];?>
									</div>
					
							</div>
						</div>
					</div>
					<div class="ts text-end pt-4">
						<input type="submit" name="suppSend" value="<?=$LANG['support']['buttontext'];?>">
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
        
	    $(".cap_refresh").on("click", function(){
            d = new Date();
            $(".capcap").attr("src", "https://frowein808.de/captcha/code_math.php?"+d.getTime());
        });

		// SUPPORT FORM
		$(".pSupportForm").submit(function(e) {
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
		        		$('.supportMessage').html(data);
		        	}
		        }
		    });
		});

	});
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

<?php endif; ?>