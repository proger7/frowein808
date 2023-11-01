<?php
include_once 'includes/classes/modul.class.php';
class newsl_modul extends modul{   
    function __construct(){
        $this->init();
        $this->path             = pathinfo(__FILE__,PATHINFO_DIRNAME)."/";
        $this->lang["module"]   = parse_ini_file( $this->path."localisation/de.ini");
        $this->table            = "newsletter_letters";
		$this->config			= parse_ini_file( $this->path."modul.ini");
		$this->permission		= $this->config["permission"];
    }


    public function getButton_Preview($row){
        $button = ' </div><img src="'.$this->base_url.'admin/img/button_search.png" alt="Preview" width="16px" height="16px" style="cursor:pointer;" id="preview_'.$row["id"].'">
                   <script>
                    $("#preview_'.$row["id"].'").click(function(){
                        $.post("https://frowein808.de/admin/includes/ajax.php",{ action: "preview_news", id: "'.$row["id"].'" }, function(data) {
							Shadowbox.open({
								content: 	data,
								player:     "html",
								title:      "",
								height:     500,
								width:      750,
								options: { 
									modal:   true, 
								}
							});
                        });
                    });
                    </script>';

        return $button;
    }
	public function save_file($id,$field, $table){
                if (!is_dir($this->base_root."admin/tmp"))  {
                    $this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/");
                    $this->ftp->makeDir("tmp");
                    $this->ftp->chmod("tmp",0777);
                }
                if ($_FILES['save']['tmp_name'][$field[2]] != ""){
                        $ext=substr($_FILES['save']['name'][$field[2]] ,-3);
                        $ext2=substr($_FILES['save']['name'][$field[2]] ,-4);
                        if ($ext2[0]!=".")  $ext=$ext2;
                        $ext = ".".$ext;
                        $ext=strtolower($ext);
                        $time = microtime(true) * 100;
                        move_uploaded_file($_FILES['save']['tmp_name'][$field[2]],$this->base_root."admin/tmp/".$time.".tmp");
                        $this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
                        $this->ftp->upload($this->base_root."admin/tmp/".$time.".tmp",  $_FILES['save']['name'][$field[2]], 'auto', 0 );
                        $this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."admin/");
                        $this->ftp->removeDir("tmp",1);
                        $old_file = $this->db->query_fetch_single("SELECT ".$field[2]." FROM ".$table." WHERE id=".$id." LIMIT 1;");
                        $this->ftp->changeDir($_SESSION["_registry"]["ftp_config"]["self"]["root"]."uploads/");
                        if (is_file($this->base_root."uploads/".$old_img[0])) $this->ftp->delete($old_file);
                        return $_FILES['save']['name'][$field[2]];
                    }
    }


   protected function getField_StatusSend($field,$row){
        switch ($row[$field[2]]){
            case 0: $status .= 'nicht gesendet'; break;
            case 1: $status .= 'nicht gesendet'; break;
            case 2: $status .= 'gesendet'; break;
        }
        return $status;
    }

    public function getButton_Send($row){
        $button = ' </div><img src="'.$this->base_url.'admin/img/email-icon.png" alt="Senden" width="16px" height="16px" style="cursor:pointer;" id="send_'.$row["id"].'">
                   <script>
                    $("#send_'.$row["id"].'").click(function(){
                        $.post("'.$this->base_url.'/admin/includes/ajax.php",{ action: "send_news", id: "'.$row["id"].'" }, function(data) {
						alert(data);
                        //location.reload(true);
                        });
                    });
                    </script>';

        return $button;
    }
	    public function getEditField_Html($id,$field,$entity){
    	global $URL_ROOT,$DIR_ROOT;
    	$html = '
    			<textarea style="" id="text_'.$field[2].'" name="save['.$field[2].']">'.stripslashes($entity[$field[2]]).'</textarea>';
    	$html.='<script type="text/javascript">
    					tinyMCE.init({
    					        mode : "exact",
            					elements : "ajaxfilemanager,text_'.$field[2].'",
    					        theme : "advanced",
    					        plugins : "autolink,lists,style,table,advhr,advimage,advlink,inlinepopups,preview,media,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
    							apply_source_formatting : true,
    					        // Theme options//
    					        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,styleselect",
    					        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,preview,|,forecolor,backcolor",
    					        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,fullscreen",
    					        //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
    					        theme_advanced_toolbar_location : "top",
    					        theme_advanced_toolbar_align : "left",
    					        theme_advanced_statusbar_location : "none",
    					        theme_advanced_resizing : false,
    					        theme_advanced_path : false,
    							theme_advanced_font_sizes: "1em,1.2em,1.4em,1.6em,2.4em",
    					        theme_advanced_fonts : 	"Arial=arial,helvetica,sans-serif;"+
    									                "Arial Black=arial black,avant garde;"+
    									                "Courier New=courier new,courier;"+
    									                "Helvetica=helvetica;"+
    									                "Tahoma=tahoma,arial,helvetica,sans-serif;"+
    									                "Terminal=terminal,monaco;"+
    									                "Times New Roman=times new roman,times;"+
    									                "Verdana=verdana,geneva;",
    							theme_advanced_blockformats : "h1,h2,h3,h4,h5,h6,p,div,code",
    							font_size_style_values : "1em,1.2em,1.4em,1.6em,2.4em",
    							file_browser_callback : "ajaxfilemanager",
    							force_br_newlines : true,
    							force_p_newlines : false,
    							relative_urls : false,
    							remove_script_host : true,
    							document_base_url : "'.$URL_ROOT.'"
    					});
    					function ajaxfilemanager(field_name, url, type, win) {
    						var ajaxfilemanagerurl = "/admin/js/tinymce/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
    						switch (type) {
    							case "image":
    								break;
    							case "media":
    								break;
    							case "flash":
    								break;
    							case "file":
    								break;
    							default:
    								return false;
    						}
    						tinyMCE.activeEditor.windowManager.open({
    						  file: ajaxfilemanagerurl,
    						  width: 820, 
    						  height: 500,
    						  resizable: "yes",
    						  scrollbars: "yes",
    						  inline: "no",
    						  close_previous: "no",
    						},{
    						  window : win,
    						  input : field_name,
    						  resizable : "yes",
    						  inline: "no",
    						  editor_id : tinyMCE.selectedInstance.editorId
    						});
    					
    						return false;
    					}
    				</script>';
    	return $html;
    }
}
?>
