<?php
/*
 * NEW - OLD
 * ---------
 * id - id
 * title - title
 * url - url
 * description - description
 * avatar_path - avatar_path
 * cover_path - cover_path
 * is_visible - is_visible
 * rating - rating
 * score - score
 * created_at
 * updated_at
 * deleted_at
 */
function getChapters($db){
    $result = $db->query("SELECT * FROM `chapters`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forChapters($arr){
    $insert = '';
    foreach ($arr as $chapter){
        $insert .= "INSERT INTO `chapters`(`id`, `title`, `url`, `description`, `avatar_path`, `cover_path`, `is_visible`, `rating`, `score`, ". (empty($chapter['created_at']) ? null : (empty($chapter['updated_at']) ? '`created_at`' : '`created_at`,')) ." ". (empty($chapter['updated_at']) ? null : (empty($chapter['deleted_at']) ? '`updated_at`' : '`updated_at`,')) ." ". (empty($chapter['deleted_at']) ? null : '`deleted_at`') .") VALUES ('".$chapter['id']."','". $chapter['title'] ."','". $chapter['url'] ."','". $chapter['description'] ."','". $chapter['avatar_path'] ."','". $chapter['cover_path'] ."','". $chapter['is_visible'] ."','". $chapter['rating'] ."','". $chapter['score'] ."',". (empty($chapter['created_at']) ? null : (empty($chapter['updated_at']) ? "'". $chapter['created_at'] ."'" : ",'". $chapter['created_at'] ."',")) ."". (empty($chapter['updated_at']) ? null : (empty($chapter['deleted_at']) ? "'". $chapter['updated_at'] ."'" : "'". $chapter['updated_at'] ."',")) ."". (empty($chapter['deleted_at']) ? null : "'". $chapter['deleted_at'] ."'") ."); ";
    }
    return $insert;
}

$chapters = getChapters($db);
$result = forChapters($chapters);

$fp = fopen("files/chapters.sql", "w");
fwrite($fp, $result);
fclose($fp);