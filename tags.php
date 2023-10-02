<?php
/*
 * NEW - OLD
 * id - id
 * title - title
 * name - name
 * classname - classname
 * popular - popular
 * created_at
 * updated_at
 */
function getTags($db){
    $result = $db->query("SELECT * FROM `tags`");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forTags($arr){
    $insert = '';
    foreach ($arr as $tag){
        $insert .= "INSERT INTO `tags` (
                   `id`, 
                   `title`, 
                   ". (empty($tag['classname'] && $tag['created_at'] && $tag['updated_at']) && $tag['popular'] === false ? '`name`' : '`name`,') ." 
                   ". (empty($tag['classname']) ? null : '`classname`,') ."
                   ". (empty($tag['created_at']) ? '`popular`' : '`popular`,') ."  
                   ". (empty($tag['created_at']) ? null : (empty($tag['updated_at']) ? '`created_at`' : '`created_at`,')) ." 
                   ". (empty($tag['updated_at']) ? null : '`updated_at`') .") 
                    VALUES 
                        ('" . $tag['id'] . "',
                         '" . $tag['title'] . "',
                         " . "'" .$tag['name'] . (empty($tag['classname'] && $tag['created_at'] && $tag['updated_at']) && $tag['popular'] === false ? "'" : "',") ."
                         " . (empty($tag['classname']) ? null : "'" . $tag['classname'] . "',") . "
                         '" . $tag['popular'] . (empty($tag['created_at']) ? "'" : "',") . "
                         " . (empty($tag['created_at']) ? null : "'" . $tag['created_at'] . (empty($tag['updated_at'])? "'" : "',")) . "
                         " . (empty($tag['updated_at']) ? null : "'" . $tag['updated_at'] . "'") . "); ";
    }
    return $insert;
}

$tags = getTags($db);
$result = forTags($tags);

$fp = fopen("files/tags.sql", "w");
fwrite($fp, $result);
fclose($fp);