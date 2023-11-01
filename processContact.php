<?php

require("includes/general.inc.php");

$PKEY = $_POST["PKEY"];
if(!isset($PKEY) || strlen($PKEY) != 5){$PKEY="";
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('.international_adress').show();
			});
		</script>
		<?php
}
if( isset($PKEY) && $PKEY != "" ) {
	$prow = $DB->query_fetch("select vertreter_rel_id from vertreter_plz_relation where vertreter_plz_start <= '".$PKEY."' and vertreter_plz_end >= '".$PKEY."'");
	$pnum = $DB->affected();
	$query = "select * from vertreter_text where vertreter_id='".$prow["vertreter_rel_id"]."'";
	$rows = $DB->select($query);
	$num = $DB->affected();
	if($num > 0) {

		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('.international_adress').hide();
			});
		</script>
		<?php

		foreach($rows as $row) {

			$html1 .= '<table class="table table-borderless kontakt__item-col">';
			    if($row["vertreter_name"] != ""){$html1 .= '<tr>
			         <td width="6%" class="px-0">
			            <p class="text-left mb-0"></p>
			         </td>
			         <td>
			            <p class="k-name mb-0">'.$row["vertreter_name"].'</p>
			         </td>
			      </tr>';}
			    if($row["vertreter_firma"] != ""){$html1 .= '<tr>
			         <td class="px-0">
			            <p class="text-left mb-0"></p>
			         </td>
			         <td>
			            <p class="k-firma mb-0">'.$row["vertreter_firma"].'</p>
			         </td>
			      </tr>';}
			    if($row["vertreter_strasse"] != "" || $row["vertreter_ort"]) {$html1 .= '<tr>
			         <td class="px-0">
			            <p class="text-left mb-0"><img src="/images/svg/contact/kicon1.svg" class="img-fluid"></p>
			         </td>
			         <td>
			            <p class="k-address mb-0">'.$row["vertreter_strasse"].'<br>'.$row["vertreter_ort"].'</p>
			         </td>
			      </tr>';}


			    if($row["vertreter_telefon"] != ""){$html1 .= '<tr>
			         <td class="px-0">
			            <p class="text-left mb-0"><img src="/images/svg/contact/kicon2.svg" class="img-fluid"></p>
			         </td>
			         <td>
			            <a class="k-telephone" href="tel:'.$row["vertreter_telefon"].'">'.$row["vertreter_telefon"].'</a>
			         </td>
			      </tr>';}
			    // if($row["vertreter_fax"] != ""){$html1 .= '<tr>
			    //      <td class="px-0">
			    //         <p class="text-left mb-0"><img src="/images/svg/contact/kicon3.svg" class="img-fluid"></p>
			    //      </td>
			    //      <td>
			    //         <a class="k-fax" href="fax:'.$row["vertreter_fax"].'">'.$row["vertreter_fax"].'</a>
			    //      </td>
			    //   </tr>';}
			    if($row["vertreter_mail"] != ""){$html1 .= '<tr>
			         <td class="px-0">
			            <p class="text-left mb-0"><img src="/images/svg/contact/kicon4.svg" class="img-fluid"></p>
			         </td>
			         <td>
			            <a class="k-email" href="mailto:'.$row["vertreter_mail"].'">'.$row["vertreter_mail"].'</a>
			         </td>
			      </tr>';}
			    if($row["vertreter_url"] != ""){$html1 .= '<tr>
			         <td class="px-0" id="siteIcon">
			            <p class="text-left mb-0"><img src="/images/svg/contact/kicon5.svg" class="img-fluid"></p>
			         </td>
			         <td>
			            <a class="k-siteurl" target="_blank" href="//'.$row["vertreter_url"].'">'.$row["vertreter_url"].'</a>
			         </td>
			      </tr>';}

			$html1 .= '</table>';
			// $html1 .= '<table class="restbl" border="0" cellspacing="0" cellpadding="0" width="100%" >';
			// if($row["vertreter_name"] != ""){$html1 .= '<tr id="vertreter_name"><td><b>'.$row["vertreter_name"].'</b><br><br></td></tr>';}
			// if($row["vertreter_firma"] != ""){$html1 .= '<tr id="firma"><td><b>'.$row["vertreter_firma"].'</b><br></td></tr>';}
			// if($row["vertreter_strasse"] != ""){$html1 .= '<tr id="strasse"><td>'.$row["vertreter_strasse"].'</td></tr>';}
			// if($row["vertreter_ort"] != ""){$html1 .= '<tr id="vertreter_ort"><td>'.$row["vertreter_plz"].'&nbsp;'.$row["vertreter_ort"].'</td></tr>';}
			// if($row["vertreter_telefon"] != "" || $row["vertreter_fax"] != "" || $row["vertreter_mail"] != "" || $row["vertreter_url"] != "")
			// {
			// 	$html1 .= '<tr><td valign="top"><br>
			// 				<table border="0" cellspacing="0" cellpadding="0" >';
			// 	if($row["vertreter_telefon"]){$html1 .= '<tr><td>Telefon:&nbsp;</td><td><a href="tel:'.$row["vertreter_telefon"].'">'.$row["vertreter_telefon"].'</a></td></tr>';}
			// 	if($row["vertreter_fax"]){$html1 .= '<tr><td>Fax:&nbsp;</td><td><a href="fax:'.$row["vertreter_fax"].'">'.$row["vertreter_fax"].'</a></td></tr>';}
			// 	if($row["vertreter_mail"]){$html1 .= '<tr><td>EMail:&nbsp;</td><td><a href="mailto:'.$row["vertreter_mail"].'">'.$row["vertreter_mail"].'</a></td></tr>';}
			// 	if($row["vertreter_url"]){$html1 .= '<tr><td>Internet:&nbsp;</td><td><a href="https://'.$row["vertreter_url"].'" target="_blank">'.$row["vertreter_url"].'</a></td></tr>';}
			// 	$html1 .= '		</table>
			// 			</td>
			// 		</tr>
			// 		</table><br>';

			// }
		}
	}
	echo $html1;
}
?>