<?php
/*
 * NEW - OLD
 * id - id
 * model - {
 *  model_type - model_type
 *  model_id - model_id
 * }
 * created_at
 * updated_at
 */
function getBookMarks($db){
    $result = $db->query("SELECT * FROM `bookmarks`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forBookmarks($arr){
    $insert = '';
    foreach ($arr as $bookmark){
        $bookmark['model_type'] = quotemeta($bookmark['model_type']);
        $insert .= "INSERT INTO `bookmarks`(`id`, `user_id`, `model_type`, `model_id`, `created_at`, `updated_at`) VALUES ('". $bookmark['id'] ."','". $bookmark['user_id'] ."','". $bookmark['model_type'] ."','". $bookmark['model_id'] ."','". $bookmark['created_at'] ."','". $bookmark['updated_at'] ."'); ";
    }
    return $insert;
}

$bookmarks = getBookMarks($db);
$result = forBookmarks($bookmarks);

$fp = fopen("files/bookmarks.sql", "w");
fwrite($fp, $result);
fclose($fp);