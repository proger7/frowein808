<?php

if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}

switch ($langLink) {
	case "de":
		$loginText = 'Ausgewählte Informationen und Dokumente stellen wir unseren Kunden gerne zur Verfügung. Mit Ihrem persönlichen Login finden Sie hier alle relevanten Informationen jederzeit aktuell und online.';
		$loginTitle = "ANMELDUNG";
		$label1 = "Bitte geben Sie Ihre Zugangsdaten ein:";
		$label2 = "Kundennumer";
		$label3 = "Passwort";
		$loginButton = "Anmeldung";
		$err1 = 'Bitte Kundennummer eingeben';
		$err2 = 'Bitte Passwort eingeben';
		$notvalid = "<h2 style='color:#e2001a;width:100%'>Bitte richtige Kundennummer oder Passwort eingeben.</h2>";
	break;
	case "en":
		$loginText = 'We are happy to make selected informations and documents available to our customers. With your personal login you will find all the relevant informations here, up-to-date and online at any time.';
		$loginTitle = "LOGIN";
		$label1 = "Please enter your login information:";
		$label2 = "Customer number";
		$label3 = "Password";
		$loginButton = "Login";
		$err1 = 'Please enter customer number';
		$err2 = 'Please enter password';
		$notvalid = "<h2 style='color:#e2001a;width:100%'>Please enter correct customer number or password.</h2>";
	break;
}



if ($_POST["logout"])
{
  unset ($_SESSION["_registry"]["frontend_user"]);
  echo '<script>window.location = "'.$URL_ROOT. $langLink .'/partner/";</script>';
}
if (isset($_SESSION["_registry"]["frontend_user"]["KUNDENNUMMER"]) && isset($_SESSION["_registry"]["frontend_user"]["PASSWORT"])){
        $KUNDENNUMMER = $_SESSION["_registry"]["frontend_user"]["KUNDENNUMMER"];
        $PASSWORT = $_SESSION["_registry"]["frontend_user"]["PASSWORT"];
}
if ($_POST["login"]) {

		  $row = $DB->query_fetch('SELECT kundennummer,user_pass FROM newsletter_users WHERE kundennummer="'.$_POST["kundennummer"].'" AND user_pass="'.$_POST["passwort"].'" AND status = 1 LIMIT 1;');

		  $num = $DB->affected();
		  if (!empty($num))
		  {
		        $_SESSION["_registry"]["frontend_user"]["KUNDENNUMMER"] = $row["kundennummer"];
		        $_SESSION["_registry"]["frontend_user"]["PASSWORT"] = $row["user_pass"];
		        $KUNDENNUMMER = $row["kundennummer"];
		        $PASSWORT = $row["user_pass"];
		        
		  }
		  else {
		  	$message = $notvalid;
		  	$error = 1;
		  }
 
}


if (!empty($KUNDENNUMMER) && !empty($PASSWORT)) {
	$numCheck = $DB->affected_query('SELECT kundennummer,user_pass FROM newsletter_users WHERE kundennummer="'.$KUNDENNUMMER.'" AND user_pass="'.$PASSWORT.'" AND status = 1 LIMIT 1;');

	if (!$numCheck) {
		unset ($_SESSION["_registry"]["frontend_user"]);
		echo '<script>window.location = "'.$URL_ROOT.'partner/";</script>';
		exit;
	}

	$SPRACHE = $LANG["language"]["shortname"];

	if ($content[2]){
	    include("content/partner/".$content[2].".php");
	} else {
		include("content/partner/main.php");
	}

} else {

	if ($error == 1)
	{
		if ($SPRACHE == "de")
			$additional = 'Anmeldedaten sind falsch!';
		elseif ($SPRACHE == "en")
			$additional = 'Wrong log in data!';
	}
	elseif ($additional == "new")
	{
		if ($SPRACHE == "de")
			$additional = "Das Passwort wurde geändert. Sie müssen sich neu einloggen.";
		elseif ($SPRACHE == "en")
			$additional = "You changed the password. Please log in again.";
	}
	else
		$additional = "&nbsp; ";

	if (isset($_SESSION["_registry"]["frontend_user"]["KUNDENNUMMER"])){}

	?>

	<div class="authorization__main-container pt-5">
		<div class="container pt-1 pb-5">
			<div class="row">
				<div class="col-md-6 col-sm-12 col-12 pe-modify-4">
					<h2 class="auth__title">PARTNER-NET</h2>
					<p class="auth__content pt-md-4"><?php echo $loginText; ?></p>
				</div>
				<div class="col-md-6 col-sm-12 col-12 ps-modify-6">
					<h2 class="auth__title"><?php echo $loginTitle; ?></h2>

					<div class="contactMessage">
						<?php echo $message;?>
					</div>

					<p class="auth__content pt-md-4 mb-0"><?php echo $label1; ?></p>
					<form action="" method="POST" name="login" class="auth__form needs-validation" novalidate>
						<input type="hidden" name="login" value="y">
						<input type="hidden" name="active" value="8">
						<div class="ts">
					  		<span class="nLabel"><?php echo $label2; ?>*</span>
							<div class="input-group flex-nowrap mb-0" style="position: relative;">
								<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/icons-new/number.svg"></span>
								<input type="text" class="form-control rounded-0 shadow-none border-start-0 mt-0" name="kundennummer" required>
								<div class="invalid-feedback" style="position: absolute;bottom: -27px;">
									<?php echo $err1; ?>
								</div>
							</div>

						</div>	
						<div class="ts">
					  		<span class="nLabel"><?php echo $label3; ?>*</span>
							<div class="input-group flex-nowrap mb-0" style="position: relative;">
								<span class="input-group-text rounded-0 shadow-none bg-body border-end-0" id="addonIcon"><img src="/images/icons-new/passwortsvg.svg"></span>
								<input type="password" class="form-control rounded-0 shadow-none border-start-0 mt-0" id="password" name="passwort" required>
								<span onclick="password_show_hide();" class="posHideFunction">
									<i class="fas fa-eye" id="show_eye"></i>
									<i class="fas fa-eye-slash d-none" id="hide_eye"></i>
								</span>
								<div class="invalid-feedback" style="position: absolute;bottom: -27px;">
									<?php echo $err2; ?>
								</div>
							</div>
						</div>


						<div class="ts ts-center pt-5">
							<input type="submit" name="auth-success" value="<?php echo $loginButton; ?>">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<?php } ?>


<?php
if( ($content[1] == 'partner') && $content[2] && is_numeric($content[2]) ) { ?>
	<?php include("content/partner/main.php"); ?>
<?php } ?>

