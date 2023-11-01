<?php
// definition error messages
define("ERR_NOERR", 0);
define("ERR_NOSOCKET", 1);
define("ERR_SERVER_NOT_READY", 2);
define("ERR_NOHELO", 3);
define("ERR_NOMAIL", 4);
define("ERR_NORCPT", 5);
define("ERR_NODATA", 6);
define("ERR_MAILBODY", 7);
define("ERR_NOSENDER", 8);
define("ERR_WRONGADDRESS", 9);

/* Default mime types */
define("MIME_DEFAULT_TEXT_TYPE", "text/html; charset=utf-8");
define("MIME_DEFAULT_TEXT_TYPE_H", "text/html; charset=utf-8");
define("MIME_DEFAULT_TEXT_TYPE_T", "text/plain; charset=utf-8");
define("MIME_DEFAULT_BINARY_TYPE", 'application/octet-stream; name="%s"');
define("MIME_DEFAULT_BINARY_ENCODE", 'base64');
define("MIME_DEFAULT_BINARY_DISPOSITION", 'attachment; filename="%s"');

// --------------------------------------------
// main class
// --------------------------------------------
class phpMailer {
		/* class variabels */
		var $sServer;					// SMTP server 
		var $sDomain;					// SMTP server 
		var $nPort;						// Server port (default=25)
		var $pSocket;

		var $aHeaders;					// header 
		var $aAttachments;				// attached files
		var $aParts;					
		var $Boundary;

		var $sClassName = "PHP Mailer";
		var $nClassVersion = "0.1";
		
		var $nLastErrNo;
		var $sLastErrStr;
		
		var $aErrors = array("","Socket not available","SMTP Server not ready: ","HELO not available at SMTP Server","MAIL not available at SMTP Server","RCPT not available at SMTP Server","DATA not available at SMTP Server","Body is missing","Sender is missing","Recepient is wrong");

		// --------------------------------------------
		// init method
		// function phpMailer($Server = "mail.gbc.net", $Port = "25", $Domain = "mail.gbc.net")
		function phpMailer($Server, $Port, $Domain)
		{	$this->sServer = $Server;			// initialize server variables
			$this->nPort = $Port;
			$this->sDomain = $Domain;

			$this->aHeaders = array();
			$this->aAttachments = array();
			$this->aParts = array();
			
			unset($this->pSocket);

			$this->Clear();
		}

		// --------------------------------------------
		// send mail method
		function Send($sFrom, $sTo, $sSubject, $sBody, $sCC = "", $sBCC = "", $sFormat = 0)
		{	if(($sFromAddr = $this->ExtractAddress($sFrom)) == "")		// check mailer address
			{	$this->nLastErrNo = ERR_NOSENDER;
				$this->sLastErrStr = $sFrom;
			}

			$aToAddr = $this->ParseAdresses($sTo);						// check recepients address
			if(count($aToAddr) <= 0)
			{	$this->nLastErrNo = ERR_WRONGADDRESS;
				$this->sLastErrStr = $sTo;
			}

			$aCCAddr = $this->ParseAdresses($sCC);						// parse CC and BCC
			$aBCCAddr = $this->ParseAdresses($sBCC);

			$this->AddHeader("Date", $this->FormatMailDate());			// beginning of mail
			$this->AddHeader("To", $sTo);
			$this->AddHeader("From", $sFrom);
			$this->AddHeader("Return-Path", $sFrom);
			$this->AddHeader("cc", $sCC);
			$this->AddHeader("bcc", $sBCC);
			$this->AddHeader("Subject", $sSubject);
			$this->AddHeader("MIME-Version", "1.0");
			
			if($this->IsMultiPart())									// set multipart header
			{	$this->Boundary = "-phpMailer-" . substr(md5(uniqid(rand())), 8);
				$sType = sprintf("multipart/mixed; boundary=%s", $this->Boundary);
				$this->AddHeader("Content-Type", $sType);
			}

			if(!$this->_ConnectServer()) return(false);					// connect to server

			// set envelope
			if(!$this->_StartMsgTransact($sFromAddr, $aToAddr, $aCCAddr, $aBCCAddr))
			{	$this->_DisconnectServer();
				return(false);
			}

			$this->SendBody($sBody,$sFormat);							// send body

			if(!$this->_EndMsgTransact())								// end mail processing
			{	$this->_DisconnectServer();
				return(false);
			}

			$this->_DisconnectServer();									// disconnect from server
			return(true);
		}

