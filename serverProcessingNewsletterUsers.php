<?php

    header('Content-Type: application/json; charset=utf-8');
    include "includes/general.inc.php";
    /*
     * DataTables example server-side processing script.
     *
     * Please note that this script is intentionally extremely simple to show how
     * server-side processing can be implemented, and probably shouldn't be used as
     * the basis for a large complex system. It is suitable for simple use cases as
     * for learning.
     *
     * See http://datatables.net/usage/server-side for full details on the server-
     * side processing requirements of DataTables.
     *
     * @license MIT - http://datatables.net/license_mit
     */

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */

    // DB table to use
    $table = $_GET['table'];
    $url = $_GET['url'];

    // Table's primary key
    $primaryKey = 'id';

    $db_config = $_SESSION["_registry"]["db_config"];

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database, while the `dt`
    // parameter represents the DataTables column identifier. In this case simple
    // indexes
    $list_fields = array(  "status" => "Status", "id" => "ID",  "kundennummer" => "Kundenummer",  "user_nachname" => "Nachname", "user_name" => "Firstname", "update_type" => "Import by");
    $columns = array(
        array( 'db' => 'status', 'dt' => 1),
        array( 'db' => 'id', 'dt' => 2),
        array( 'db' => 'kundennummer', 'dt' => 3),
        array( 'db' => 'user_nachname', 'dt' => 4),
        array( 'db' => 'user_name', 'dt' => 5),
        array( 'db' => 'update_type', 'dt' => 6)
    );
    // SQL server connection information
    $sql_details = array(
        'host' => $db_config['host'],
        'user' =>$db_config['user'],
        'pass' => $db_config['pass'],
        'db' => $db_config['database'],
    );
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP
     * server-side, there is no need to edit below this line.
     */
    require( 'includes/ssp.class.php' );
    $where = "";
    $arr = array();
    $res = SSP::simpleCustom($_GET, $sql_details, $table, $primaryKey, $columns, null, $where);
    $z = 0;

        foreach ($res['data'] as $row) {
            if ($row[1] == 1) {
                $button = '<img src="https://www.frowein808.de/admin/img/kugel_gruen.gif" alt="">';
                $change = 0;
            } else {
                $button = '<img src="https://www.frowein808.de/admin/img/kugel_rot.gif" alt="">';
                $change = 1;
            }
            $arr[] = array(
                0 => $button,
                1 => $row[2],
                2 => $row[3],
                3 => $row[4],
                4 => $row[5],
                5 => $row[6],
                6 => '
                    <a class="edit_lnk" href="?edit='.$row[2].'" title="Bearbeiten">
	                    <i class="far fa-edit" style="color: #337ab7"></i>
                    </a>&nbsp;
                    <i class="far fa-trash-alt" id="delete_button_'.$row[2].'" title="Löschen" style="color:#e3001b!important;font-size:18px"></i> 
                   <script type="text/javascript">
                            jQuery("#delete_button_'.$row[2].'").click(function() {
                            var r=confirm("Wollen sie den Eintrag wirklich löschen?");
                    if (r==true) ajax_action("delete","newsletter_users",'.$row[2].');
                });
                   </script>&nbsp;<i class="fab fa-audible" title="Status" onclick=ajax_action("change_status","newsletter_users",'.$row[2].','.$change.') style="color:#e3001b ;font-size:18px"></i>  &nbsp;
                   '
            );
        }

    $res['data'] = $arr;
    echo json_encode($res, JSON_UNESCAPED_UNICODE);