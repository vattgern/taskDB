<?php
/*
 * article_id
 * comment_id
 */
function getArticleComments($db){
    $result = $db->query("SELECT * FROM `article_comment`");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forArticleComments($arr){
    $insert = '';
    foreach ($arr as $item){
        $insert .= "INSERT INTO `article_comment`(`article_id`, `comment_id`) VALUES ('{$item['article_id']}','{$item['comment_id']}'); ";
    }
    return $insert;
}

$articleComments = getArticleComments($db);

$result = forArticleComments($articleComments);

$fp = fopen("files/article_comments.sql", "w");
fwrite($fp, $result);
fclose($fp);