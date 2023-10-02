<?php
/*
 * NEW - OLD
 * id - id
 * user_id - user_id
 * input - input
 * created_at
 * updated_at
 * deleted_at
 */
function getSearchInput($db){
    $result = $db->query("SELECT * FROM `search_input`;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function forSearchInput($arr){
    $insert = '';
    foreach ($arr as $search){
        if(str_contains($search['input'], "'")){
            $search['input'] = htmlspecialchars($search['input']);
        } else {
            $search['input'] = quotemeta($search['input']);
        }
        $insert .= "INSERT INTO `search_input`(`id`, ". (empty($search['user_id']) ? null : '`user_id`,') ." `input`) VALUES ('".$search['id']."',". (empty($search['user_id']) ? null : "'".$search['user_id']."',") ."'". $search['input'] ."');  ";
    }
    return $insert;
}
$searches = getSearchInput($db);
$result = forSearchInput($searches);

$fp = fopen("files/search_input.sql", "w");
fwrite($fp, $result);
fclose($fp);