<?php
/*
 * article_id - article_id
 * created_at
 * updated_at
 */

function getArticleDayjest($db){
    $result = $db->query("SELECT * FROM `article_dayjest`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forArticleDayjest($arr){
    $insert = '';
    foreach ($arr as $dayjest){

        $insert .= "INSERT INTO `article_dayjest`(`article_id`, `created_at`, `updated_at`) VALUES ('". $dayjest['article_id'] ."','". $dayjest['created_at'] ."','". $dayjest['updated_at'] ."'); ";
    }
    return $insert;
}
$articleDayjest = getArticleDayjest($db);
$result = forArticleDayjest($articleDayjest);

$fp = fopen("files/article_dayjest.sql", "w");
fwrite($fp, $result);
fclose($fp);