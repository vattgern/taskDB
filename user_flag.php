<?php
/*
 * user_id
 * flag_id
 */

function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
function getUserFlag($db){
    $result = $db->query("SELECT * FROM `user_flag`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $userFlag){
        $insert .= "INSERT INTO `user_flag`(`user_id`, `flag_id`) VALUES ('". $userFlag['user_id'] ."','". $userFlag['flag_id'] ."'); ";
    }
    return $insert;
}




$db = connectOldDB();
$userFlags = getUserFlag($db);
$result = madeInsert($userFlags);

$fp = fopen("files/user_flag.sql", "w");
fwrite($fp, $result);
fclose($fp);