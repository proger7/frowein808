<?php
$getUserName = $DB->query_fetch('SELECT user_name FROM newsletter_users WHERE kundennummer="'.$KUNDENNUMMER.'" AND user_pass="'.$PASSWORT.'" AND status = 1 LIMIT 1;');
$row = $DB->query_fetch('SELECT * FROM newsletter_users WHERE kundennummer = '.$KUNDENNUMMER.'');

if($content[0] == "de" || $content[0] == "") {
  $langLink = 'de';
} elseif($content[0] == "en") {
  $langLink = 'en';
}

switch ($langLink) {
  case "de":
  	$button1 = "Aktualisieren";
  	$button2 = "Absagen";

  	$pdb1 = "BENUTZERNAME";
  	$pdb2 = "NACHNAME";
  	$pdb3 = "PASSWORT";

  	$ab1 = "Die Außenseite";
  	$ab2 = "STADT";
  	$ab3 = "POSTLEITZAHL";
  	$ab4 = "LAND";

  	$pd1 = "Zur Person";
  	$pd2 = "Adresse";
  	$gi1 = "Kundennummer";
  	$gi2 = "Benutzername";
  	$gi3 = "Nachname";
	$title1 = "Allgemeine Information";
	$title2 = "Persönliche Daten";
    $selectlang = 1;
    $startpage = 'Startseite';
    $item1 = 'Allgemein';
    $item2 = 'Produktübersicht';
    $item3 = 'Informationsmaterial';
    $item4 = 'Persönliche Daten';
    $logAsName = 'Angemeldet als';
    $logout = 'Ausloggen';
    $value = "Bestellen";
  break;
  case "en":
  	$button1 = "Update";
  	$button2 = "Cancel";

  	$pdb1 = "USER NAME";
  	$pdb2 = "LAST NAME";
  	$pdb3 = "PASSWORD";

  	$ab1 = "THE OUTSIDE";
  	$ab2 = "CITY";
  	$ab3 = "POST CODE";
  	$ab4 = "LAND";

  	$pd1 = "To person";
  	$pd2 = "Address";
  	$gi1 = "Customer number";
  	$gi2 = "User name";
  	$gi3 = "Surname";
	$title1 = "General information";
	$title2 = "Personal data";
    $selectlang = 2;
    $startpage = 'Home';
    $item1 = 'General';
    $item2 = 'Product overview';
    $item3 = 'Information material';
    $item4 = 'Personal data';
    $logAsName = 'Logged in as';
    $logout = 'Log out';
    $value = "order";
  break;
}

?>
<div class="breadcrumbs py-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="container">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="/<?php echo $langLink; ?>/"><?php echo $startpage; ?></a></li>
        <li class="breadcrumb-item active" aria-current="page">PARTNER-NET</li>
      </ol>
    </nav>
</div>
<nav class="navbar navbar-expand-lg pt-0">
   <div class="container">
      <div class="collapse navbar-collapse border-bottom" id="navbarText">
         <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item menu-item-1 me-1">
               <a class="nav-link" aria-current="page" href="/<?php echo $langLink; ?>/partner/"><?php echo $item1; ?></a>
            </li>
            <li class="nav-item menu-item-2 me-1">
               <a class="nav-link" href="/<?php echo $langLink; ?>/partner/downloads/"><?php echo $item2; ?></a>
            </li>
            <li class="nav-item menu-item-3 me-1">
               <a class="nav-link" href="/<?php echo $langLink; ?>/partner/order/"><?php echo $item3; ?></a>
            </li>
            <li class="nav-item menu-item-4 me-1">
               <a class="nav-link active" href="/<?php echo $langLink; ?>/partner/pers_daten/"><?php echo $item4; ?></a>
            </li>
         </ul>
         <span class="navbar-text border-start" id="formLogout">
		    <nav style="--bs-breadcrumb-divider: '|';" aria-label="/?logout" class="container logout__block">
		      <ol class="breadcrumb">
		      	<li class="breadcrumb-item" aria-current="page"><?php echo $logAsName; ?> <b><?php echo $getUserName['user_name'];?></b></li>
		        <li class="breadcrumb-item">
		        	<form action="" method="POST" class="mb-0 needs-validation" novalidate>
		        		<input type="hidden" name="logout" value="y">
		        		<input type="submit" name="slogout" value="<?php echo $logout; ?>">
		        	</form>
		        </li>
		      </ol>
		    </nav>
         </span>
      </div>
   </div>
