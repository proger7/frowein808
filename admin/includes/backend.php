<script type="text/javascript">
Shadowbox.init({
	skipsetup: true,
enableKeys: false 
});
</script>
 <div class="icon-close">
    <img src="/admin/img/close-btn.png">
 </div>
 
        <div class="icon-menu">
            <img src="/admin/img/menu-ham-icon.png">
            Menu
        </div>
<div class="container">
	<div class="header">
		<div class="row">
			<div class="col-lg-3 col-md-6 col-sm-12">
		
				
			</div>
			<div class="col-lg-4 text-right">
			</div>
			<div class="col-lg-5 text-right">
				<div id="user_field" class="ui-corner-all">
					<div id="info">
								<form id="logout" action="" method="post">
									<input type="hidden" name="logout" value="logout" />
									<input type="submit" value="Logout" class="btn btn-info" style="float:right;position:relative;z-index:999" />
								</form>
						<div id="zeit_div"><?php echo $REGISTRY["lang"]["backend"]["logged_as"]." "; ?><?php echo $_SESSION["_registry"]["user"]["name"]; ?> (<?php echo $_SESSION["_registry"]["user"]["group"]; ?>)<br />
								<span id="zeit"></span></div>
					</div>
				</div>
				<div class="clearfix"></div>
			 
				
				<div class="clearfix"></div>
				<div id="breadcrump">
					<p>
					<?php echo $REGISTRY["lang"]["backend"]["u_are_here"]." <a style='text-decoration:underline'>". $_SESSION['_registry']['recent_site_title']."</a> : ".$breacrump;?>
                        <img src="/office365/teams/frowein808-msteamslogo.png" id="logo" style="float: right;height: 40px;margin-left:30px">
					</p>


				</div>
			</div>
		</div>
	</div>
	
<div id="content">
    <div id="navigation">

		<div class="hidden-menu">
       <?php echo make_list($modules,$active_module); ?>
	   </div>
    </div>
    <div id="main">

    	<div class="col-lg-12">
	      <?php

	      if (isset($active_modul)) {
              include $active_modul;
          }
	      ?>
    	</div>
    </div>
</div>

<?php


function getCats($res){
   
    $levels = array();
    $tree = array();
    $cur = array();
   
    foreach($res as $rows){
       
        $cur = &$levels[$rows['id']];
        $cur['parent_id'] = $rows['parent_id'];
        $cur['title'] = $rows['title'];
       
        if($rows['parent_id'] == 0){
            $tree[$rows['id']] = &$cur;
        } else if($rows['id']==$_SESSION['_registry']['site_id']){
			  $tree[$rows['id']] = &$cur;
		}
        else{
            $levels[$rows['parent_id']]['children'][$rows['id']] = &$cur;
        }
       
    }
    return $tree;
   
}
function getTree($arr, $cnt){
   
    $out = '';
	if($cnt ==0 )
	$out .= '<ul class="levels_ul" id="auto-checkboxes" data-name="foo">';
	else
	$out .= '<ul class="levels_ul">';
    foreach($arr as $k=>$v){
		$style='';
       if($k ==1) $style = 'style="color:#fff"';
       // $out .= '<li><a href="?id='.$k.'">'.$v['title'].'</a></li>';
        $out .= '<li data-value="'.$k.'"><a href="?id='.$k.'" '.$style.'>'.$v['title'].'</a>';
        if(!empty($v['children'])){
            $out .= getTree($v['children'], 1);
        }
		$out .='</li>';
       
    }
	///$out .='<li><a href="/be/user.php">Benutzer hinzufügen</a></li>';
    $out .= '</ul>';
    return $out;
   
}
?>