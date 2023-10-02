<?php
/*
 * NEW - OLD
 * --------
 * id - id
 * name - name
 * description - description
 */

function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
function getFlags($db){
    $result = $db->query("SELECT * FROM `flags`; ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $flag){
        $insert .= "INSERT INTO `flags`(`id`, `name` " . (empty($flag['description']) ? null : ",`description`") .") VALUES ('" . $flag['id'] ."','" . $flag['name'] . "'" . (empty($flag['description']) ? null : ",'" . $flag['description'] . "'") . "); ";
    }
    return $insert;
}


$db = connectOldDB();
$flags = getFlags($db);
$result = madeInsert($flags);

$fp = fopen("files/flags.sql", "w");
fwrite($fp, $result);
fclose($fp);