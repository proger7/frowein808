<?php
$backup_config = $REGISTRY["ftp_config"]["backup"];
try
{
    $ftp = FTP::getInstance();
    $ftp->connect($backup_config, false, true );
}
catch (FTPException $error)
{
    echo $error->getMessage();
}
$ftp->changeDir($backup_config["root"]);
$newBackupDir = date("Y_m_d__H_i_s",time())."/";
$ftp->makeDir($newBackupDir);
$ftp->changeDir($backup_config["root"].$newBackupDir);
if (!$backup_config["zip"]){
    print "        ***Starting unzipped File-Backup in ".$backup_config["root"].$newBackupDir."***\n";
    $ftp->copyFolder($DIR_ROOT."/","");
    $ftp->changeDir($backup_config["root"].$newBackupDir);
}
else{
    print "        ***Starting zipped File-Backup in ".$backup_config["root"].$newBackupDir."***\n";
    $zip = new recurseZip();
    $zip->compress($DIR_ROOT,"./tmp","files.tmp");
    $ftp->upload( "./tmp/files.tmp",  "files.zip", 'auto', 0 );
    unlink("./tmp/files.tmp");
}
print "        ***File-Backup Complete***\n";
print "        ***Starting Database-Backup***\n";
$handler = fOpen($DIR_ROOT."/admin/tmp/dbDump.tmp" , "a+");
fWrite($handler,$DB->dump());
fclose($handler);
$ftp->upload($DIR_ROOT."/admin/tmp/dbDump.tmp",  "dbDump.sql", 'auto', 0 );
unlink($DIR_ROOT."/admin/tmp/dbDump.tmp");
print "        ***Database-Backup Complete***\n";
?>
