<?php
    include 'general.inc.php';
    if(isset($_POST['export_newsletter_users'])){

        $query = "SELECT status, "
            . "user_anrede, "
            . "user_name, "
            . "user_nachname, "
            . "user_email, "
            . "user_createdate, "
            . "unsubscribe_date "
            . " from `newsletter_users`  WHERE  user_group != 0  AND kundennummer = 0 AND is_deleted = 0 AND  id IN( select user_id from newsletter_user_group where group_id = 55) ORDER BY  user_nachname";

        $users = $DB->select($query);
        $csv = "Anrede;Nachname;Name;Email;Subscribed; Unsubscribed;". "\n";
        foreach ($users as $user){
            $unsubscribe_date = "";
            if($user['unsubscribe_date'] != "0000-00-00 00:00:00") {
                $unsubscribe_date = date("d.m.Y H:i", strtotime($user["unsubscribe_date"]));
            }
            $csv .= ucfirst($user["user_anrede"]).";"
                .$user["user_nachname"].";"
                .$user["user_name"].";"
                .$user["user_email"].";"
                .date("d.m.Y H:i", strtotime($user["user_createdate"])).";"
                .$unsubscribe_date.";". "\n";
        }
        $filename = 'Newsletter_Kunden_Export'.date("d.m.Y H-i").'.csv';
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        echo $csv;
    }
