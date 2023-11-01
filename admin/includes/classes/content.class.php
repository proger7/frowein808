<?php
class content{
	private $db;
	function __construct(){
		$this->db = $_SESSION["_registry"]["db"];
	}
	
	static function safeSQLStr(&$str) {
		$str = '"'.addslashes($str).'"';
	}	
	function friendlyURL($txt,$useD=TRUE,$maxCount=20) {
        if (strlen($txt)>0):
        $txt = mb_strtolower($txt);
		$txt = str_ireplace(array('ß','&szlig;','ü','ö','ä','&uuml;','&ouml;','&auml;','.'),
				array('ss','ss','ue','oe','ae','ue','oe','ae','-'), $txt);
		$txt = trim(strip_tags(stripcslashes($txt)));
		$txt = preg_replace('#([,;:])#ix',' ',$txt);
		$txt = preg_replace('#(\s)#ix','-',$txt);
		$txt = preg_replace('#(\-{2,})#ix','',$txt);
		
		$txt = preg_replace('#[^abcdefghijklmnop\-qrstuvwxyz1234567890]#ix','',$txt);
		
		
		
		if (strlen($txt)>$maxCount) {
			
			if (strpos($txt,'-')!==FALSE) {
				if (strpos($txt,'-')>$maxCount) $txt = substr($txt, 0,strpos($txt,'-')); else $txt = substr($txt, 0,$maxCount);
				if (strrpos($txt, '-')!==FALSE) $txt = substr($txt, 0,strrpos($txt, '-'));
			}
		};
		
		if ($useD) {

			$count = $this->db->query_fetch_single("SELECT count(*) FROM menus WHERE url='$txt' OR url LIKE '$txt-%'");
			if ($count>0) $txt .= '-'.$count;
		}
		endif;
		return $txt;
	}		
	
	function addNewContent($text,$title,$type=11, $seo_title=NULL,$seo_description=NULL,$seo_keywords=NULL) {
		if (is_null($seo_keywords)) $seo_keywords = ' ';
		if (is_null($seo_description)) $seo_description = 'Anwender finden bei uns sämtliche Produkte: Insektizide, Rodentizide, Monitoring-Systeme und zweckoptimierte Anwendungsgeräte.';
		if (is_null($seo_title)) $seo_title = $title;
		
	
	
		self::safeSQLStr($text); self::safeSQLStr($title); self::safeSQLStr($seo_title); self::safeSQLStr($seo_description); self::safeSQLStr($seo_keywords);
		
		//id, seo_title, seo_keywords, seo_desc, parent, update, editor, titel, headline, text, type, file, height, width, order, sidebar, url
		$url = self::friendlyURL($title);
		//echo "INSERT INTO `sites_text`(seo_title, seo_keywords, seo_desc,parent,titel,`file`) VALUES($seo_title,$seo_keywords,$seo_description,10,$title,'$url')";
		$site_id = $this->db->lastindex_query("INSERT INTO `sites_text`(`text`,`seo_title`, `seo_keywords`, `seo_desc`,`parent`,`titel`,`type`,`file`) VALUES($text,$seo_title,$seo_keywords,$seo_description,10,$title,$type,\"$url\")");
		//echo 'ddddddd='.$site_id;
	
		if ($type==11) {
			$full_url = '"rathaus-und-politik/'.$site_id.'-'.$url.'"';
			$par_id=$root_id=$this->db->query_fetch_single("SELECT `site_id` FROM menus WHERE `url`='rathaus-und-politik'");
		} elseif($type==16) {
			$full_url = '"rathaus-und-politik/ausschreibungen/'.$url.'"';
			$par_id=$this->db->query_fetch_single("SELECT `site_id` FROM menus WHERE `url`='ausschreibungen'");
			$root_id=$this->db->query_fetch_single("SELECT `site_id` FROM menus WHERE `url`='rathaus-und-politik'");
		};
	
		$this->db->query_lastindex("INSERT INTO menus(title, par_id, site_id, root_id, `inner`, url, full_url)
				VALUES($title,$par_id,$site_id,$root_id,2,'$url',$full_url)");
	
		return $site_id;
	}

	function deleteNewContent($site_id) {
		$this->db->query("DELETE FROM `sites_text` WHERE id=$site_id");
		$this->db->query("DELETE FROM `menus` WHERE site_id=$site_id");
		
	}

	function updateNewContent($site_id, $text,$title,$type=11, $seo_title=NULL,$seo_description=NULL,$seo_keywords=NULL) {
		if (is_null($seo_keywords)) $seo_keywords = '';
		if (is_null($seo_description)) $seo_description = 'Anwender finden bei uns sämtliche Produkte: Insektizide, Rodentizide, Monitoring-Systeme und zweckoptimierte Anwendungsgeräte..';
		if (is_null($seo_title)) $seo_title = $title;
	
	
	
		self::safeSQLStr($text); self::safeSQLStr($title); self::safeSQLStr($seo_title); self::safeSQLStr($seo_description); self::safeSQLStr($seo_keywords);
	
		//id, seo_title, seo_keywords, seo_desc, parent, update, editor, titel, headline, text, type, file, height, width, order, sidebar, url
		$url = self::friendlyURL($title);
		if ($type==11) {
			$full_url = '"rathaus-und-politik/'.$site_id.'-'.$url.'"';
			$par_id=$root_id=$this->db->query_fetch_single("SELECT `site_id` FROM menus WHERE `url`='rathaus-und-politik'");
		} elseif($type==16) {
			$full_url = '"rathaus-und-politik/ausschreibungen/'.$url.'"';
			$par_id=$this->db->query_fetch_single("SELECT `site_id` FROM menus WHERE `url`='ausschreibungen'");
			$root_id=$this->db->query_fetch_single("SELECT `site_id` FROM menus WHERE `url`='rathaus-und-politik'");
		};
				
		//echo "INSERT INTO `sites_text`(seo_title, seo_keywords, seo_desc,parent,titel,`file`) VALUES($seo_title,$seo_keywords,$seo_description,10,$title,'$url')";
		$this->db->query("UPDATE `sites_text` SET `text`=$text,`seo_title`=$seo_title, `seo_keywords`=$seo_keywords, `seo_desc`=$seo_description,`parent`=10,`titel`=$title WHERE id=$site_id");
		$this->db->query("UPDATE menus SET `title`=$title,`url`='$url',`full_url`=$full_url WHERE site_id=$site_id");
	
		//return $site_id;
	}
	
	function addFile($file_name,$par_menu) {
		
		
	}
	
}