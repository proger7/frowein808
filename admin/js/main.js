///////////////////////////////////////////////////
/////IMPORTANT!! INCLUDES THE MAIN FUNCTIONS!!////
/////////////////////////////////////////////////
document.writeln("<script language='JavaScript' type='text/javascript' src='"+URL_ROOT+"admin/js/functions.js'></script>");
///////////////////////////////////////////////

window.setInterval("zeitanzeige()",1000);
 
       function zeitanzeige(){
    	   if(document.getElementById("zeit")){
		        d = new Date ();
		 
		        h = (d.getHours () < 10 ? '0' + d.getHours () : d.getHours ());
		        m = (d.getMinutes () < 10 ? '0' + d.getMinutes () : d.getMinutes ());
		        s = (d.getSeconds () < 10 ? '0' + d.getSeconds () : d.getSeconds ());
		 
		        var wochentage = new Array ("Sonntag", "Montag", "Dienstag",
		        "Mittwoch", "Donnerstag", "Freitag", "Samstag");
		 
		        var monate = new Array ("Januar", "Februar", "März", "April",
		        "Mai", "Juni", "Juli", "August", "September",
		        "Oktober", "November", "Dezember");
		 
		        document.getElementById("zeit").innerHTML = d.getDate () + '. '
		        + monate[d.getMonth ()] + ' '
		        + d.getFullYear () +
		        ', '
		        + h + ':' + m + ':' + s + '';
    	   }
       }

function ajax_action(action,table,id,value){
	
    $.post(URL_ROOT + "admin/includes/ajax.php", { action: action, table : table, id : id, value : value},function(data) {
      location.reload();
	 
    });
    
}
function ajax_action_entity(action,table,id,value){
	
    $.post(URL_ROOT + "admin/includes/ajax.php", { action: action, table : table, id : id, value : value},function(data) {
      
	 
    });
    
}

function delete_mass(table){	
    //to_del = check2array("marked");
	var counter = 0;
	$("input[name='marked[]']:checked").each(function() {
		counter = counter +1;
		$.post(URL_ROOT + "admin/includes/ajax.php", { action: "delete_mass", table : table, to_del : $(this).val()},function(data) {
		
		
    });
    });	
	$( document ).ajaxStop(function() {
	if($("input[name='marked[]']:checked").length==counter)
			location.reload();
	});
}

$(document).ready(function(){
//	$("select,input,button,.button").uniform();
    $(".sub").css('display', 'none');
    $("."+$(".active_modul").attr("id")).css('display', 'table-cell');
    var $inputControl = $(".labelinside>input, .labelinside>textarea");
    $inputControl.each(function (index, domElement) { 
        /*@cc_on if (document.documentMode && document.documentMode >= 8) @*/ 
        if ($(this).parent().css("display") == "inline") $(this).parent().css("display", "inline-block"); 
        if (!$(this).val()) $(this).parent().children("label").show(); 
    });
    $inputControl.bind("focus", function(event) { 
        $(this).parent().children("label").hide(); }); 
    $inputControl.bind("blur", function(event) { 
        if (!$(this).val()) $(this).parent().children("label").show(); 
    });
    $(".modul_nav").click(function(){
        if( $(this).hasClass("navigation") && !$(this).hasClass("active")) {
            $(".navigation").removeClass("active");
            $(this).addClass("active");
            $(".sub").css('display', 'none');
            $("."+$(this).attr("id")).css('display', 'table-cell');
        }
        else if ( $(this).hasClass("navigation") && $(this).hasClass("active")){
            $(this).removeClass("active");
            $("."+$(this).attr("id")).css('display', 'none');
        }
        else{
            window.location = $(this).attr("file");
        }
    });

    $("#cancel_button").click(function(event) {
        event.preventDefault();
        window.location = $(this).attr("back");
    });
    
    $('#tableListing_length select').change(function(){
    	$('#tableListing_length form').submit();
    });
    
    $('.show-visit').click(function(){
        var id = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: URL_ROOT+'admin/ajax/view_statistic.php',
            data: {id_cust:id},
            success: function(data){
                Shadowbox.open({
                    content: data,
                    player: "html",
                    height: 548,
                    width: 600,
                    options: {
                    }
		});
		return false;
            }
        });
    });
    
    
});

