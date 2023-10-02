<?php
/*
 * user_id
 * chapter_id
 */

function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
function getUserFlag($db){
    $result = $db->query("SELECT * FROM `chapter_sub`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $chapterSub){
        $insert .= "INSERT INTO `chapter_sub`(`user_id`, `chapter_id`) VALUES ('". $chapterSub['user_id'] ."','". $chapterSub['chapter_id'] ."'); ";
    }
    return $insert;
}




$db = connectOldDB();
$chaptersSubs = getUserFlag($db);
$result = madeInsert($chaptersSubs);

$fp = fopen("files/chapter_sub.sql", "w");
fwrite($fp, $result);
fclose($fp);