<?php
include('config.php');
header("Content-Type: text/xml");
$column = isset($_REQUEST['column']) ? $_REQUEST['column'] : false;
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<values>';
if (!$column) {
    echo "</values>";
    exit;
}

/*
 * Total number of value and rowss
 */
$sql = "SELECT COUNT(DISTINCT(`" . $column . "`)) AS total_values, COUNT(*) AS total_rows FROM `" . $table_name . "`";
$req = $db->prepare($sql);
$req->execute();
$res_total = $req->fetchAll();
$total_values = $res_total[0]['total_values'];
$total_rows = $res_total[0]['total_rows'];

/*
 * Selecting the 100 first values, with count of rows and age average
 */
$sql = "SELECT `" . $column . "`, AVG(age) AS age, COUNT(*) AS total FROM `" . $table_name . "` GROUP BY `" . $column . "` ORDER BY `total` DESC LIMIT 100";
$req = $db->prepare($sql);
$req->execute();
$res = $req->fetchAll();
$rows_displayed = 0;
foreach($res as $value) {
    $value[$column] = !is_null($value[$column]) ? htmlspecialchars($value[$column], ENT_QUOTES) : "None";
    $value['age'] = !is_null($value['age']) ? htmlspecialchars($value['age'], ENT_QUOTES) : "None";
    $value['total'] = !is_null($value['total']) ? htmlspecialchars($value['total'], ENT_QUOTES) : "None";
    echo '<value>';
    echo '<name>';
    echo $value[$column];
    echo '</name>';
    echo '<age>';
    echo intval($value['age']);
    echo '</age>';
    echo '<total>';
    echo $value['total'];
    echo '</total>';
    echo '</value>';
    $rows_displayed += $value['total'];
}
echo '<total_count>';
echo '<total_values>';
echo intval($total_values);
echo '</total_values>';
echo '<total_missing_rows>';
echo intval($total_rows) - $rows_diaplsyed;
echo '</total_missing_rows>';
echo '</total_count>';
echo '</values>';
