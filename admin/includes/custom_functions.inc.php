<?php
	function mccolor($string){
		return preg_replace_callback('/(&[0-9a-f])([^&]+|$)/', 'mccolor_callback', $string);
	}

	function mccolor_callback($m) {
   	 $trans = array(
        	"&0"=>'#000000;',
        	"&1"=>'#0000BF;',
        	"&2"=>'#00BF00;',
        	"&3"=>'#00BFBF;',
        	"&4"=>'#BF0000;',
        	"&5"=>'#BF00BF;',
        	"&6"=>'#BFBF00;',
        	"&7"=>'#BFBFBF;',
        	"&8"=>'#404040;',
        	"&9"=>'#4040FF;',
        	"&a"=>'#40FF40;',
        	"&b"=>'#40FFFF;',
        	"&c"=>'#FF4040;',
        	"&d"=>'#FF40FF;',
        	"&e"=>'#3F3F10;',
        	"&f"=>'#FFFFFF;',
    	);
    	return '<span style="color:'.$trans[$m[1]].'">'.$m[2].'</span>';
	}

	$users = array();
	$goups = array();
	function user_details($username){
		global $DB;
		if (!isset($users[$username])){
			$user = $DB->query_fetch("SELECT * FROM permissions_entity WHERE name = '$username' LIMIT 1");
			$user['nodes']= $DB->select_pair ('permissions','permission','value',FALSE,FALSE, "name = '$username' AND value != '' AND permission != 'password'" );
			$user['inheritance'] = $DB->query_fetch("SELECT * FROM permissions_inheritance WHERE child = '$username' LIMIT 1");
			if (!isset($goups[$user["inheritance"]["parent"]]))	$user['group'] = $DB->query_fetch("SELECT * FROM permissions_entity WHERE name = '".$user["inheritance"]["parent"]."' LIMIT 1");
			else  $user['group'] = $goups[$user["inheritance"]["parent"]];
			$user["full_name"] = mccolor($user['group']['prefix'].$user["name"]);
			$user["forum"]["posts"] = $DB->affected_query("SELECT id FROM forum_threads WHERE owner = '$username';") + $DB->affected_query("SELECT id FROM forum_posts WHERE owner = '$username';");
			$user["forum"]["likes"]["set"] = $DB->affected_query("SELECT id FROM forum_likes WHERE liker = '$username';");
			$user["forum"]["likes"]["get"] = $DB->affected_query("SELECT id FROM forum_likes WHERE liked = '$username';");
			$user["forum"]["likes"]["get_posts"] = $DB->affected_query("SELECT id FROM forum_likes WHERE liked = '$username' AND type = 0 GROUP BY ent_id;") + $DB->affected_query("SELECT id FROM forum_likes WHERE liked = '$username' AND type = 1 GROUP BY ent_id;");
			return $user;
		}
		else return $users[$username];
	}
?>