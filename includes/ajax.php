<?php
session_start();
$_SESSION['lang_id']=$_POST['lang_id']?$_POST['lang_id']:1;
echo $_SESSION['lang_id'];
?>