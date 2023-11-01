<?php

require_once "../includes/general.inc.php";

global $DB;
if(!empty($_POST['id_cust']))
    $data = $DB->select("SELECT *, DATE_FORMAT(date_login, '%d-%m-%Y %H:%i') as `date_login` FROM `log_statistic` where `id_customer`='{$_POST['id_cust']}' ORDER BY `id` DESC");
?>
<?php if(!empty($data)):?>
    <div style="margin: 20px;">
        <table class="statistic-data-table">
            <tr>
                <td>#</td>
                <td>Date</td>
                <td>Time</td>
            </tr>
            <?php foreach($data as $k=>$v):?>
                <tr>
                    <td><?php echo $k+1;?></td>
                    <td><?php echo $v['date_login']?></td>
                    <td><?php echo sekToTime($v['time'])?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
<?php endif; ?>

<?php
    function sekToTime($sek)
	{
		return gmdate("H:i:s", $sek);
	}
?>





