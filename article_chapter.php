<?php
/*
 * NEW - OLD
 * ---------
 * article_id - article_id
 * chapter_id - chapter_id
 */

function getArticleChapters($db){
    $result = $db->query("SELECT * FROM `article_chapter`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forArtileChapters($arr){
    $insert = '';
    foreach ($arr as $article_chapter){
        $insert .= "INSERT INTO `article_chapter`(`article_id`, `chapter_id`) VALUES ('". $article_chapter['article_id'] ."','". $article_chapter['chapter_id'] ."'); ";
    }
    return $insert;
}
$articles_chapters = getArticleChapters($db);
$result = forArtileChapters($articles_chapters);

$fp = fopen("files/article_chapters.sql", "w");
fwrite($fp, $result);
fclose($fp);