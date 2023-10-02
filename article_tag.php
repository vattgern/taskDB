<?php
/*
 * NEW - OLD
 * ---------
 * tag_id - tag_id
 * article_id - article_id
 */
function getArticleTag($db){
    $result = $db->query("SELECT * FROM `article_tag`");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forArticleTags($arr){
    $insert = '';
    foreach ($arr as $item){
        $insert .= "INSERT INTO `article_tag`(`tag_id`, `article_id`) VALUES ('" . $item['tag_id'] ."','". $item['article_id'] ."'); ";
    }
    return $insert;
}
$articleTag = getArticleTag($db);

$result = forArticleTags($articleTag);

$fp = fopen("files/article_tag.sql", "w");
fwrite($fp, $result);
fclose($fp);