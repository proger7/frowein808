jQuery(document).ready(function($) {

    $('#choose').change(function(event) {
         $("#" + this.value).show().siblings().hide();
         jQuery('#siteIcon').show();


         var full_url = window.location.pathname;
         var rest = full_url.split('/');
         var l = rest.length - 1; 
         var subUrl = rest[rest.length - l];


         if(subUrl == 'de') {
            var title1 = 'Ihre Ansprechpartner im innendienst';
            var countryGermany = 'DEUTSCHLAND';
            var text1 = "<p class='uppTitle'>IHRE ANSPRCHPARTNER</p>";
            var text2 = "<p class='uppTitle visible'>Hinweis: Bitte klicken Sie auf das entsprechende Land um die Kontaktdaten zu erhalten</p>";
         } else if(subUrl == 'en') {
            var title1 = 'Your contacts in the office';
            var countryGermany = 'GERMANY';
            var text1 = "<p class='uppTitle'>YOUR CONTACT PERSONS</p>";
            var text2 = "<p class='uppTitle visible'>Note: Please click on the relevant country to get the contact details</p>";
         }

         jQuery('.changeWord').html(title1);


         jQuery('.contentMap .c__label-2').closest('.c__label-2').removeClass().addClass('c__label-2').addClass('flag-de');
         jQuery('.contentMap .c__label-2').html(countryGermany);
         jQuery('.contentMap .k-address').html('Frowein GmbH & Co. KG<br>Am Reislebach 83<br>D-72461 Albstadt');
         jQuery('.contentMap .k-telephone').html('+49 7432 956-0').attr('href', 'tel:+49 7432 956-0');
         jQuery('.contentMap .k-fax').html('+49 7432 956-138').attr('href', 'fax:+49 7432 956-138');
         jQuery('.contentMap .k-email').html('vertrieb@frowein808.de').attr('href', 'mailto:vertrieb@frowein808.de');
         jQuery('.contentMap .k-siteurl').html('www.frowein808.de').attr('href', 'https://www.frowein808.de/');
         $('.c__label-2').show();
         $('.additional_info').show();
         $(".uppTitle").hide();
         $(".colorTitle").hide();
         $('.psucheForm').css('display', 'block');

         if( this.value == 'map-DE' ) {
         	$('.contentMap').removeClass('invisible').addClass('visible');
         } else if( this.value == 'map-EU' ) {
            jQuery('.partner_address').html(text2);
            jQuery('.changeWord').html('Ihre Ansprchpartner im Ausland');
         	$('.contentMap').removeClass('visible').addClass('invisible');
            $('.psucheForm').css('display', 'none');
         } else if( this.value == 'map-WORLD' ) {
            jQuery('.changeWord').html('Vertrieb international');
            $('.contentMap').removeClass('invisible').addClass('visible');
            $('.c__label-2').hide();
            $('.additional_info').hide();
            $('.psucheForm').css('display', 'none');
            jQuery('.contentMap .k-address').html('Am Reislebach 83<br>D-72461 Albstadt');
            $(text1).insertBefore('.kontakt__item-col');
            $("<p class='colorTitle'>Frowein GmbH & Co. KG</p>").insertBefore('.kontakt__item-col');

         }
    });
    $('#choose').change();
});