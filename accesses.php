<?php
/*
 * NEW - OLD
 * ---------
 * id - id
 * title - title
 * name - name
 * description - description
 * value - value
 */

function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
function getAccesses($db){
    $result = $db->query("SELECT * FROM `accesses`; ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $access){
        $insert .= "INSERT INTO `accesses`(`id`, `title`, `name`, `description`) VALUES ('" . $access['id'] . "','" . $access['title'] . "','" . $access['name'] . "','" . $access['description'] . "'); ";
    }
    return $insert;
}


$db = connectOldDB();
$roles = getAccesses($db);
$result = madeInsert($roles);

$fp = fopen("files/accesses.sql", "w");
fwrite($fp, $result);
fclose($fp);