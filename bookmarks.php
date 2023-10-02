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

function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
function getBookMarks($db){
    $result = $db->query("SELECT * FROM `bookmarks`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $bookmark){
        $bookmark['model_type'] = quotemeta($bookmark['model_type']);
        $insert .= "INSERT INTO `bookmarks`(`id`, `user_id`, `model_type`, `model_id`, `created_at`, `updated_at`) VALUES ('". $bookmark['id'] ."','". $bookmark['user_id'] ."','". $bookmark['model_type'] ."','". $bookmark['model_id'] ."','". $bookmark['created_at'] ."','". $bookmark['updated_at'] ."'); ";
    }
    return $insert;
}




$db = connectOldDB();
$bookmarks = getBookMarks($db);
$result = madeInsert($bookmarks);

$fp = fopen("files/bookmarks.sql", "w");
fwrite($fp, $result);
fclose($fp);