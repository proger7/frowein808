<?php
error_reporting(E_ALL);

include 'remote_backup_password.php';

backup_database_tables($db_server, $db_user, $db_password, $db_name, $db_tables);


// backup the db function
function backup_database_tables($host, $user, $pass, $name, $tables)
{
    $link = mysqli_connect($host, $user, $pass);
    mysqli_select_db($link, $name);
    if ($tables == '*') {
        $tables = array();
        mysqli_query($link, 'SET character_set_results=utf8');
        mysqli_query($link, 'SET character_set_client=utf8');
        mysqli_query($link, 'SET character_set_connection=utf8');
        mysqli_query($link, 'SET character_set_results=utf8');
        mysqli_query($link, 'SET collation_connection=utf8_general_ci');
        $result = mysqli_query($link, 'SHOW TABLES');
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }
    $return= '/*'.date("d.m.y H:i").'*/';
    $return.="\n\n\n";
    foreach ($tables as $table) {
        $result = mysqli_query($link, 'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);
        $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";
        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = mysqli_fetch_row($result)) {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for ($j=0; $j<$num_fields; $j++) {
                    //echo $row[$j]."\\n";
                    $row[$j] = addslashes($row[$j]);
                    //$row[$j] = preg_replace($row[$j], "\n", "\\n");
                    //echo $row[$j]."\\n";
                    if (isset($row[$j])) {
                        $return.= '"'.$row[$j].'"' ;
                    } else {
                        $return.= '""';
                    }
                    if ($j<($num_fields-1)) {
                        $return.= ',';
                    }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    //echo $return;

    /*	if (glob('./*.sql')) foreach (glob('./*.sql') as $fn) if(is_file($fn)) unlink($fn);
        $backup_name = 'backup_'.$name.'_'.date('d-m-Y H:i:s').'.sql';*/
    if (glob('*.sql')) {
        foreach (glob('*.sql') as $fn) {
            if (is_file($fn)) {
                unlink($fn);
            }
        }
    }
    $backup_name = 'backup_'.date('d-m-Y H:i:s').'.sql';
    $backup_name_log = 'backup.log';

    $handle = fopen($backup_name, 'w+');
    $handle_log = fopen($backup_name_log, 'a');

    if ($handle) {
        fwrite($handle, $return);
        fclose($handle);

        fwrite($handle_log, date('d-m-Y H:i:s')." - STATUS OK\n");
	echo "Status OK";
        fclose($handle_log);
    } else {
        fwrite($handle_log, date('d-m-Y H:i:s')." - STATUS ERROR\n");
        echo "Status Error";
	fclose($handle_log);
    }
}
