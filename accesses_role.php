<?php
/*
 * NEW - OLD
 * ---------
 * access_id - access_id
 * role_id - role_id
 */

function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
function getAccessesRole($db){
    $result = $db->query("SELECT * FROM `access_role`; ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $accessRole){
        $insert .= "INSERT INTO `access_role`(`access_id`, `role_id`) VALUES ('" . $accessRole['access_id'] . "','" . $accessRole['role_id'] . "'); ";
    }
    return $insert;
}


$db = connectOldDB();
$roles = getAccessesRole($db);
$result = madeInsert($roles);

$fp = fopen("files/accesses_role.sql", "w");
fwrite($fp, $result);
fclose($fp);