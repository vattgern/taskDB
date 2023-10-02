<?php
/*
 * NEW - OLD
 * ---------
 * article_id - article_id
 * flag_id - flag_id
 */

function getArticleFlag($db){
    $result = $db->query("SELECT * FROM `article_flag`; ");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forArticleFlag($arr){
    $insert = '';
    foreach ($arr as $articleFlag){
        $insert .= "INSERT INTO `article_flag`(`article_id`, `flag_id`) VALUES ('" . $articleFlag['article_id'] . "','" . $articleFlag['flag_id'] . "'); ";
    }
    return $insert;
}

$articleFlags = getArticleFlag($db);
$result = forArticleFlag($articleFlags);

$fp = fopen("files/article_flag.sql", "w");
fwrite($fp, $result);
fclose($fp);