		// --------------------------------------------
		// send body method
		function SendBody($sBody,$sFormat=0)
		{	reset($this->aHeaders);										// reset headers
			while(list($k, $v) = each($this->aHeaders))
			{	if(trim($v) == "") continue;
				fputs($this->pSocket, $k.": ".$v."\r\n");
			}
			// fputs($this->pSocket, "\r\n");

			// prepare multipart message
			if($this->IsMultiPart()) fputs($this->pSocket, "\r\n\r\nThis is a multipart MIME message.\r\n");
			$this->PrepareParts($sBody,$sFormat);
			$this->SendParts();
		}

		// --------------------------------------------
		// prepare parts method
		function PrepareParts($sBody,$sFormat=0)
		{	$this->aParts = array();
			
			$sBody = trim($sBody);
			if($sBody != "")
			{	if($this->Is8Bit($sBody))
				{	$sBody = QuotedPrintableEncode($sBody);
					$sBodyEncode = "quoted-printable";
				} else
				{	$sBodyEncode = ""; }
							
				//$this->aParts[] = array("Content-Type" => MIME_DEFAULT_TEXT_TYPE, "Content-Transfer-Encoding" => $sBodyEncode, "Body" => $sBody);
				if ($sFormat==0)
				{	$this->aParts[] = array("Content-Type" => MIME_DEFAULT_TEXT_TYPE_H, "Content-Transfer-Encoding" => $sBodyEncode, "Body" => $sBody);
				} else
				{	$this->aParts[] = array("Content-Type" => MIME_DEFAULT_TEXT_TYPE_T, "Content-Transfer-Encoding" => $sBodyEncode, "Body" => $sBody);
				}
			}

			// add attachements
			if($this->IsMultiPart())
			{	reset($this->aAttachments);
				while(list($k, $v) = each($this->aAttachments))
				{	$this->aParts[] = array("Content-Type" => $v["Content-Type"], "Content-Transfer-Encoding" => $v["Content-Transfer-Encoding"], "Content-Disposition" => $v["Content-Disposition"], "Body" => $this->EncodeFile($v["FileName"], $v["Content-Transfer-Encoding"]));
				}
			}
		}

		// --------------------------------------------
		// send parts method
		function SendParts()
		{	reset($this->aParts);
			while(list($k, $v) = each($this->aParts))
			{	if($this->IsMultiPart()) fputs($this->pSocket, sprintf("\r\n--%s\r\n", $this->Boundary));
				if(trim($v["Content-Type"]) != "") fputs($this->pSocket, sprintf("Content-Type: %s\r\n", $v["Content-Type"]));
				if(trim($v["Content-Transfer-Encoding"]) != "") fputs($this->pSocket, sprintf("Content-Transfer-Encoding: %s\r\n", $v["Content-Transfer-Encoding"]));
				if(trim($v["Content-Disposition"]) != "") fputs($this->pSocket, sprintf("Content-Disposition: %s\r\n", $v["Content-Disposition"]));
				if(trim($v["Body"]) != "") fputs($this->pSocket, sprintf("\r\n%s", $v["Body"]));
			}

			if($this->IsMultiPart()) fputs($this->pSocket, sprintf("--%s--\r\n", $this->Boundary));
		}

		// --------------------------------------------
		// read out mime extensions method
		function GetMimeFromExtension($sFName, $sCompleteName, $sType, $sEncode, $sDisp)
		{	include(pathinfo(__FILE__,PATHINFO_DIRNAME)."/phpmailer_mimetypes.php");
			
			$sExt = "";
			$sExt = strtolower(substr(strrchr($sFName, "."), 1));
			
			if(trim($sExt) != "") $sAppMime = $aMimeTypes[$sExt];
			
			if(trim($sAppMime) != "")
			{	if(($npos = strpos($sAppMime, "/")) > 0) $sMainType = substr($sAppMime, 0, $npos);
				switch($sMainType)
				{	case "text" : {	if($this->Is8BitFile($sCompleteName))
									{ $sEncode = "quoted-printable";
									} else
									{ $sEncode = ""; 
									}
									$sAppMime .= sprintf('; name="%s"', $sFName);
									$sDisp = sprintf('attachment; filename="%s"', $sFName);
									break;
									}
					case "image" : { }
					case "audio" : { }
					case "video" : { }
					case "application" : { $sAppMime .= sprintf('; name="%s"', $sFName);
											$sEncode = "base64";
											$sDisp = sprintf('attachment; filename="%s"', $sFName);
											break;
											}
					default : {	$sAppMime .= sprintf('; name="%s"', $sFName);
								$sEncode = "base64";
								$sDisp = sprintf('attachment; filename="%s"', $sFName);
							  }
				}
				
				$sType = $sAppMime;
			} else
			{	$sType = sprintf(MIME_DEFAULT_BINARY_TYPE, $sFName);
				$sEncode = MIME_DEFAULT_BINARY_ENCODE;
				$sDisp = sprintf(MIME_DEFAULT_BINARY_DISPOSITION, $sFName);
			}
		}

