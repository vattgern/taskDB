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
function getAccesses($db){
    $result = $db->query("SELECT * FROM `accesses`; ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forAccesses($arr){
    $insert = '';
    foreach ($arr as $access){
        $insert .= "INSERT INTO `accesses`(`id`, `title`, `name`, `description`) VALUES ('" . $access['id'] . "','" . $access['title'] . "','" . $access['name'] . "','" . $access['description'] . "'); ";
    }
    return $insert;
}
$roles = getAccesses($db);
$result = forAccesses($roles);

$fp = fopen("files/accesses.sql", "w");
fwrite($fp, $result);
fclose($fp);