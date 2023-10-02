<?php
/*
 * NEW - OLD
 * id - id
 * user_id - user_id
 * model - {
 *    model_type - model_type
 *    model_id - model_id
 * }
 * body - body
 * status - status
 * created_at
 * updated_at
 */
function getReports($db){
    $result = $db->query("SELECT * FROM `reports`; ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forReports($arr){
    $insert = '';
    foreach ($arr as $report){
        if(!empty($report['model_type'])){
            $report['model_type'] = quotemeta($report['model_type']);
        }
        $insert .= "INSERT INTO `reports`(`id`, `user_id`, `model_type`, `model_id`,". (empty($report['body']) ? null : '`body`,') ." `status`, ".(empty($report['updated_at']) ? '`created_at`' : '`created_at`,')." ". (empty($report['updated_at']) ? null : '`updated_at`') .") VALUES ('". $report['id'] ."','". $report['user_id'] ."','" . $report['model_type'] . "','". $report['model_id'] ."',". (empty($report['body']) ? null : "'".$report['body']."',") ."'". $report['status'] ."',". (empty($report['updated_at']) ? "'".$report['created_at']."'" : "'".$report['created_at']."',") ."". (empty($report['updated_at']) ? null : "'".$report['updated_at']."'") ."); ";
    }
    return $insert;
}
$reports = getReports($db);
$result = forReports($reports);

$fp = fopen("files/reports.sql", "w");
fwrite($fp, $result);
fclose($fp);