<?php
/*
 * NEW - OLD
 * --------
 * id - id
 * name - name
 * description - description
 */
function getFlags($db){
    $result = $db->query("SELECT * FROM `flags`; ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forFlags($arr){
    $insert = '';
    foreach ($arr as $flag){
        $insert .= "INSERT INTO `flags`(`id`, `name` " . (empty($flag['description']) ? null : ",`description`") .") VALUES ('" . $flag['id'] ."','" . $flag['name'] . "'" . (empty($flag['description']) ? null : ",'" . $flag['description'] . "'") . "); ";
    }
    return $insert;
}

$flags = getFlags($db);
$result = forFlags($flags);

$fp = fopen("files/flags.sql", "w");
fwrite($fp, $result);
fclose($fp);