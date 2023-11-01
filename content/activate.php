<?php



if(!isset($_SESSION["_registry"]["lang"])){
		$_SESSION["_registry"]["lang"] = parse_ini_file($DIR_ROOT."/localisation/de.ini", TRUE);
        $LANG = $_SESSION["_registry"]["lang"];
		$LANG["language"]["shortname"] = "de";
		$_SESSION['language'] = $lang;
		 header("location: ".$_SESSION["_registry"]["HTTP_REFERER"]);
	}
	
	$user_id = end($content);
	$user = $DB->query_fetch("SELECT * FROM newsletter_users_temp WHERE id=".$user_id." AND activated=0");
 
	if(!empty($user)){
		$id = $DB->lastindex_query("INSERT INTO `newsletter_users` ( `update`,  `language_id`, `status`, `order_id`, `user_email`, `user_anrede`, `user_titel`,   `user_nachname`, `user_name` , `user_createdate`, `user_mail_format`,   `user_group` ) VALUES
( 	now(),	 ".$user['language_id'].",	1,	1,	'".$user['user_email']."',	'".$user['user_anrede']."',  '".$user['user_titel']."', 	'".$user['user_nachname']."',	'".$user['user_name']."', 	now(),	0,	 55 );");
		
		$DB->query("INSERT INTO `newsletter_user_group` (`change_date`, `change_admin`, `language_id`, `status`, `user_id`, `group_id`) VALUES (now(),	0,	".$user['language_id'].",	1,	".$id.",	".$user['user_group'].");");
		
		$DB->query("UPDATE newsletter_users_temp SET activated=1 WHERE id=".$user_id);
	 	$mes = 'Anrede: '.$user['user_anrede'].'<br />Titel: '.$user['user_titel'].'<br />Nachname: '.$user['user_nachname'].'<br />Name:'.$user['user_name'].'<br />E-Mail: '.$user['user_email'];
		
		$mailfrom = "info@frowein808.de";
		$headers = "From: ".$mailfrom."\nReply-To: ".$mailfrom."\n";
		$headers .= 'Content-Type: text/html;charset=\"utf-8\"';
		
		mail('info@frowein808.de','Neue Registrierung zum Newsletter',$mes,$headers);
	  
		if($user['language_id'] == 1){
			$txt = '<h2>Vielen Dank für Ihre Anmeldung. Sie erhalten nun unseren Newsletter.</h2>';


			$message = '
		<html>
		  <head>
		    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		    <title>Abmelden</title>
		    <style>
		        /* -------------------------------------
		        GLOBAL RESETS
		        ------------------------------------- */

		        /*All the styling goes here*/

		        img {
		        border: none;
		        -ms-interpolation-mode: bicubic;
		        max-width: 100%; 
		        }

		        body {
		        background-color: #f6f6f6;
		        font-family: Calibri, sans-serif;
		        -webkit-font-smoothing: antialiased;
		        font-size: 14px;
		        line-height: 1.4;
		        margin: 0;
		        padding: 0;
		        -ms-text-size-adjust: 100%;
		        -webkit-text-size-adjust: 100%; 
		        }

		        table {
		        border-collapse: separate;
		        mso-table-lspace: 0pt;
		        mso-table-rspace: 0pt;
		        width: 100%; }
		        table td {
		        font-family: Calibri, sans-serif;
		        font-size: 14px;
		        vertical-align: top; 
		        }

		        /* -------------------------------------
		        BODY & CONTAINER
		        ------------------------------------- */

		        .body {
		        background-color: #f6f6f6;
		        width: 100%; 
		        }

		        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
		        .container {
		        display: block;
		        margin: 0 auto !important;
		        /* makes it centered */
		        max-width: 860px;
		        padding: 10px;
		        width: 860px; 
		        }

		        /* This should also be a block element, so that it will fill 100% of the .container */
		        .content {
		        box-sizing: border-box;
		        display: block;
		        margin: 0 auto;
		        max-width: 860px;
		        padding: 10px; 
		        }

		        /* -------------------------------------
		        HEADER, FOOTER, MAIN
		        ------------------------------------- */
		        .main {
		        background: #ffffff;
		        border-radius: 3px;
		        width: 860px; 
		        }

		        .wrapper {
		        box-sizing: border-box;
		        padding: 20px 50px; 
		        }

		        .content-block {
		        padding-bottom: 10px;
		        padding-top: 10px;
		        }

		        .footer {
		        clear: both;
		        margin-top: 10px;
		        text-align: center;
		        width: 100%; 
		        }
		        .footer td,
		        .footer p,
		        .footer span,
		        .footer a {
		        color: #999999;
		        font-size: 12px;
		        text-align: center; 
		        }

		        /* -------------------------------------
		        TYPOGRAPHY
		        ------------------------------------- */
		        h1,
		        h2,
		        h3,
		        h4 {
		        color: #000000;
		        font-family: Calibri, sans-serif;
		        font-weight: 400;
		        line-height: 1.4;
		        margin: 0;
		        margin-bottom: 30px; 
		        }

		        h1 {
		        font-size: 35px;
		        font-weight: 300;
		        text-align: center;
		        text-transform: capitalize; 
		        }

		        p,
		        ul,
		        ol {
		        font-family: Calibri, sans-serif;
		        font-size: 14px;
		        font-weight: normal;
		        margin: 0;
		        margin-bottom: 15px; 
		        }
		        p li,
		        ul li,
		        ol li {
		        list-style-position: inside;
		        margin-left: 5px; 
		        }

		        a {
		        color: #3498db;
		        text-decoration: none; 
		        }
		        a.abmeldung_btn {
		        text-decoration: none !important;
		        }
		        a:hover {
		        text-decoration: underline;
		        }

		        /* -------------------------------------
		        BUTTONS
		        ------------------------------------- */
		        .btn {
		        box-sizing: border-box;
		        width: 100%; }
		        .btn > tbody > tr > td {
		        padding-bottom: 15px; }
		        .btn table {
		        width: auto; 
		        }
		        .btn table td {
		        background-color: #ffffff;
		        border-radius: 5px;
		        text-align: center; 
		        }
		        .btn a {
		        background-color: #ffffff;
		        border: solid 1px #3498db;
		        border-radius: 5px;
		        box-sizing: border-box;
		        color: #3498db;
		        cursor: pointer;
		        display: inline-block;
		        font-size: 14px;
		        font-weight: bold;
		        margin: 0;
		        padding: 12px 25px;
		        text-decoration: none;
		        text-transform: capitalize; 
		        }

		        .btn-primary table td {
		        background-color: #3498db; 
		        }

		        .btn-primary a {
		        background-color: #3498db;
		        border-color: #3498db;
		        color: #ffffff; 
		        }

		        /* -------------------------------------
		        OTHER STYLES THAT MIGHT BE USEFUL
		        ------------------------------------- */
		        .last {
		        margin-bottom: 0; 
		        }

		        .first {
		        margin-top: 0; 
		        }

		        .align-center {
		        text-align: center; 
		        }

		        .align-right {
		        text-align: right; 
		        }

		        .align-left {
		        text-align: left; 
		        }

		        .clear {
		        clear: both; 
		        }

		        .mt0 {
		        margin-top: 0; 
		        }

		        .mb0 {
		        margin-bottom: 0; 
		        }

		        .preheader {
		        color: transparent;
		        display: none;
		        height: 0;
		        max-height: 0;
		        max-width: 0;
		        opacity: 0;
		        overflow: hidden;
		        mso-hide: all;
		        visibility: hidden;
		        width: 0; 
		        }

		        .powered-by a {
		        text-decoration: none; 
		        }

		        hr {
		        border: 0;
		        border-bottom: 1px solid #f6f6f6;
		        margin: 20px 0; 
		        }

		        /* -------------------------------------
		        RESPONSIVE AND MOBILE FRIENDLY STYLES
		        ------------------------------------- */
		        @media only screen and (max-width: 620px) {
		        table.body h1 {
		        font-size: 28px !important;
		        margin-bottom: 10px !important; 
		        }
		        table.body p,
		        table.body ul,
		        table.body ol,
		        table.body td,
		        table.body span,
		        table.body a {
		        font-size: 16px !important; 
		        }
		        table.body .wrapper,
		        table.body .article {
		        padding: 10px !important; 
		        }
		        table.body .content {
		        padding: 0 !important; 
		        }
		        table.body .container {
		        padding: 0 !important;
		        width: 100% !important; 
		        }
		        table.body .main {
		        border-left-width: 0 !important;
		        border-radius: 0 !important;
		        border-right-width: 0 !important; 
		        }
		        table.body .btn table {
		        width: 100% !important; 
		        }
		        table.body .btn a {
		        width: 100% !important; 
		        }
		        table.body .img-responsive {
		        height: 100% !important;
		        max-width: 100% !important;
		        width: auto !important; 
		        }
		        }

		        /* -------------------------------------
		        PRESERVE THESE STYLES IN THE HEAD
		        ------------------------------------- */
		        @media all {
		        .ExternalClass {
		        width: 100%; 
		        }
		        .ExternalClass,
		        .ExternalClass p,
		        .ExternalClass span,
		        .ExternalClass font,
		        .ExternalClass td,
		        .ExternalClass div {
		        line-height: 100%; 
		        }
		        .apple-link a {
		        color: inherit !important;
		        font-family: inherit !important;
		        font-size: inherit !important;
		        font-weight: inherit !important;
		        line-height: inherit !important;
		        text-decoration: none !important; 
		        }
		        #MessageViewBody a {
		        color: inherit;
		        text-decoration: none;
		        font-size: inherit;
		        font-family: inherit;
		        font-weight: inherit;
		        line-height: inherit;
		        }
		        .btn-primary table td:hover {
		        background-color: #34495e !important; 
		        }
		        .btn-primary a:hover {
		        background-color: #34495e !important;
		        border-color: #34495e !important; 
		        } 
		        }
		        .mail__text {
		        font-size: 18px;
		        font-family: Calibri, sans-serif;
		        color: #000;
		        }
		        .mail__text a {
		        color: #e2001a
		        }
		        .abmeldung_btn {
		        font-weight: bold !important;
		        background-color: #e2001a !important;
		        color: #fff !important;
		        text-decoration: none !important;
		        font-family: Calibri,sans-serif !important;
		        padding: 26px 15px !important;
		        font-size: 18px !important;
		        }
		        .abmeldung_btn:hover {
		        background-color: #ff0522 !important;
		        }

		        #prefooter td {
		        width: 23% !important;
		        text-align: center !important;
		        padding-bottom: 35px !important;
		        }

		        .support-link, .tel-link, .email-link {
		        font-family: "Calibri",sans-serif !important;
		        font-size: 18px !important;
		        color: #252525 !important;
		        text-decoration: none !important;
		        outline: none !important;
		        justify-content: center !important;
		        display: flex !important;
		        align-items: center !important;
		        }
		        .support-link:hover, .tel-link:hover, .email-link:hover {
		        text-decoration: underline !important;
		        color: #e2001a !important;
		        }
		        .support-link img, .tel-link img, .email-link img {
		        padding-right: 8px !important;
		        }

		        /* Footer */
		        .basicFooter {
		        display: block !important;
		        background-color: #fff !important;
		        overflow: visible !important;
		        min-height: 230px !important;
		        padding: 50px 50px 0 50px !important;
		        }
		        .f-logo {
		        line-height: 1.5;
		        width: 25%;
		        padding-top: 3px;
		        }
		        .foo-item {
		        display: inline-block;
		        vertical-align: top;
		        }
		        .f-adress {
		        line-height: 1.5;
		        width: 26%;
		        }
		        .f-cont {
		        width: 20%;
		        }
		        .logo-pb {
		        padding-bottom: 20px;
		        color: #252525;
		        }
		        .logo-text {
		        font-family: "Calibri",sans-serif;
		        font-size: 16px;
		        }
		        .f-logo .f-img {
		        margin-bottom: 20px;
		        width: 100%;
		        }
		        .logo-img {
		        width: 100%;
		        }
		        .title-address, .title-cont, .title-nav, .title-followus, .title-news {
		        font-family: "Calibri",sans-serif !important;
		        font-size: 18px !important;
		        color: #e2001a !important;
		        text-transform: uppercase !important;
		        padding-bottom: 16px !important;
		        }

		        .logo-text {
		        padding-bottom: 20px;
		        font-family: "Calibri",sans-serif;
		        font-size: 16px;
		        color: #252525;
		        }
		        .ad {
		        font-size: 16px;
		        font-family: "Calibri",sans-serif;
		        color: #252525;
		        }
		        .f-adress .ad {
		        font-size: 16px;
		        font-family: "Calibri",sans-serif;
		        color: #252525;
		        }
		        .pt-ad {
		        padding-top: 0px;
		        }
		        .cont_list {
		        list-style: none;
		        padding-left: 0;
		        }
		        .cont_list li a {
		        text-decoration: none;
		        color: #252525;
		        font-family: "Calibri",sans-serif;
		        font-size: 16px;
		        }
		        .cont_list li a:hover,
		        .pt-ad a:hover {
		        text-decoration: underline;
		        color: #e2001a !important;
		        }

		        .pt-ad a {
		        text-decoration: none;
		        font-size: 16px;
		        font-family: "Calibri", sans-serif;
		        color: #252525;
		        }

		        .top {
		        position: relative;
		        display: table;
		        width: 50%;
		        transition: all 0.5s ease;
		        -webkit-transition: all 0.5s ease;
		        margin: auto;
		        }
		        .top .th {
		        color: #ffffff;
		        display: table-cell;
		        vertical-align: middle;
		        }

		        .top .name {
		        font-family: "Calibri", sans-serif;
		        font-size: 24px;
		        color: #e3001b;
		        }

		    </style>
		  </head>
		  <body>

		    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
		      <tr>
		        <td>&nbsp;</td>
		        <td class="container">
		          <div class="content">

		            <!-- START CENTERED WHITE CONTAINER -->
		            <table role="presentation" class="main">

		              <tr>
		                <td style="text-align: center;" colspan="3">
		                  <img style="width: 75%" src="'.$URL_ROOT.'emailTemplate1/lines.png">
		                </td>
		              </tr>
		              <tr>
		                <td style="text-align: center;padding-top: 15px" colspan="3">
		                  <div class="top">
		                    <div class="logo th">   
		                      <img src="'.$URL_ROOT.'emailTemplate1/logoheaderpng.png">
		                    </div>
		                    <div class="name th" id="nameLogo">
		                      Frowein GMBH & CO. KG
		                    </div>
		                  </div>
		                  
		                </td>
		              </tr>

		              <!-- START MAIN CONTENT AREA -->
		              <tr>
		                <td class="wrapper" colspan="3">
		                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="background-color: #f2f2f2;padding: 24px">
		                    <tr>
		                      <td>
		                        <p class="mail__text">Vielen Dank für die Bestätigung Ihrer Anmeldung.</p>
		                        <p class="mail__text">Sie können nun <a href="'.$URL_ROOT.'vCard.vcf">unsere Daten</a> zu Ihren Kontakten hinzufügen</p>
		                        <p class="mail__text"><a href="https://frowein808.de/">Weiter unsere Webseite nutzen</a></p>
		                        <p class="mail__text">Sie erhalten diese E-Mail, da Sie sich für einen (oder mehrere) Newsletter der FROWEIN GmbH & CO. KG angemeldet haben.</p>
		                      </td>
		                    </tr>

		                  </table>
		                </td>
		              </tr>

		              <tr>
		                <td colspan="3">

		                  <div class="basicFooter">
		                     <div>
		                        <div class="f-logo foo-item">
		                           <div class="logo-text logo-pb">
		                              Registered Trademark
		                           </div>
		                           <div class="f-img">
		                              <div class="logo-img">
		                                 <img src="'.$URL_ROOT.'emailTemplate1/logofooter.png" style="width: 56px">
		                              </div>
		                              <div style="padding-top: 15px">
		                                 <div class="ad">Frowein<br>GmbH & CO. KG</div>
		                              </div>

		                           </div>
		                        </div>
		                        <div class="f-adress foo-item">
		                           <h2 class="title-address"><img style="padding-right: 5px;width:10px !important" src="'.$URL_ROOT.'emailTemplate1/Rectangle9.png"> Kontakt</h2>
		                           <div class="logo-text">
		                              Am Reislebach 83<br>D-72461 Albstadt
		                           </div>
		                           <div class="ad pt-ad"><a href="https://www.frowein808.de/" target="_blank">www.frowein808.de</a></div>
		                        </div>
		                        <div class="f-cont foo-item">
		                           <h2 class="title-cont"><img style="padding-right: 5px;width:10px !important" src="'.$URL_ROOT.'emailTemplate1/Rectangle9.png"> Info</h2>
		                           <ul class="cont_list">
		                              <li><a href="'.$URL_ROOT.'de/'.'agb/">AGB</a></li>
		                              <!-- <li><a href="/" data-bs-toggle="modal" data-bs-target="#cookiesDataModal">Cookies</a></li> -->
		                              <li><a href="'.$URL_ROOT.'de/'.'impressum/">Impressum</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'datenschutz/">Datenschutz</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'news/">Aktuelles</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'contact/">Kontakt</a></li>
		                           </ul>
		                        </div>
		                        <div class="f-adress foo-item">
		                           <h2 class="title-nav"><img style="padding-right: 5px;width:10px !important" src="'.$URL_ROOT.'emailTemplate1/Rectangle9.png"> Navigation</h2>
		                           <ul class="cont_list">
		                              <li><a href="'.$URL_ROOT.'de/'.'">Startseite</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'about/">Unternehmen</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'products/">Produkte</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'anmeldung/">Newsletter</a></li>
		                           </ul>
		                        </div>
		                     </div>
		                  </div>

		                </td>
		              </tr>

		              <tr>
		                <td colspan="3" class="wrapper" style="width: 100%">
		                  <img src="'.$URL_ROOT.'emailTemplate1/lineFooter1.png" style="width: 100%">
		                </td>
		              </tr>


		              <tr id="prefooter">
		                <td class="wrapper">
		                  <a href="'.$URL_ROOT.'de/'.'support/" style="display: flex !important;align-items: center !important;" class="support-link"><img style="width: auto;height: 100%;padding-top: 1px" src="'.$URL_ROOT.'emailTemplate1/support_icon.png">Kontaktformular</a>
		                </td>
		                <td class="wrapper">
		                  <a href="tel:+49 7432 956-0" style="display: flex !important;align-items: center !important;" class="tel-link"><img style="width: auto;height: 100%;padding-top: 3px" src="'.$URL_ROOT.'emailTemplate1/tel.png">+49 7432 956-0</a>
		                </td>
		                <td class="wrapper">
		                  <a href="mailto:info@frowein808.de" style="display: flex !important;align-items: center !important;" class="email-link"><img style="width: auto;height: 100%;padding-top: 5px" src="'.$URL_ROOT.'emailTemplate1/mail.png">info@frowein808.de</a>
		                </td>
		              </tr>


		              <tr>
		                <td style="text-align: center;" colspan="3">
		                  <img style="width: 75%" src="'.$URL_ROOT.'emailTemplate1/linesbottom.png">
		                </td>
		              </tr>

		            <!-- END MAIN CONTENT AREA -->
		            </table>
		            <!-- END CENTERED WHITE CONTAINER -->

		          </div>
		        </td>
		        <td>&nbsp;</td>
		      </tr>
		    </table>
		  </body>
		</html>
			';

			// $message = '
			// Vielen Dank für die Bestätigung Ihrer Anmeldung.<br /><br /> 
			// FROWEIN GmbH & CO. KG <br />
			// Am Reislebach 83<br />
			// 72461 Albstadt<br />
			// Germany<br /><br />
 
			// Sie können nun <a href="'.$URL_ROOT.'vCard.vcf">unsere Daten</a> zu Ihren Kontakten hinzufügen <br /><br />
			 
			// <a href="https://frowein808.de/">Weiter unsere Webseite nutzen</a><br /><br />
			// Sie erhalten diese E-Mail, da Sie sich für einen (oder mehrere) Newsletter der FROWEIN GmbH & CO. KG angemeldet haben.<br />
			// Zum Abbestellen des Newsletters können Sie hier klicken:  <a href="'.$URL_ROOT.'abmeldung">Newsletter abbestellen</a>
			// ';


			
			$subject ='=?UTF-8?B?'.base64_encode("Anmeldung bestätigt"). "?=";
		} else {
			$txt = '<h2>Thanks for your registration. You will receive our newsletter now.</h2>';


			$message = '
		<html>
		  <head>
		    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		    <title>Abmelden</title>
		    <style>
		        /* -------------------------------------
		        GLOBAL RESETS
		        ------------------------------------- */

		        /*All the styling goes here*/

		        img {
		        border: none;
		        -ms-interpolation-mode: bicubic;
		        max-width: 100%; 
		        }

		        body {
		        background-color: #f6f6f6;
		        font-family: Calibri, sans-serif;
		        -webkit-font-smoothing: antialiased;
		        font-size: 14px;
		        line-height: 1.4;
		        margin: 0;
		        padding: 0;
		        -ms-text-size-adjust: 100%;
		        -webkit-text-size-adjust: 100%; 
		        }

		        table {
		        border-collapse: separate;
		        mso-table-lspace: 0pt;
		        mso-table-rspace: 0pt;
		        width: 100%; }
		        table td {
		        font-family: Calibri, sans-serif;
		        font-size: 14px;
		        vertical-align: top; 
		        }

		        /* -------------------------------------
		        BODY & CONTAINER
		        ------------------------------------- */

		        .body {
		        background-color: #f6f6f6;
		        width: 100%; 
		        }

		        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
		        .container {
		        display: block;
		        margin: 0 auto !important;
		        /* makes it centered */
		        max-width: 860px;
		        padding: 10px;
		        width: 860px; 
		        }

		        /* This should also be a block element, so that it will fill 100% of the .container */
		        .content {
		        box-sizing: border-box;
		        display: block;
		        margin: 0 auto;
		        max-width: 860px;
		        padding: 10px; 
		        }

		        /* -------------------------------------
		        HEADER, FOOTER, MAIN
		        ------------------------------------- */
		        .main {
		        background: #ffffff;
		        border-radius: 3px;
		        width: 860px; 
		        }

		        .wrapper {
		        box-sizing: border-box;
		        padding: 20px 50px; 
		        }

		        .content-block {
		        padding-bottom: 10px;
		        padding-top: 10px;
		        }

		        .footer {
		        clear: both;
		        margin-top: 10px;
		        text-align: center;
		        width: 100%; 
		        }
		        .footer td,
		        .footer p,
		        .footer span,
		        .footer a {
		        color: #999999;
		        font-size: 12px;
		        text-align: center; 
		        }

		        /* -------------------------------------
		        TYPOGRAPHY
		        ------------------------------------- */
		        h1,
		        h2,
		        h3,
		        h4 {
		        color: #000000;
		        font-family: Calibri, sans-serif;
		        font-weight: 400;
		        line-height: 1.4;
		        margin: 0;
		        margin-bottom: 30px; 
		        }

		        h1 {
		        font-size: 35px;
		        font-weight: 300;
		        text-align: center;
		        text-transform: capitalize; 
		        }

		        p,
		        ul,
		        ol {
		        font-family: Calibri, sans-serif;
		        font-size: 14px;
		        font-weight: normal;
		        margin: 0;
		        margin-bottom: 15px; 
		        }
		        p li,
		        ul li,
		        ol li {
		        list-style-position: inside;
		        margin-left: 5px; 
		        }

		        a {
		        color: #3498db;
		        text-decoration: none; 
		        }
		        a.abmeldung_btn {
		        text-decoration: none !important;
		        }
		        a:hover {
		        text-decoration: underline;
		        }

		        /* -------------------------------------
		        BUTTONS
		        ------------------------------------- */
		        .btn {
		        box-sizing: border-box;
		        width: 100%; }
		        .btn > tbody > tr > td {
		        padding-bottom: 15px; }
		        .btn table {
		        width: auto; 
		        }
		        .btn table td {
		        background-color: #ffffff;
		        border-radius: 5px;
		        text-align: center; 
		        }
		        .btn a {
		        background-color: #ffffff;
		        border: solid 1px #3498db;
		        border-radius: 5px;
		        box-sizing: border-box;
		        color: #3498db;
		        cursor: pointer;
		        display: inline-block;
		        font-size: 14px;
		        font-weight: bold;
		        margin: 0;
		        padding: 12px 25px;
		        text-decoration: none;
		        text-transform: capitalize; 
		        }

		        .btn-primary table td {
		        background-color: #3498db; 
		        }

		        .btn-primary a {
		        background-color: #3498db;
		        border-color: #3498db;
		        color: #ffffff; 
		        }

		        /* -------------------------------------
		        OTHER STYLES THAT MIGHT BE USEFUL
		        ------------------------------------- */
		        .last {
		        margin-bottom: 0; 
		        }

		        .first {
		        margin-top: 0; 
		        }

		        .align-center {
		        text-align: center; 
		        }

		        .align-right {
		        text-align: right; 
		        }

		        .align-left {
		        text-align: left; 
		        }

		        .clear {
		        clear: both; 
		        }

		        .mt0 {
		        margin-top: 0; 
		        }

		        .mb0 {
		        margin-bottom: 0; 
		        }

		        .preheader {
		        color: transparent;
		        display: none;
		        height: 0;
		        max-height: 0;
		        max-width: 0;
		        opacity: 0;
		        overflow: hidden;
		        mso-hide: all;
		        visibility: hidden;
		        width: 0; 
		        }

		        .powered-by a {
		        text-decoration: none; 
		        }

		        hr {
		        border: 0;
		        border-bottom: 1px solid #f6f6f6;
		        margin: 20px 0; 
		        }

		        /* -------------------------------------
		        RESPONSIVE AND MOBILE FRIENDLY STYLES
		        ------------------------------------- */
		        @media only screen and (max-width: 620px) {
		        table.body h1 {
		        font-size: 28px !important;
		        margin-bottom: 10px !important; 
		        }
		        table.body p,
		        table.body ul,
		        table.body ol,
		        table.body td,
		        table.body span,
		        table.body a {
		        font-size: 16px !important; 
		        }
		        table.body .wrapper,
		        table.body .article {
		        padding: 10px !important; 
		        }
		        table.body .content {
		        padding: 0 !important; 
		        }
		        table.body .container {
		        padding: 0 !important;
		        width: 100% !important; 
		        }
		        table.body .main {
		        border-left-width: 0 !important;
		        border-radius: 0 !important;
		        border-right-width: 0 !important; 
		        }
		        table.body .btn table {
		        width: 100% !important; 
		        }
		        table.body .btn a {
		        width: 100% !important; 
		        }
		        table.body .img-responsive {
		        height: 100% !important;
		        max-width: 100% !important;
		        width: auto !important; 
		        }
		        }

		        /* -------------------------------------
		        PRESERVE THESE STYLES IN THE HEAD
		        ------------------------------------- */
		        @media all {
		        .ExternalClass {
		        width: 100%; 
		        }
		        .ExternalClass,
		        .ExternalClass p,
		        .ExternalClass span,
		        .ExternalClass font,
		        .ExternalClass td,
		        .ExternalClass div {
		        line-height: 100%; 
		        }
		        .apple-link a {
		        color: inherit !important;
		        font-family: inherit !important;
		        font-size: inherit !important;
		        font-weight: inherit !important;
		        line-height: inherit !important;
		        text-decoration: none !important; 
		        }
		        #MessageViewBody a {
		        color: inherit;
		        text-decoration: none;
		        font-size: inherit;
		        font-family: inherit;
		        font-weight: inherit;
		        line-height: inherit;
		        }
		        .btn-primary table td:hover {
		        background-color: #34495e !important; 
		        }
		        .btn-primary a:hover {
		        background-color: #34495e !important;
		        border-color: #34495e !important; 
		        } 
		        }
		        .mail__text {
		        font-size: 18px;
		        font-family: Calibri, sans-serif;
		        color: #000;
		        }
		        .mail__text a {
		        color: #e2001a
		        }
		        .abmeldung_btn {
		        font-weight: bold !important;
		        background-color: #e2001a !important;
		        color: #fff !important;
		        text-decoration: none !important;
		        font-family: Calibri,sans-serif !important;
		        padding: 26px 15px !important;
		        font-size: 18px !important;
		        }
		        .abmeldung_btn:hover {
		        background-color: #ff0522 !important;
		        }

		        #prefooter td {
		        width: 23% !important;
		        text-align: center !important;
		        padding-bottom: 35px !important;
		        }

		        .support-link, .tel-link, .email-link {
		        font-family: "Calibri",sans-serif !important;
		        font-size: 18px !important;
		        color: #252525 !important;
		        text-decoration: none !important;
		        outline: none !important;
		        justify-content: center !important;
		        display: flex !important;
		        align-items: center !important;
		        }
		        .support-link:hover, .tel-link:hover, .email-link:hover {
		        text-decoration: underline !important;
		        color: #e2001a !important;
		        }
		        .support-link img, .tel-link img, .email-link img {
		        padding-right: 8px !important;
		        }

		        /* Footer */
		        .basicFooter {
		        display: block !important;
		        background-color: #fff !important;
		        overflow: visible !important;
		        min-height: 230px !important;
		        padding: 50px 50px 0 50px !important;
		        }
		        .f-logo {
		        line-height: 1.5;
		        width: 25%;
		        padding-top: 3px;
		        }
		        .foo-item {
		        display: inline-block;
		        vertical-align: top;
		        }
		        .f-adress {
		        line-height: 1.5;
		        width: 26%;
		        }
		        .f-cont {
		        width: 20%;
		        }
		        .logo-pb {
		        padding-bottom: 20px;
		        color: #252525;
		        }
		        .logo-text {
		        font-family: "Calibri",sans-serif;
		        font-size: 16px;
		        }
		        .f-logo .f-img {
		        margin-bottom: 20px;
		        width: 100%;
		        }
		        .logo-img {
		        width: 100%;
		        }
		        .title-address, .title-cont, .title-nav, .title-followus, .title-news {
		        font-family: "Calibri",sans-serif !important;
		        font-size: 18px !important;
		        color: #e2001a !important;
		        text-transform: uppercase !important;
		        padding-bottom: 16px !important;
		        }

		        .logo-text {
		        padding-bottom: 20px;
		        font-family: "Calibri",sans-serif;
		        font-size: 16px;
		        color: #252525;
		        }
		        .ad {
		        font-size: 16px;
		        font-family: "Calibri",sans-serif;
		        color: #252525;
		        }
		        .f-adress .ad {
		        font-size: 16px;
		        font-family: "Calibri",sans-serif;
		        color: #252525;
		        }
		        .pt-ad {
		        padding-top: 0px;
		        }
		        .cont_list {
		        list-style: none;
		        padding-left: 0;
		        }
		        .cont_list li a {
		        text-decoration: none;
		        color: #252525;
		        font-family: "Calibri",sans-serif;
		        font-size: 16px;
		        }
		        .cont_list li a:hover,
		        .pt-ad a:hover {
		        text-decoration: underline;
		        color: #e2001a !important;
		        }

		        .pt-ad a {
		        text-decoration: none;
		        font-size: 16px;
		        font-family: "Calibri", sans-serif;
		        color: #252525;
		        }

		        .top {
		        position: relative;
		        display: table;
		        width: 50%;
		        transition: all 0.5s ease;
		        -webkit-transition: all 0.5s ease;
		        margin: auto;
		        }
		        .top .th {
		        color: #ffffff;
		        display: table-cell;
		        vertical-align: middle;
		        }

		        .top .name {
		        font-family: "Calibri", sans-serif;
		        font-size: 24px;
		        color: #e3001b;
		        }

		    </style>
		  </head>
		  <body>

		    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
		      <tr>
		        <td>&nbsp;</td>
		        <td class="container">
		          <div class="content">

		            <!-- START CENTERED WHITE CONTAINER -->
		            <table role="presentation" class="main">

		              <tr>
		                <td style="text-align: center;" colspan="3">
		                  <img style="width: 75%" src="'.$URL_ROOT.'emailTemplate1/lines.png">
		                </td>
		              </tr>
		              <tr>
		                <td style="text-align: center;padding-top: 15px" colspan="3">
		                  <div class="top">
		                    <div class="logo th">   
		                      <img src="'.$URL_ROOT.'emailTemplate1/logoheaderpng.png">
		                    </div>
		                    <div class="name th" id="nameLogo">
		                      Frowein GMBH & CO. KG
		                    </div>
		                  </div>
		                  
		                </td>
		              </tr>

		              <!-- START MAIN CONTENT AREA -->
		              <tr>
		                <td class="wrapper" colspan="3">
		                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="background-color: #f2f2f2;padding: 24px">
		                    <tr>
		                      <td>
									<p class="mail__text">Thank you for confirming your subscription.</p>
									<p class="mail__text">You can now <a href="'.$URL_ROOT.'vCard.vcf">add our data</a> to your contacts</p>
									<p class="mail__text"><a href="https://frowein808.de/">Continue using our website</a></p>
									<p class="mail__text">You are receiving this e-mail because you have signed up for one (or more) newsletters from FROWEIN GmbH & CO. KG have registered.</p>
		                      </td>
		                    </tr>

		                  </table>
		                </td>
		              </tr>

		              <tr>
		                <td colspan="3">

		                  <div class="basicFooter">
		                     <div>
		                        <div class="f-logo foo-item">
		                           <div class="logo-text logo-pb">
		                              Registered Trademark
		                           </div>
		                           <div class="f-img">
		                              <div class="logo-img">
		                                 <img src="'.$URL_ROOT.'emailTemplate1/logofooter.png" style="width: 56px">
		                              </div>
		                              <div style="padding-top: 15px">
		                                 <div class="ad">Frowein<br>GmbH & CO. KG</div>
		                              </div>

		                           </div>
		                        </div>
		                        <div class="f-adress foo-item">
		                           <h2 class="title-address"><img style="padding-right: 5px;width:10px !important" src="'.$URL_ROOT.'emailTemplate1/Rectangle9.png"> Kontakt</h2>
		                           <div class="logo-text">
		                              Am Reislebach 83<br>D-72461 Albstadt
		                           </div>
		                           <div class="ad pt-ad"><a href="https://www.frowein808.de/" target="_blank">www.frowein808.de</a></div>
		                        </div>
		                        <div class="f-cont foo-item">
		                           <h2 class="title-cont"><img style="padding-right: 5px;width:10px !important" src="'.$URL_ROOT.'emailTemplate1/Rectangle9.png"> Info</h2>
		                           <ul class="cont_list">
		                              <li><a href="'.$URL_ROOT.'de/'.'agb/">AGB</a></li>
		                              <!-- <li><a href="/" data-bs-toggle="modal" data-bs-target="#cookiesDataModal">Cookies</a></li> -->
		                              <li><a href="'.$URL_ROOT.'de/'.'impressum/">Impressum</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'datenschutz/">Datenschutz</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'news/">Aktuelles</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'contact/">Kontakt</a></li>
		                           </ul>
		                        </div>
		                        <div class="f-adress foo-item">
		                           <h2 class="title-nav"><img style="padding-right: 5px;width:10px !important" src="'.$URL_ROOT.'emailTemplate1/Rectangle9.png"> Navigation</h2>
		                           <ul class="cont_list">
		                              <li><a href="'.$URL_ROOT.'de/'.'">Startseite</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'about/">Unternehmen</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'products/">Produkte</a></li>
		                              <li><a href="'.$URL_ROOT.'de/'.'anmeldung/">Newsletter</a></li>
		                           </ul>
		                        </div>
		                     </div>
		                  </div>

		                </td>
		              </tr>

		              <tr>
		                <td colspan="3" class="wrapper" style="width: 100%">
		                  <img src="'.$URL_ROOT.'emailTemplate1/lineFooter1.png" style="width: 100%">
		                </td>
		              </tr>


		              <tr id="prefooter">
		                <td class="wrapper">
		                  <a href="'.$URL_ROOT.'de/'.'support/" style="display: flex !important;align-items: center !important;" class="support-link"><img style="width: auto;height: 100%;padding-top: 1px" src="'.$URL_ROOT.'emailTemplate1/support_icon.png">Kontaktformular</a>
		                </td>
		                <td class="wrapper">
		                  <a href="tel:+49 7432 956-0" style="display: flex !important;align-items: center !important;" class="tel-link"><img style="width: auto;height: 100%;padding-top: 3px" src="'.$URL_ROOT.'emailTemplate1/tel.png">+49 7432 956-0</a>
		                </td>
		                <td class="wrapper">
		                  <a href="mailto:info@frowein808.de" style="display: flex !important;align-items: center !important;" class="email-link"><img style="width: auto;height: 100%;padding-top: 5px" src="'.$URL_ROOT.'emailTemplate1/mail.png">info@frowein808.de</a>
		                </td>
		              </tr>


		              <tr>
		                <td style="text-align: center;" colspan="3">
		                  <img style="width: 75%" src="'.$URL_ROOT.'emailTemplate1/linesbottom.png">
		                </td>
		              </tr>

		            <!-- END MAIN CONTENT AREA -->
		            </table>
		            <!-- END CENTERED WHITE CONTAINER -->

		          </div>
		        </td>
		        <td>&nbsp;</td>
		      </tr>
		    </table>
		  </body>
		</html>
			';


			// $message = '
			// Thank you for confirming your registration.<br /><br />
			// FROWEIN GmbH & CO. KG<br />
			// Am Reislebach 83<br />
			// 72461 Albstadt<br />
			// Germany<br /><br />
 
			// You can now add <a href="'.$URL_ROOT.'vCard.vcf">our data</a> to your contacts.<br /><br />
				 
			// <a href="https://frowein808.de/">Continue to use our website</a><br /><br />
			// You receive this e-mail because you have registered for one (or more) newsletters from FROWEIN GmbH & CO. KG.
			// To unsubscribe the newsletter you can click here: <a href="'.$URL_ROOT.'abmeldung">unsubscribe newsletter</a> 
			// ';



			$subject ='=?UTF-8?B?'.base64_encode("Registration confirmed"). "?=";
		}
		
		$recipient=($user['user_email']);
		
		mail('info@frowein808.de',$subject,$message,$headers);
		mail($recipient,$subject,$message,$headers);
	} else {
		if($LANG["language"]["shortname"] == "de"){
			$txt = '<h2>Vielen Dank für Ihre Anmeldung. Sie erhalten nun unseren Newsletter.</h2>';
		} else {
			$txt = '<h2>Thanks for your registration. You will receive our newsletter now.</h2>';
		}
	}
?>
<div class="main-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-12 errorNewsletter_section" id="errNewsletter">
				<?php echo $txt;?>
			</div>
		</div>
	</div>
</div>