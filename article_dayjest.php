<?php
/*
 * article_id - article_id
 * created_at
 * updated_at
 */

function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
function getArticleDayjest($db){
    $result = $db->query("SELECT * FROM `article_dayjest`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $dayjest){

        $insert .= "INSERT INTO `article_dayjest`(`article_id`, `created_at`, `updated_at`) VALUES ('". $dayjest['article_id'] ."','". $dayjest['created_at'] ."','". $dayjest['updated_at'] ."'); ";
    }
    return $insert;
}

$db = connectOldDB();
$articleDayjest = getArticleDayjest($db);
$result = madeInsert($articleDayjest);

$fp = fopen("files/article_dayjest.sql", "w");
fwrite($fp, $result);
fclose($fp);