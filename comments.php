<?php
/*
 * NEW - OLD
 * id - id
 * group - {
 *    group_type - group_type
 *    group_id - group_id
 * }
 * to - {
 *    to_type - group_type
 *    to_id - group_id
 * }
 * ip - ip
 * parent_id - parent_id
 * body - body
 * type - type
 * score - score
 * weight - weight
 * created_at
 * updated_at
 * deleted_at
 */

function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
// Подключение к новой БД
function connectNewDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenews", 'root', '');
}
function getCountComments($db){
    $result = $db->query("SELECT MAX(id) FROM `comments`; ");
    return $result->fetch();
}
function fetchingComments($db, $count){
    $index = 0;
    $from = 0;
    $to = 0;
    $arr = [];
    while ($index != $count){
        $from = $index;
        $to = $from + 300;
        $index += 300;
        $arr[] = getArticles($db, $from, $to);
        if($index > $count){
            $index = $count;
            $to = $index;
        }
    }
    return $arr;
}
function getArticles($db, $from, $to) {
    $result = $db->query("SELECT * FROM `comments` WHERE id > " . $from . " AND id <= " . $to);
    return $result->fetchAll();
}

function madeInsert($arr){
    $index = 1;
    foreach ($arr as $step){
        $fp = fopen("files/comments-".$index.'.sql', 'w');
        $insert = '';
        echo "Файл comments-{$index} создан<br>";
        foreach ($step as $comment){
            if(!empty($comment['body'])){
                $comment['body'] = htmlspecialchars($comment['body']);
            }
            if(!empty($comment['group_type'])){
                $comment['group_type'] = quotemeta($comment['group_type']);
            }
            if(!empty($comment['to_type'])){
                $comment['to_type'] = quotemeta($comment['to_type']);
            }

            $insert .= "INSERT INTO `comments` (
                       `id`, 
                       `group_type`,
                       `group_id`, 
                       " . (empty($comment['to_type']) ? null : '`to_type`,') . "
                       " . (empty($comment['to_id']) ? null : '`to_id`,') . "
                       `ip`, 
                       " . (empty($comment['parent_id']) ? null : '`parent_id`,') . "
                       `body`, 
                       `type`, 
                       `score`, 
                       `weight`, 
                       `created_at`, 
                       ". (empty($comment['updated_at']) ? null : (empty($comment['deleted_at']) ? '`updated_at`' : '`updated_at`,')) ." 
                       ". (empty($comment['deleted_at']) ? null : '`deleted_at`') .") 
                        VALUES (
                                '" . $comment['id'] ."',
                                '" . $comment['group_type'] ."',
                                '" . $comment['group_id'] ."',
                                " . (empty($comment['to_type']) ? null : "'" . $comment['to_type'] . "',") ."
                                " . (empty($comment['to_id']) ? null : "'" . $comment['to_id'] . "',") ."
                                '" . $comment['ip'] ."',
                                " . (empty($comment['parent_id']) ? null : "'" . $comment['parent_id'] . "',") ."
                                '" . $comment['body'] ."',
                                " . (empty($comment['type']) ? "'none'," : "'" . $comment['type'] . "',") ."
                                " . (empty($comment['score']) ? "'0'," : "'" . $comment['score'] . "',") ."
                                " . (empty($comment['weight']) ? "'0'," : "'" . $comment['weight'] . "',") ."
                                " . (empty($comment['created_at']) ? null : "'" . $comment['created_at'] . "',") ."
                                " . (empty($comment['updated_at']) ? null : (empty($comment['deleted_at']) ? "'" . $comment['updated_at'] . "'" : "'" . $comment['updated_at'] . "',")) ."
                                " . (empty($comment['deleted_at']) ? null : "'" . $comment['deleted_at'] . "'") ."); ";
        }
        fwrite($fp, $insert);
        fclose($fp);
        $index++;
    }
    echo "<br>Файлы Созданы<br>";
}



$db = connectOldDB();
$count = getCountComments($db);
$count = $count[0];

echo $count . "<br>";
$comments = fetchingComments($db, $count);

madeInsert($comments);