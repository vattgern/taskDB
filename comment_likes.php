<?php
/*
 * user_id - user_id
 * comment_id - comment_id
 * created_at
 * updated_at
 */
function getCommentLikes($db){
    $result = $db->query("SELECT * FROM `comment_likes`");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forCommentLikes($arr){
    $insert = '';
    foreach ($arr as $item){
        $insert .= "INSERT INTO `comment_likes`(`user_id`, `comment_id`) VALUES ('{$item['user_id']}','{$item['comment_id']}'); ";
    }
    return $insert;
}

$commentsLikes = getCommentLikes($db);

$result = forCommentLikes($commentsLikes);

$fp = fopen("files/comment_likes.sql", "w");
fwrite($fp, $result);
fclose($fp);