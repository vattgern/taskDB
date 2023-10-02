<?php
/*
 * NEW - OLD
 * ---------
 * id - id
 * user_id - user_id
 * type - [] мб verify
 * pincode - pincode
 * created_at
 * updated_at
 */


function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
function getVerifications($db){
    $result = $db->query("SELECT * FROM `verifications`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $verification){
        $insert .= "INSERT INTO `verifications`(`id`, `user_id`, ". (empty($verification['pincode']) ? null : '`pincode`,') ." `created_at`, `updated_at`) VALUES ('". $verification['id'] ."','". $verification['user_id'] ."',". (empty($verification['pincode']) ? null : "'". $verification['pincode'] ."',") ." '". $verification['created_at'] ."','". $verification['updated_at'] ."'); ";
    }
    return $insert;
}

$db = connectOldDB();
$verifications = getVerifications($db);
$result = madeInsert($verifications);

$fp = fopen("files/verifications.sql", "w");
fwrite($fp, $result);
fclose($fp);