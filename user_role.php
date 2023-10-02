<?php
/*
 * NEW - OLD
 * --------
 * user_id - user_id
 * role_id - role_id
 */
function getUserRole($db){
    $result = $db->query("SELECT * FROM `user_role`; ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forUserRoles($arr){
    $insert = '';
    foreach ($arr as $userRole){
        $insert .= "INSERT INTO `user_role`(`user_id`, `role_id`) VALUES ('". $userRole['user_id'] ."','". $userRole['role_id'] ."'); ";
    }
    return $insert;
}
$userRoles = getUserRole($db);
$result = forUserRoles($userRoles);

$fp = fopen("files/user_role.sql", "w");
fwrite($fp, $result);
fclose($fp);