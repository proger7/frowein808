<?php

	function get_filesize($file)
	{
		if(!file_exists($file)) return "Файл  не найден";

		$filesize = filesize($file);

		if($filesize > 1024){
			$filesize = ($filesize/1024);
			if($filesize > 1024){
				$filesize = ($filesize/1024);
				if($filesize > 1024) {
					$filesize = ($filesize/1024);
					$filesize = round($filesize, 1);
					return $filesize." GB";
				} else {
					$filesize = round($filesize, 1);
					return $filesize." MB";
				}
			} else {
				$filesize = round($filesize, 1);
				return $filesize." KB";
			}
		} else {
			$filesize = round($filesize, 1);
			return $filesize." b";
		}
	}
	function getex($filename)
	{
		return end(explode(".", $filename));
	}
	function get_text($filename)
	{
		$name = explode(".", $filename);
		return $name[0];
	}

	if($_FILES['upload']) {
		if(($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name']))) {
			$message = "Choose an image";
		}
		else if($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 999000000) {
			$message = "Image is too large";
		}
		else if(($_FILES['upload']["type"] != "application/pdf") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png") AND ($_FILES['upload']["type"] != "image/gif")) {
			$message = "Only  pdf, jpg, gif or png.";
		}
		else if(!is_uploaded_file($_FILES['upload']["tmp_name"])) {
			$message = "Try again please.";
		}
		else {
			$name = get_text($_FILES['upload']['name'])."_".mt_rand(1, 10000).'-'.md5($_FILES['upload']['name']).'.'.getex($_FILES['upload']['name']);
			move_uploaded_file($_FILES['upload']['tmp_name'], "uploads/".$name);
			$full_path = '/uploads/'.$name;
			$message   = "File  ".$_FILES['upload']['name']." uploaded";
			$size      = @getimagesize('uploads/'.$name);
			echo "<pre>";
			print_r($size);
			echo "</pre>";
			//$file_size      = @get_filesize('uploads/'.$name);
			/*
			if( ($size[0] < 50 OR $size[1] < 50) || ( !$file_size ) ) {
				//unlink('uploads/'.$name);
				$message   = "File is not a valid image.";
				$full_path = "";
			}
			*/
		}
		$callback = $_REQUEST['CKEditorFuncNum'];
		echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$full_path.'", "'.$message.'" );</script>';
	}

	/**
	 * function getex($filename)
	 * {
	 * return end(explode(".", $filename));
	 * }
	 *
	 * if($_FILES['upload']) {
	 * if(($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name']))) {
	 * $message = "Choose a file";
	 * }
	 * else if($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 10485760) {
	 * $message = "Too large file";
	 * }
	 * else if(($_FILES['upload']["type"] != "image/jpeg/") AND ($_FILES['upload']["type"] != "image/jpg") AND ($_FILES['upload']["type"] != "image/png") AND ($_FILES['upload']["type"] != "image/gif")) {
	 * $message = "jpg ,jpeg,  png or gif only.";
	 * }
	 * else if(!is_uploaded_file($_FILES['upload']["tmp_name"])) {
	 * $message = "Something went wrong. Try downloading the file again.";
	 * }
	 * else {
	 * $name = rand(1, 1000).'-'.md5($_FILES['upload']['name']).'.'.getex($_FILES['upload']['name']).$_FILES['upload']['name'];
	 *
	 * move_uploaded_file($_FILES['upload']['tmp_name'], "/uploads/".$name);
	 * $full_path = 'https://albstadt.de.hosting10-plesk.tn-rechenzentrum1.de/uploads/'.$name;
	 * $message   = "File ".$_FILES['upload']['name']." uploaded.";
	 * }
	 * $callback = $_REQUEST['CKEditorFuncNum'];
	 * echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$full_path.'", "'.$message.'" );</script>';
	 * }
	 *
	 * */

	/*
		$uploaddir  = "../../uploads/";
		$uploadfile = $uploaddir.basename($_FILES['upload']['name']);
		if(move_uploaded_file($_FILES['upload']['tmp_name'], $uploadfile)) {
			echo "File uploaded.\n";
			$full_path = 'https://albstadt.de.hosting10-plesk.tn-rechenzentrum1.de/uploads/'.$uploadfile;
		}
		else {
			echo "ERROR\n";
		}
		$callback = $_REQUEST['CKEditorFuncNum'];
		echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$full_path.'", "'.$message.'" );</script>';
	*/