function confirmRequest(slot_id, block_id, user_name, user_id){
					var str = '<div class="answer_div"><textarea name="answ_text'+slot_id+'" id="answ_text'+slot_id+'">Gerne bestätigen wir den Termin. Wir freuen uns auf dieses Gespräch. MfG '+user_name+'</textarea><br /><br /><input type="hidden" name="slot_answer_id" id="slot_answer_id" value='+slot_id+'><input type="button" name="send_answer'+slot_id+'" id="send_answer'+slot_id+'" value="SEND" class="answerBtn" onClick=sendAnswer('+slot_id+','+block_id+','+user_id+')></div>';		
						Shadowbox.open({
							content: 	str,
							player:     'html',
							title:      'Send answer',
							height:     300,
							width:      400
						});			
					
				}
				
				
	function sendAnswer(slot_id, block_id, user_admin_id){
		
		var a_text = $("#answ_text"+slot_id).val();
		var data = "confirm_request_admin=true&slot_id="+slot_id+"&answer_text="+a_text+"&user_admin_id="+user_admin_id;
			$.ajax({
				type : "POST",
				url : "/actions.php",
				data : data,
				success : function(result) {
					if(result){ 
						$("#block_confirm_"+block_id).remove();
						$("#block_discard_"+block_id).remove();
						$("#"+block_id).removeClass("requested").addClass("confirmed");
						Shadowbox.close();
					}
				},
				error:  function(xhr, str){
					alert("Error: " + xhr.responseCode);
					}
				});
		
	}
				
				function discardRequest(slot_id, block_id, user_discard_id, event_discard_id, partner_discarded){
					var data = "discard_request=true&slot_id="+slot_id+"&user_discard_id="+user_discard_id+"&event_discard_id="+event_discard_id+"&partner_discarded="+partner_discarded;
					var slot_id = $("#selected_slot").val();
					$.ajax({
						type : "POST",
						url : "/actions.php",
						data : data,
						success : function(result) {
							if(result){ 
								$("#block_confirm_"+block_id).remove();
								$("#block_discard_"+block_id).remove();
								$("#"+block_id).find(".firma").html("Gesprächspartner auswählen");
								$("#"+block_id).removeClass("requested");
								$("#"+block_id).removeClass("confirmed");
								$("#block_"+block_id).remove();
								$("#"+block_id).parent().append('<div class="block_slot" id="block_'+block_id+' title="Click to block slot" onClick=blockSlot('+slot_id+','+block_id+')></div>');
							}
						},
						error:  function(xhr, str){
							alert("Error: " + xhr.responseCode);
						}
					});
				}
	
	
	var main = function() { //главная функция
 
    $('.icon-menu').click(function() { /* выбираем класс icon-menu и
               добавляем метод click с функцией, вызываемой при клике */
		$('.icon-menu').hide();
		$('.icon-close').show('slow');
        $('.hidden-menu').animate({ //выбираем класс menu и метод animate
 
            left: '0px' /* теперь при клике по иконке, меню, скрытое за
               левой границей на 285px, изменит свое положение на 0px и станет видимым */
 
        }, 200); //скорость движения меню в мс
         
        $('body').animate({ //выбираем тег body и метод animate
 
            left: '290px' /* чтобы всё содержимое также сдвигалось вправо
               при открытии меню, установим ему положение 285px */
 
        }, 200); //скорость движения меню в мс
	
    });
 
 
/* Закрытие меню */
 
    $('.icon-close').click(function() { //выбираем класс icon-close и метод click
 	$('.icon-close').hide();
 	$('.icon-menu').show('slow');
        $('.hidden-menu').animate({ //выбираем класс menu и метод animate
 
            left: '-290px' /* при клике на крестик меню вернется назад в свое
               положение и скроется */
 
        }, 200); //скорость движения меню в мс
         
    $('body').animate({ //выбираем тег body и метод animate
 
            left: '0px' //а содержимое страницы снова вернется в положение 0px
 
        }, 200); //скорость движения меню в мс
    });
};
 
$(document).ready(main);
