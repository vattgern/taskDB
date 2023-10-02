<?php
/*
 * NEW - OLD
 * ---------
 * id - id
 * title -title
 * name - name
 * description - description
 * value - value
 * created_at
 * updated_at
 */

function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
function getRoles($db){
    $result = $db->query("SELECT * FROM `roles` ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $role){
        $insert .= "INSERT INTO `roles`(`id`, `title`, `name`, `value`, `created_at`, `updated_at`) VALUES ('" . $role['id'] . "','" . $role['title'] . "','" . $role['name'] . "','" . $role['value'] . "','" . $role['created_at'] .  "','" . $role['updated_at'] .  "'); ";
    }
    return $insert;
}


$db = connectOldDB();
$roles = getRoles($db);
$result = madeInsert($roles);

$fp = fopen("files/roles.sql", "w");
fwrite($fp, $result);
fclose($fp);