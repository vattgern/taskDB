<?php
/*
 * NEW - OLD
 * ---------
 * user_id - user_id
 * sub_id - sub-id
 * [] - accepted
 * [] - created_at
 * [] - updated_at
 */
function getUserSub($db){
    $result = $db->query("SELECT * FROM `user_subs`; ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forUserSub($arr){
    $insert = '';
    foreach ($arr as $sub){
        $insert .= "INSERT INTO `user_sub`(`user_id`, `sub_id`) VALUES ('". $sub['user_id'] ."','". $sub['sub_id'] ."'); ";
    }
    return $insert;
}

$subs = getUserSub($db);
$result = forUserSub($subs);

$fp = fopen("files/user_sub.sql", "w");
fwrite($fp, $result);
fclose($fp);