</nav>
<div class="container pt-5">
	<h2 class="personal-title pb-4 mb-0"><?php echo $title1; ?></h2>
	<form action="" method="POST" class="personal_data-form container pb-5">

		<?php if( !empty($row['kundennummer']) ):?>
		<div class="row border-personal d-flex align-items-center py-2">
			<div class="col">
				<label for="inputUserId" class="form-label p-input_userid mb-0 ps-3"><?php echo $gi1; ?>:</label>
			</div>
			<div class="col-auto">
				<input type="text" readonly name="puserid" class="form-control-plaintext ps-3" id="inputUserId" value="<?php echo $row["kundennummer"];?>">
			</div>
			<div class="col">
				<a class="p-edit float-end pe-5 me-2 visually-hidden">bearbeiten</a>
			</div>
		</div>
		<?php endif;?>

		<?php if( !empty($row['user_name']) ):?>
		<div class="row border-personal d-flex align-items-center py-2">
			<div class="col">
				<label for="inputUserName" class="form-label p-input_username mb-0 ps-3"><?php echo $gi2; ?>:</label>
			</div>
			<div class="col-auto">
				<input type="text" readonly name="pusername" class="form-control-plaintext ps-3" id="inputUserName" value="<?php echo $row["user_name"];?>">
			</div>
			<div class="col">
				<a class="p-edit float-end pe-5 me-2 visually-hidden">bearbeiten</a>
			</div>
		</div>
		<?php endif;?>

		<?php if( !empty($row['user_nachname']) ):?>
		<div class="row border-personal d-flex align-items-center py-2">
			<div class="col">
				<label for="inputName" class="form-label p-input_name mb-0 ps-3"><?php echo $gi3; ?>:</label>
			</div>
			<div class="col-auto">
				<input type="text" readonly name="pname" class="form-control-plaintext ps-3 inp-1" id="inputName" value="<?php echo $row["user_nachname"];?>">
			</div>
			<div class="col">

			</div>
		</div>
		<?php endif;?>

		<?php if( !empty($row['user_email']) ):?>
		<div class="row border-personal d-flex align-items-center py-2">
			<div class="col">
				<label for="inputEmail" class="form-label p-input_email mb-0 ps-3">Email:</label>
			</div>
			<div class="col-auto">
				<input type="email" readonly name="pemail" class="form-control-plaintext ps-3 inp-3" id="inputEmail" value="<?php echo $row["user_email"];?>">
			</div>
			<div class="col">

			</div>
		</div>
		<?php endif;?>

	</form>
	<h2 class="personal-title"><?php echo $title2; ?></h2>
	<div class="content_personal-data">
	   <button class="pos-button pos-button--link pos-button--icon-left a-only-small" onclick="var win = this.ownerDocument.defaultView || this.ownerDocument.parentWindow; if (win == window) { window.location.href='/partner-personal-data'; } ;return false" data-webdriver-id="">
	      Zurück
	   </button>
	   <div class="links-menu a-mb-space-6 pt-4">
	      <div class="mb-4">
	         <div class="links-menu__link ps-4 pe-5 py-4" style="cursor:pointer" data-webdriver-id="" data-bs-toggle="modal" data-bs-target="#personalDataModal">
	            <div class="links-menu__link-content">
	               <div class="links-menu__link-header pb-1">
	                  <div class="links-menu__link-header-title"><?php echo $pd1; ?></div>
	               </div>
	               <div class="links-menu__link-body">
	                  <div>
	                     <div>
	                     	<?php if(!empty($row['user_anrede'])){ ?>
	                        	<span><?php echo $row['user_anrede'];?></span>
	                    	<?php } ?>
	                    	<?php if(!empty($row['user_nachname'])){ ?>
	                        	<span><?php echo $row['user_nachname'];?></span>
	                        <?php } ?>
	                        <?php if(!empty($row['user_name'])){ ?>
	                        	<span><?php echo $row['user_name'];?></span>
	                        <?php } ?>
	                     </div>
	                     <div>**.**.****</div>
	                  </div>
	               </div>
	            </div>
	            <div class="pos-svg icon icon--next-dims  links-menu__link-arrow">
	            	<img src="/images/partner/personal-data/arrowR.svg">
	            </div>
	         </div>
	      </div>

	      <div class="mb-4">
	         <div class="links-menu__link ps-4 pe-5 py-4" style="cursor:pointer" data-webdriver-id="" data-bs-toggle="modal" data-bs-target="#personalDataAddressModal">
	            <div class="links-menu__link-content">
	               <div class="links-menu__link-header pb-1">
	                  <div class="links-menu__link-header-title"><?php echo $pd2; ?></div>
	               </div>
	               <div class="links-menu__link-body">
	                  <div>
	                  	<?php if(!empty($row['user_street'])){ ?>
		                     <div>
		                        <span><?php echo $row['user_street'];?></span>
		                     </div>
	                 	<?php } ?>
	                 	<?php if(!empty($row['user_zip']) || !empty($row['user_ort'])){ ?>
		                     <div>
		                        <span><?php echo $row['user_zip'];?></span> <span><?php echo $row['user_ort'];?></span>
		                     </div>
	                     <?php } ?>
	                     <?php if(!empty($row['user_land'])){ ?>
	                     <div>
	                        <span><?php echo $row['user_land'];?></span>
	                     </div>
	                     <?php } ?>
	                  </div>
	               </div>
	            </div>
	            <div class="pos-svg icon icon--next-dims  links-menu__link-arrow">
	            	<img src="/images/partner/personal-data/arrowR.svg">
	            </div>
	         </div>
	      </div>
	   </div>
	</div>
