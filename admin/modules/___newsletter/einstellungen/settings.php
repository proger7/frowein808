<?php
$_SESSION["_registry"]["variables"]["backlink"] = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].'?edit=1';
echo "<meta http-equiv='refresh' content='0;URL=?edit=1'>";
?>
