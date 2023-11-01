<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<?php if($modul_temp['bingmap']=="true"){ ?>
		<script charset="UTF-8" type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.3"></script>
		<?php } ?>

		<script type="text/javascript"> var URL_ROOT = '<?php echo  $URL_ROOT;?>admin/';</script>

        <title><?php echo $page_title; ?></title>
        <?php foreach ($css_files as $css){?>
        <link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo $css; ?>" />  
        <?php } ?>
        <script type="text/javascript">var URL_ROOT = '<?php echo $URL_ROOT; ?>'; </script>
        <?php foreach ($js_files as $js){?>
        <script type="text/javascript" src="<?php echo $js; ?>"></script> 
        <?php } ?>

        <!--<link rel="shortcut icon" href="favicon.ico" type="image/ico">-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <script type="text/javascript">
            console.log(" url_root === "+ URL_ROOT);
        </script>
    </head>
    <body>

        