</div>

<!-- Personal Data Modal -->
<div class="modal fade" id="personalDataModal" tabindex="-1" aria-labelledby="personalDataLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content px-5 py-2">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="personalDataLabel">Persönliche Daten bearbeiten</h5>
      </div>
      <div class="modal-body">
        <form action="/updatePersData1.php" method="POST" class="personalForm1 personalForm">

          <div class="mb-4 pBorder px-4 pt-1 pb-2">
            <label for="pName" class="col-form-label pLabel pb-0"><?php echo $pdb1; ?></label>
            <input type="text" name="pNameField" class="form-control no-border ps-0" id="pName" value="<?php echo $row['user_name'] ?>">
          </div>
          <div class="mb-4 pBorder px-4 pt-1 pb-2">
            <label for="pNachname" class="col-form-label pLabel pb-0"><?php echo $pdb2; ?></label>
            <input type="text" name="pNachnameField" class="form-control no-border ps-0" id="pNachname" value="<?php echo $row['user_nachname'] ?>">
          </div>
			<div class="mb-4 pBorder px-4 pt-1 pb-2">
				<label for="pPasswort" class="col-form-label pLabel pb-0"><?php echo $pdb3; ?></label>
				<div class="position-relative">
					<input type="password" name="personalPassw" class="form-control no-border ps-0" id="pPasswort" value="<?php echo $row['user_pass'] ?>">
					<span class="position-absolute top-0 end-0 d-flex h-100 justify-content-center">
						<img src="/images/partner/personal-data/passw-icon/eye.svg" class="c-image v-image-no">
						<img src="/images/partner/personal-data/passw-icon/view-icon.svg" class="c-image v-image1">
					</span>
				</div>
			</div>

			<div class="persFormMessage1"></div>
			<div class="border-0 m-auto pb-4 pt-4 text-center">
				<input type="submit" class="btn btn-primary pButton me-md-4" value="<?php echo $button1; ?>">
				<button type="button" class="btn btn-secondary pButtonWhite ms-md-3" data-bs-dismiss="modal"><?php echo $button2; ?></button>
			</div>

			
        </form>
      </div>

    </div>
  </div>