		// --------------------------------------------
		// encode file method
		function EncodeFile($sFName, $sEncode)
		{	$fd = fopen($sFName, "rb");
			if($fd)
			{	$sBody = fread($fd, filesize($sFName));
 				fclose($fd);
			} else
			{	return("");
			}

			return($this->EncodeStream($sBody, $sEncode));
		}

		// --------------------------------------------
		// encode stream method
		function EncodeStream($sBody, $sEncode)
		{	if($sEncode == "") return($sBody);
			if($sEncode == "base64") return(chunk_split(base64_encode($sBody)));
			if($sEncode == "quoted-printable") return(QuotedPrintableEncode($sBody));
			return("");
		}

		// --------------------------------------------
		// Add header method
		function AddHeader($sHName, $sHValue)
		{	if(trim($sHName) == "" || trim($sHValue) == "") return(false);
			$this->aHeaders[$sHName] = $sHValue;
			return(true);
		}

		// --------------------------------------------
		// add attachement method
		function AddAttachment($sFileName, $sMIMEType = "", $sEncoding = "")
		{	if(trim($sFileName) == "") return(false);
			$sDisp = "";

			if(trim($sMIMEType) == "")
			{	$sBaseName = basename($sFileName);
				$this->GetMimeFromExtension($sBaseName, $sFileName, &$sMIMEType, &$sEncoding, &$sDisp);
			}

			$this->aAttachments[] = array("FileName" => $sFileName, "Content-Type" => $sMIMEType, "Content-Transfer-Encoding" => $sEncoding,"Content-Disposition" => $sDisp);
			return(true);
		}

		// --------------------------------------------
		// remove header method
		function RemoveHeader($sHName)
		{	if(trim($sHName)) return(false);
			if(trim($this->aHeaders[$sHName]) != "") $this->aHeaders[$sHName] = "";
			return(true);
		}

		// --------------------------------------------
		// clear method
		function Clear()
		{	$this->aHeaders = array();
			$this->aAttachments = array();
			$this->aParts = array();

			$this->AddHeader("X-Mailer", $this->sClassName . " " . $this->nClassVersion);
			return(true);
		}

		// --------------------------------------------
		// connect to server method
		function _ConnectServer()
		{	if($this->pSocket > 0) return(true);

			$this->pSocket = fsockopen($this->sServer, 25, &$errno, &$errstr, 30);
			if(!$this->pSocket)
			{	$this->nLastErrNo = ERR_NOSOCKET;
				return(false);
			}

			set_socket_blocking($this->pSocket, 1);

			$reply = fgets($this->pSocket, 512);
			if( substr($reply, 0, 3) != "220" ) 
			{	fclose($this->pSocket);
				unset($this->pSocket);
				$this->nLastErrNo = ERR_SERVER_NOT_READY;
				$this->sLastErrStr = $reply;
				return(false);
			}

			fputs($this->pSocket, sprintf("HELO %s\r\n", $this->sDomain));
			$reply = fgets($this->pSocket, 512);

			if( substr($reply, 0, 3) != "250" )
			{	fclose($this->pSocket);
				unset($this->pSocket);
				$this->nLastErrNo = ERR_NOHELO;
				$this->sLastErrStr = "";
				return(false);
			}

			$this->nLastErrNo = ERR_NOERR;
			$this->sLastErrStr = "";
			return(true);
		}

