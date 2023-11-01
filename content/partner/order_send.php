<?php

if ($SPRACHE == "de") {
	$langLink = "de";
	$btnSend = "Senden";
	$startsite = "Startseite";
	$information = "Informationsmaterial";
}
if ($SPRACHE == "en") {
	$langLink = "en";
	$btnSend = "Send";
	$startsite = "Home";
	$information = "Information";
}

$html .='
<div class="breadcrumbs py-4">
    <nav style="--bs-breadcrumb-divider: \'>\';" aria-label="breadcrumb" class="container">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="/'.$langLink.'/">'.$startsite.'</a></li>
        <li class="breadcrumb-item"><a href="/'.$langLink.'/partner/order/">PARTNER-NET</a></li>
        <li class="breadcrumb-item active" aria-current="page">'.$information.'</li>
      </ol>
    </nav>
</div>
<div class="impr pt-5">
    <div class="blog"> 
		<div class="bl-content" id="blog_content2">
			<div class="container">
           
                <div class="bl-right bl">';
                        $mailit = $_POST["mailit"];
                        $kundennummer = $_POST["kundennummer"];
                        $name = $_POST["name"];
                        $name2 = $_POST["name2"];
                        $strasse = $_POST["strasse"];
                        $ort = $_POST["ort"];
                        $plz = $_POST["plz"];
			if (!empty($mailit))
			{
			  $mailbody .= "Unterlagenanforderung über das partner-net:"."\n\n";
			  $mailbody .= "Kundennummer: ".$kundennummer."\n";
			  $mailbody .= "Name: ".$name."\n";
			  $mailbody .= "Name2: ".$name2."\n";
			  $mailbody .= "Strasse: ".$strasse."\n";
			  $mailbody .= "Plz: ".$plz." Ort: ".$ort."\n\n\n";
			  $mailbody .= "Unterlagen:\n\n";
              

			  foreach ($_POST as $key => $val)
		      {
		        if (preg_match("/send_/",$key))
		          $mailbody .= "".$val."\n";
			  }

			  $mailbody .= "\n\n".'ENDE AUTOMATISCH GENERIERTE MAIL - '.date("d.m.Y h:m").'';
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/plain; charset=UTF-8' . "\r\n"; 
				$header .= 'From: homepage@frowein808.de\r\n';			
				$header .= 'Reply-To: homepage@frowein808.de\r\n';
				$header .= 'X-Mailer: PHP/' . phpversion();
 
			  mail("info@frowein808.de","Bestellung von Unterlagen - Kundennummer: ".$kundennummer."",$mailbody,$header);
			  //mail("harz@morgana.de","Bestellung von Unterlagen - Kundennummer: ".$kundennummer."",$mailbody,$header);
              
			  if ($SPRACHE == "de")
			    $html .= '<h2 class="success_send_message">Wir haben Ihre Anforderung erhalten und werden uns umgehend darum kümmern.</h2>';
              if ($SPRACHE == "en")
			    $html .= '<h2 class="success_send_message">You will receive the requested information and documents immediately.</h2>';
			}
                        else{

			// AUSWAHLVARIABLEN IN LISTE SETZEN
		    foreach ($_POST as $key => $val)
		    {
		      if (preg_match("/auswahl_/",$key))
			  {
			    $one = 1;
			    $key = preg_replace("/auswahl_/","",$key);
		        $list .= $key.",";
		      }
			}


			if (empty($one))
			{
			  if ($SPRACHE == "de") {
			      $html .= '<h2 class="err_order_msg">Bitte mindestens einen Artikel auswählen.</h2><br>';
			      $html .= '<a class="order__back-link" href="../order/">&laquo; zurück zu Auswahl</a>';
			  }
			  if ($SPRACHE == "en") {
			      $html .= '<h2 class="err_order_msg">Please select at least one Article.</h2><br>';
			      $html .= '<a class="order__back-link" href="../order/">&laquo; back</a>';
			  }
			} else {

							// LETZTES KOMMA CUTTEN
							$list = preg_replace("(,$)","",$list);

							$query = 'SELECT o.id AS o_id,
											 o.news_headline AS o_news_headline,
											 o.news_subline AS o_news_subline,
											 n.user_name AS n_user_name,
											 n.user_name2 AS n_user_name2,
											 n.user_street AS n_user_street,
											 n.user_zip AS n_user_zip,
											 n.user_ort AS n_user_ort,
											 c.cat_name AS c_cat_name
									    FROM orderinfo_text AS o,
											 newsletter_users AS n,
											 orderinfo_categories AS c
									   WHERE kundennummer = '.intval($KUNDENNUMMER).'
									     AND o.id IN ('.$list.')
										 AND o.news_cat_id = c.id
								';

							$rows = $DB->select($query);
							$num = $DB->affected();

							$html .= '<form name="order" method="post" action="">';
							$html .= '<input type="hidden" name="mailit" value="J">';
							$html .= '<table border="0" cellspacing="3" cellpadding="0" width="100%">';
							
							if ($SPRACHE == "de") {
							    $html .= '<tr><td colspan="5"><h2 class="title_order_send">Folgendes Informationsmaterial:</h2><ul class="order_send--list py-4">';
							}
							if ($SPRACHE == "en") {
							    $html .= '<tr><td colspan="5"><h2 class="title_order_send">Your selection:</h2><ul class="order_send--list py-4">';
							}
				            
							$i = 1; 
							foreach($rows as $row)
							{

							  $html .= '<input type="hidden" name="send_'.$i.'" value="'.$row["o_news_headline"].' - '.$row["o_news_subline"].'">';
							  $html .= '<li>'.$row["c_cat_name"].': '.$row["o_news_headline"].' - '.$row["o_news_subline"].'</li>';
				              $i++;
							  $name = $row["n_user_name"];
							  $name2 = $row["n_user_name2"];
							  $strasse = $row["n_user_street"];
							  $plz = $row["n_user_zip"];
							  $ort = $row["n_user_ort"];
							}

							$html .= '</ul></td></tr><tr><td colspan="5" align="left">';
							if ($SPRACHE == "de") $html .= '<p class="text__send">wird an Kundennummer: '.$KUNDENNUMMER.'</p><br>';
							if ($SPRACHE == "en") $html .= '<p class="text__send">Your customer number: '.$KUNDENNUMMER.'</p><br>';
							$html .= '<input type="hidden" name="kundennummer" value="'.$KUNDENNUMMER.'">
								  <input type="text" name="name" class="form-control rounded-0 shadow-none border-start-0 mt-0" value="'.$name.'"><br>
								  <input type="text" name="name2" class="form-control rounded-0 shadow-none border-start-0 mt-0" value="'.$name2.'"><br>
								  <input type="text" name="strasse" class="form-control rounded-0 shadow-none border-start-0 mt-0" value="'.$strasse.'"><br>
								  <input type="text" class="rounded-0 shadow-none border-start-0 mt-0" name="plz" value="'.$plz.'" size="5"><input type="text" class="rounded-0 shadow-none border-start-0 mt-0" name="ort" value="'.$ort.'"><br>';
								  if ($SPRACHE == "de") $html .= '<p class="text__send pt-md-3">versendet.</p>';
							$html .='<input type="submit" id="send_button" class="mt-3" value="'.$btnSend.'">
								 ';

							$html .= '</td></tr></table></form>';
				$html .= '			';

			}


                        
                        }
						$html .=' </div>

                <div class="clr"></div>

            </div>

        </div>
    </div>
</div>';

echo $html;
