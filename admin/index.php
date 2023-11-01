<?php

date_default_timezone_set('Europe/Berlin');

 

require_once "includes/general.inc.php";
?>

<?php
$css_files = array  (
					   "//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css",
                        $URL_ROOT."admin/js/shadowbox/shadowbox.css",
						$URL_ROOT."admin/js/colorpicker/css/colorpicker.css",
                    //    $URL_ROOT."admin/js/datatables/css/demo_table_jui.css",
						//$URL_ROOT."admin/js/pixelmatrix-uniform/themes/aristo/css/uniform.aristo.css",
                     //   $URL_ROOT."admin/css/main.css",
						"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css",
                       // $URL_ROOT."admin/css/overcast.css",
                        $URL_ROOT."admin/js/jquery-ui/css/start/jquery-ui-1.10.2.custom.css",
                        $URL_ROOT."admin/css/demo.css",
                        $URL_ROOT."admin/css/main.css",
                        $URL_ROOT."admin/css/style.css",
                        $URL_ROOT."admin/css/jquery.tagsinput.css",
                        $URL_ROOT."admin/css/selectize/selectize.bootstrap5.css",
                    );
$js_files = array   (
                        //"//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js",
                        //$URL_ROOT."admin/js/new/jquery-1-7-2.js",
                        $URL_ROOT."admin/js/jquery-1.9.1.js",
						//$URL_ROOT."admin/js/new/jquery-ui.min.js",
    $URL_ROOT."admin/js/jquery-ui-1.10.3.custom.js",
    $URL_ROOT."admin/js/bootstrap.min.js",
						$URL_ROOT."admin/js/validator/jquery.validate.js",
						$URL_ROOT."admin/js/validator/additional-methods.js",
                        $URL_ROOT."admin/js/shadowbox/shadowbox.js",
                        //"https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js",
    $URL_ROOT."/admin/js/sceditor_full/ckeditor.js",
                        $URL_ROOT."admin/js/colorpicker/js/colorpicker.js",
                        $URL_ROOT."admin/js/colorpicker/js/eye.js",
                        $URL_ROOT."admin/js/colorpicker/js/utils.js",
                        $URL_ROOT."admin/js/colorpicker/js/colorpicker.js",
						"//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js",
						$URL_ROOT."admin/js/main.js", 
                        $URL_ROOT."admin/js/jquery.tagsinput.js",
                        $URL_ROOT."admin/js/selectize/selectize.js", 
                        $URL_ROOT."admin/js/add-tags-selectize.js", 

                        $URL_ROOT."admin/js/add-tags-news.js", 
						// $URL_ROOT."admin/js/bonsai.js",
                        
                    );
					

$page_title = "Mac5 Admin";
require_once 'header.php';
//echo $_SESSION['_registry']['site_id'];
$rules = array();
$auth = new auth();

if ($_SESSION["_registry"]["user"]['name'] && $_SESSION["_registry"]["user"]['pass']){
    if ($auth->check($_SESSION["_registry"]["user"]['name'],$_SESSION["_registry"]["user"]['pass'], $_SESSION['_registry']['site_id'])){
        include "includes/backend.php";     
    }
    else{
        $auth->print_login_form();
        }
}
elseif($_POST["login"]){
    if ($_POST["user"] && $_POST["pass"]){
        $auth->login($_POST["user"],$_POST["pass"]); 
    }
    else{$auth->print_login_form($lang["backend"]["fillboth"]);}
}
else{
    if("https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] != $_SESSION["_registry"]["system_config"]["site"]["base_url"]."admin/"){
     //   echo '<script type="text/javascript">window.location="'.$_SESSION["_registry"]["system_config"]["site"]["base_url"].'admin/"; </script>';
    }
    echo $auth->print_login_form();}
require_once 'footer.php';
?>
