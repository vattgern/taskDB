<?php
/*
 * NEW - OLD
 * id - id
 * model - {
 *  model_type - model_type
 *  model_id - model_id
 * }
 * store - store
 * desc - desc
 * created_at
 * updated_at
 */

function getMedia($db){
    $result = $db->query("SELECT * FROM `media`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forMedia($arr){
    $insert = '';
    foreach ($arr as $data) {
        $data['model_type'] = quotemeta($data['model_type']);
        $insert .= "INSERT INTO `media`(`id`, `model_type`, `model_id`, `store`, ". (empty($data['desc']) ? null : '`desc`,') ." `created_at`, `updated_at`) VALUES ('". $data['id'] ."','". $data['model_type'] ."','". $data['model_id'] ."','". $data['store'] ."',". (empty($data['desc']) ? null : "'". $data['desc'] ."',") ."'". $data['created_at'] ."','". $data['updated_at'] ."'); ";
    }
    return $insert;
}

$media = getMedia($db);
$result = forMedia($media);

$fp = fopen("files/media.sql", "w");
fwrite($fp, $result);
fclose($fp);