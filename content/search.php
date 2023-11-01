<?php 

$langCriteria = $_SESSION["_registry"]["lang"]["language"]["shortname"];

if(isset($_POST['criteria'])){
		 // $lid = 1;
		 // $top_name = 'SUCHE';
	if($langCriteria == "de"){
		 $lid = 1;
		 $top_name = 'SUCHE';
		 $langLink = "de";
	 } elseif($langCriteria == "en") {
		 $lid = 2;
		 $top_name = 'SEARCH';
		 $langLink = "en";
	 }
	?>
	<style type="text/css">
	hr.search_hr {
		border:none;
    	margin: 20px auto;
	}
	</style>
	<?php 	
$_POST['criteria'] = strtolower($_POST['criteria']);
	$html .='
	
	
	<div class="search_container pt-md-5">
	<div class="container">';
	if($lid == 1){
		$html .='<div class="h2">Suchergebnisse für <span style="">'.$_POST['criteria'].'</span></div>';
	} else {		
		$html .='<div class="h2">Search results for <span style="">'.$_POST['criteria'].'</span></div>';
	}
	
	/*--------------------- News---*/
	$news_res = $DB->select("SELECT * FROM news_text WHERE LOWER(`news_headline`) like '%".$_POST['criteria']."%'  OR  LOWER(`news_subline`) like '%".$_POST['criteria']."%' and language_id=".$lid);
		if($lid == 1){
			$news_sch ='Aktuelles';
		} else {		
			$news_sch ='News';
		}	
	if(!empty($news_res)){
		$html .= '<div class="search_section_headline">'.$news_sch.' :</div>
		<div class="criteria">';
		foreach($news_res as $res ){
			$html .= '<a target="_blank" href="'.$URL_ROOT . $langLink . '/news/'.$res['id'].'/"><h4 class="search_h4">'.$res['news_headline'].' ... </h4></a>';
			$html .= '<div class="search_div_res">'.strip_tags(cutString($res['news_subline'], 150)).'</div>';
			$html .= '<hr class="search_hr" />';
		}
		$html .='</div>
		<div style="clear:both"></div>';
	} 
	/*--------------------- Products---*/
	$product_res = $DB->select("SELECT t1.*, t2.name as product_cat FROM `products` as t1 JOIN products_categories as t2 ON t1.category = t2.id WHERE t1.status = 1 AND (LOWER(t1.description) LIKE '%".$_POST['criteria']."%' OR LOWER(t1.description_en) LIKE '%".$_POST['criteria']."%' OR  LOWER(t1.red_text) LIKE '%".$_POST['criteria']."%' OR LOWER(t1.red_text_en) LIKE '%".$_POST['criteria']."%') 
		OR LOWER(t1.name) LIKE '%".$_POST['criteria']."%'
		");
	
	if(!empty($product_res)){
		if($lid == 1){
			$html .='<div class="search_section_headline">Produkte :</div>';
		} else {		
			$html .='<div class="search_section_headline">Products :</div>';
		}
		$html .= '
		<div class="criteria">'; 
		foreach($product_res as $res ){
			$cats = $DB->query_fetch("select name from `products_categories` where `id`=".$res['category']);
			$html .= '<a target="_blank" href="/'.$langLink.'/products/'.$res['product_cat'].'/'.$res['seo_url'].'"><h4 class="search_h4">'.$res['name'].'</h4></a><hr class="search_hr" />'; 
		}
		$html .='</div>
		<div style="clear:both"></div>';
	} 
	

	/*--------------------- Termine---*/  
	$termine = $DB->select('SELECT * FROM termine_text WHERE status=1 and ( LOWER(termine_headline) like "%'.$_POST['criteria'].'%"  OR LOWER(termine_text) like "%'.$_POST['criteria'].'%" )   ORDER BY termine_datefrom');
	if(!empty($termine)){	
		if($lid == 1){
			$termine_sch ='Termine';
		} else {		
			$termine_sch ='Dates';
		}	
		$html .= '<div class="search_section_headline">'.$termine_sch.' :</div><div class="criteria">';
		foreach($termine as $res){ 
				$html .='<div><a target="_blank" href="'.$URL_ROOT. $langLink .'/dates/'.$res['id'].'/" /><h4 class="search_h4">'.$res['termine_headline'].' ... </h4></a>
				<div class="search_div_res">'.cutString(strip_tags($res['termine_text'], 150)).'</div>
				</div><hr class="search_hr" />';
 			
		}
		$html .='</div>
		<div style="clear:both"></div>';
	}
	/*--------------------- Downloads ---*/   
			$query = 'SELECT distinct c.cat_name AS c_name,
							 d.download_title AS d_titel,
							 d.id as d_id
					    FROM download_categories AS c,
							 download_text AS d
					   WHERE  d.download_cat_id = c.id
					     AND c.status = 1
					     AND d.status = 1 
						 AND (LOWER(c.cat_name) LIKE "%'.$_POST['criteria'].'%"
			  			  OR  LOWER(d.download_title) LIKE "%'.$_POST['criteria'].'%" ) 
				';						  
	$downloads = $DB->select($query);
	if(!empty($downloads)){		
		$html .= '<div class="search_section_headline">Downloads :</div><div class="criteria">'; 	 
				$html .='<div><a target="_blank" href="'.$URL_ROOT. $langLink .'/partner/downloads/" /><h4 class="search_h4">Downloads page ... </h4></a> 
				</div><hr class="search_hr" />'; 
		$html .='</div>';
	}
	
	/*--------------------- Pages---*/	
	
	function searchFiles($dir, $search) {
		$files = glob($dir."/*.php");
		$results = array(); 
		$str = "";
		for ($i = 0; $i < count($files); $i++) {
		  $str = file_get_contents($files[$i]); 
		  $count = substr_count(strtolower($str), $search); // 
		  if ($count){
			  if($files[$i] !== "content/product_detail.php" && $files[$i] !== "content/search.php" && $files[$i] !== "content/settings.php"){
				  $results[$files[$i]] = $files[$i]; // if found, add to array of results
			  }
		  }
		}		
		return $results; 
	}

	function parserPhp($file , $search , $length ){ 
		$content = file_get_contents($file); 
		$pos = strpos($content, $search); 
		$content = substr($content, $pos-iconv_strlen($search)-100); 
		$pos = strpos($content, $search); 
		$content = substr($content, 0, $pos+$length+100); 

		return $content;		
	}

	$results = searchFiles('content', $_POST['criteria']); 
	$results2 = searchFiles('content/contact/', $_POST['criteria']); 
	if(!empty($results) || !empty($results2)){
		if($lid == 1){
			$pages_sch ='Seiten';
		} else {		
			$pages_sch ='Pages';
		}	
		$html .= '<div class="search_section_headline">'.$pages_sch.' :</div><div class="criteria">';
	}
	if(count($results) > 0){		 
		foreach($results as $res){
			$rep = array('content/' , '.php');
			$filename = str_replace($rep,'',$res);
			$filename_title = $filename;
			if($lid == 1){
				switch($filename_title){
					case 'contact';
						$filename_title = 'Kontakt';
					break; 
				}
			}			
			$html .= '<div><a target="_blank" href="'.$URL_ROOT. $langLink . '/' .$filename.'/"><span style="text-transform: capitalize;">'.$filename_title.'</span></a></div><hr class="search_hr" />';
			//$filetext = parserPhp( $URL_ROOT.$filename.'/' , $_POST['criteria'] , 150);
			//$html .= '<div class="search_div_res"> ... '.$filetext.' ... </div>';		  
		} 
	}
	if(count($results2) > 0){ 
		foreach($results2 as $res){
			$rep = array('content/contact/' , '.php' , '/');
			$filename = str_replace($rep,'',$res); 
			$filename_title = $filename;
			if($lid == 1){
				switch($filename_title){
					case 'europe';
						$filename_title = 'Europa';
					break;
					case 'germany';
						$filename_title = 'Deutschland';
					break; 
				}
			}
			$html .= '<div><a target="_blank" href="'.$URL_ROOT.'contact/'.$filename.'/">Ihr Ansprechpartner in <span style="text-transform: capitalize;">'.$filename_title.'</span></a></div><hr class="search_hr" />';
			//$filetext = parserPhp( $URL_ROOT.$filename.'/' , $_POST['criteria'] , 150);
			//$html .= '<div class="search_div_res"> ... '.$filetext.' ... </div>';		  
		} 
	}
   
 
	$pattern = "/((?:^|>)[^<]*)(".$_POST['criteria'].")/si";
	$replace = '$1<b style="color:#e3001b; background:#FFFF00;">$2</b>';
	$html = preg_replace($pattern, $replace, $html); 
	 $html.='<br /><br /></div></div></div></div>';
 
}

echo $html;

?>  
<style type="text/css">
// .search_container{
	// display:none;
// }
// .totalwrap .search_container{
	// display:block!important;
// }
</style>

