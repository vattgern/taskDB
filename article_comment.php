<?php
/*
 * article_id
 * comment_id
 */

function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
function getArticleComments($db){
    $result = $db->query("SELECT * FROM `article_comment`");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $item){
        $insert .= "INSERT INTO `article_comment`(`article_id`, `comment_id`) VALUES ('{$item['article_id']}','{$item['comment_id']}'); ";
    }
    return $insert;
}

$db = connectOldDB();
$articleComments = getArticleComments($db);

$result = madeInsert($articleComments);

$fp = fopen("files/article_comments.sql", "w");
fwrite($fp, $result);
fclose($fp);