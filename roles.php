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
function getRoles($db){
    $result = $db->query("SELECT * FROM `roles` ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forRoles($arr){
    $insert = '';
    foreach ($arr as $role){
        $insert .= "INSERT INTO `roles`(`id`, `title`, `name`, `value`, `created_at`, `updated_at`) VALUES ('" . $role['id'] . "','" . $role['title'] . "','" . $role['name'] . "','" . $role['value'] . "','" . $role['created_at'] .  "','" . $role['updated_at'] .  "'); ";
    }
    return $insert;
}
$roles = getRoles($db);
$result = forRoles($roles);

$fp = fopen("files/roles.sql", "w");
fwrite($fp, $result);
fclose($fp);