</div>

<!-- Personal Address Modal -->
<div class="modal fade" id="personalDataAddressModal" tabindex="-1" aria-labelledby="personalDataAddressLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content px-5 py-2">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="personalDataAddressLabel">Addresse bearbeiten</h5>
      </div>
      <div class="modal-body">
        <form action="/updatePersData2.php" method="POST" class="personalForm2 personalForm">
          <div class="mb-4 pBorder px-4 pt-1 pb-2">
            <label for="pOutside" class="col-form-label pLabel pb-0"><?php echo $ab1; ?></label>
            <input type="text" name="pStreet" class="form-control no-border ps-0" id="pOutside" value="<?php echo $row['user_street'] ?>">
          </div>
          <div class="mb-4 pBorder px-4 pt-1 pb-2">
            <label for="pCity" class="col-form-label pLabel pb-0"><?php echo $ab2; ?></label>
            <input type="text" name="pCity" class="form-control no-border ps-0" id="pCity" value="<?php echo $row['user_ort'] ?>">
          </div>
          <div class="mb-4 pBorder px-4 pt-1 pb-2">
            <label for="pZip" class="col-form-label pLabel pb-0"><?php echo $ab3; ?></label>
            <input type="text" name="pZip" class="form-control no-border ps-0" id="pZip" value="<?php echo $row['user_zip'] ?>">
          </div>
          <div class="mb-4 pBorder px-4 pt-1 pb-2">
            <label for="pLand" class="col-form-label pLabel pb-0"><?php echo $ab4; ?></label>
            <input type="text" name="pLand" class="form-control no-border ps-0" id="pLand" value="<?php echo $row['user_land'] ?>">
          </div>

			<div class="persFormMessage2"></div>
			<div class="border-0 m-auto pb-4 pt-4 text-center">
				<input type="submit" class="btn btn-primary pButton me-md-4" value="<?php echo $button1; ?>">
				<button type="button" class="btn btn-secondary pButtonWhite ms-md-3" data-bs-dismiss="modal"><?php echo $button2; ?></button>
			</div>

        </form>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(function(){


		// PERSONAL FORM 1
		$(".personalForm1").submit(function(e) {
		    e.preventDefault();

		    var form = $(this);
		    console.log(form);
		    var actionUrl = form.attr('action');
		    
		    $.ajax({
		        type: "POST",
		        url: actionUrl,
		        data: form.serialize(),
		        success: function(data)
		        {
		        	if(data) {
		        		$('.persFormMessage1').html(data);
		        	}
		        }
		    });
		});
		// PERSONAL FORM 2
		$(".personalForm2").submit(function(e) {
		    e.preventDefault();

		    var form = $(this);
		    console.log(form);
		    var actionUrl = form.attr('action');
		    
		    $.ajax({
		        type: "POST",
		        url: actionUrl,
		        data: form.serialize(),
		        success: function(data)
		        {
		        	if(data) {
		        		$('.persFormMessage2').html(data);
		        	}
		        }
		    });
		});


		  var vtype = $('#pPasswort').attr("type");
		  $('.v-image1').hide();

		  $(".v-image-no").on('click', function() {
			if(vtype == "text") {
				$('#pPasswort').attr('type', 'password');
				$('.v-image1').hide();
				$('.v-image-no').show();

			} else if(vtype == "password") {
				$('#pPasswort').attr('type', 'text');
				$('.v-image1').show();
				$('.v-image-no').hide();
			}
		  });

		  $(".v-image1").on('click', function() {
			if(vtype == "text") {
				$('#pPasswort').attr('type', 'text');
				$('.v-image1').show();
				$('.v-image-no').hide();

			} else if(vtype == "password") {
				$('#pPasswort').attr('type', 'password');
				$('.v-image1').hide();
				$('.v-image-no').show();
			}
		  });

		  $('#pDate').datepicker({
		  	format: 'dd.mm.yyyy',
		  	autoclose: true,
		  });
		});
	});
</script>