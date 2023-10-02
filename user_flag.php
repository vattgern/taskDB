<?php
/*
 * user_id
 * flag_id
 */

function getUserFlag($db){
    $result = $db->query("SELECT * FROM `user_flag`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forUserFlag($arr){
    $insert = '';
    foreach ($arr as $userFlag){
        $insert .= "INSERT INTO `user_flag`(`user_id`, `flag_id`) VALUES ('". $userFlag['user_id'] ."','". $userFlag['flag_id'] ."'); ";
    }
    return $insert;
}

$userFlags = getUserFlag($db);
$result = forUserFlag($userFlags);

$fp = fopen("files/user_flag.sql", "w");
fwrite($fp, $result);
fclose($fp);