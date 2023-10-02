<?php
/*
 * user_id
 * chapter_id
 */

function getChapterSub($db){
    $result = $db->query("SELECT * FROM `chapter_sub`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forChaptersSub($arr){
    $insert = '';
    foreach ($arr as $chapterSub){
        $insert .= "INSERT INTO `chapter_sub`(`user_id`, `chapter_id`) VALUES ('". $chapterSub['user_id'] ."','". $chapterSub['chapter_id'] ."'); ";
    }
    return $insert;
}
$chaptersSubs = getChapterSub($db);
$result = forChaptersSub($chaptersSubs);

$fp = fopen("files/chapter_sub.sql", "w");
fwrite($fp, $result);
fclose($fp);