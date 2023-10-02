<?php
/*
 * NEW - OLD
 * ---------
 * article_id - article_id
 * flag_id - flag_id
 */

function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
function getArticleFlag($db){
    $result = $db->query("SELECT * FROM `article_flag`; ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $articleFlag){
        $insert .= "INSERT INTO `article_flag`(`article_id`, `flag_id`) VALUES ('" . $articleFlag['article_id'] . "','" . $articleFlag['flag_id'] . "'); ";
    }
    return $insert;
}


$db = connectOldDB();
$articleFlags = getArticleFlag($db);
$result = madeInsert($articleFlags);

$fp = fopen("files/article_flag.sql", "w");
fwrite($fp, $result);
fclose($fp);