		// --------------------------------------------
		// start message transaction method
		function _StartMsgTransact($From, $aTo, $aCC, $aBCC)
		{	if($this->pSocket <= 0) return(true);

			fputs($this->pSocket, "MAIL FROM: <".$From.">\r\n");
			$reply = fgets($this->pSocket, 512);
			if(substr($reply, 0, 3) != "250")
			{	$this->nLastErrNo = ERR_NOMAIL;
				$this->sLastErrStr = "";
				return(false);
			}

			$aDestArray = array_merge($aTo, $aCC, $aBCC);
			while(list($k, $v) = each($aDestArray))
			{	fputs($this->pSocket, "RCPT TO: <".$v.">\r\n");
				$reply = fgets($this->pSocket, 512);
				if(substr($reply, 0, 3) != "250")
				{	$this->nLastErrNo = ERR_NORCPT;
					$this->sLastErrStr = "";
					return(false);
				}
			}

			fputs($this->pSocket, "DATA\r\n");
			$reply = fgets($this->pSocket, 512);
			if( substr($reply, 0, 3) != "354" )
			{	$this->nLastErrNo = ERR_NODATA;
				$this->sLastErrStr = "";
				return(false);
			}

			$this->nLastErrNo = ERR_NOERR;
			$this->sLastErrStr = "";
			return(true);
		}

		// --------------------------------------------
		// End message transaction method
		function _EndMsgTransact()
		{	if($this->pSocket <= 0) return(true);

			fputs($this->pSocket, "\r\n.\r\n");
			$reply = fgets($this->pSocket, 512);
			if(substr($reply, 0, 3) != "250")
			{	$this->nLastErrNo = ERR_MAILBODY;
				$this->sLastErrStr = "";
				return(false);
			}

			$this->nLastErrNo = ERR_NOERR;
			$this->sLastErrStr = "";
			return(true);
		}

		// --------------------------------------------
		// diconnect from server method
		function _DisconnectServer()
		{	if($this->pSocket <= 0) return(true);

			fputs($this->pSocket, "QUIT\r\n");
			$reply = fgets($this->pSocket, 512);

			fclose($this->pSocket);
			unset($this->pSocket);

			return(true);
		}

		// --------------------------------------------
		// format date method
		function FormatMailDate()
		{	$Offset = date("Z");
			$TOff = sprintf("%s%02s%02s", (($Offset >= 0) ? "+" : "-"), $Offset / 3600, $Offset % 3600);
			return(date("D, d M Y H:i:s ".$TOff." T"));
		}

		// --------------------------------------------
		// Parse address method
		function ParseAdresses($sCommastr)
		{	$aRes = array();
			$aApp = explode(",", $sCommastr);

			while(list($k, $v) = each($aApp))
			{	$sDest = trim($v);
				if(($sAddr = $this->ExtractAddress($sDest)) != "") $aRes[$sDest] = $sAddr;
			}

			return($aRes);
		}

		// --------------------------------------------
		// extract address method
		function ExtractAddress($sDest)
		{	$sAddr = "";
			//if(ereg("([a-zA-Z0-9_+\-\.]+[@][a-zA-Z0-9][a-zA-Z0-9_+\-\.]+[\.][a-zA-Z]{2,})", $sDest, &$aAddr)) $sAddr = $aAddr[1];
			$sAddr = $sDest;
			return($sAddr);
		}

		// --------------------------------------------
		// check for Multipart method
		function IsMultiPart()
		{	return(count($this->aAttachments) > 0);
		}

		// --------------------------------------------
		// check for 8 bit file method
		function Is8BitFile($sFName)
		{	$fd = fopen($sFName, "rb");
			if($fd)
			{	$sBody = fread($fd, filesize($sFName));
 				fclose($fd);
			} else
			{ return(""); }

			return($this->Is8Bit($sBody));
		}

		// --------------------------------------------
		// check for 8 bit data method
		function Is8Bit($sText)
		{	return(preg_match("~[\x80-\xFF]~", $sText));
		}
};
// --------------------------------------------
// end main class
// --------------------------------------------


function quoted_printable_encode_character($matches)
{
   $character = $matches[0];
   return sprintf('=%02x',ord($character));
}

// --------------------------------------------
// Encode Quoted Printable
// --------------------------------------------
function QuotedPrintableEncode($sString)
{
    $sString = preg_replace_callback('/[^\x21-\x3C\x3E-\x7E\x09\x20]/','quoted_printable_encode_character',$sString);
    $newline = "=\r\n";
    $sString = preg_replace( '/(.{73}[^=]{0,3})/','$1'.$newline,$sString);
    return $sString;
}
?>