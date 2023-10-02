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
        $arr[] = getComments($db, $from, $to);
        if($index > $count){
            $index = $count;
            $to = $index;
        }
    }
    return $arr;
}
function getComments($db, $from, $to) {
    $result = $db->query("SELECT * FROM `comments` WHERE id > " . $from . " AND id <= " . $to);
    return $result->fetchAll();
}

function forComments($arr){
    $index = 1;
    foreach ($arr as $step){
        $fp = fopen("files/comments-".$index.'.sql', 'w');
        $insert = '';
        echo "Файл comments-{$index} создан<br>";
        foreach ($step as $comment){
            if(!empty($comment['body'])){
                $comment['body'] = htmlspecialchars($comment['body']);
                $comment['body'] = quotemeta($comment['body']);
            }
            if(!empty($comment['group_type'])){
                $comment['group_type'] = quotemeta($comment['group_type']);
            }
            if(!empty($comment['to_type'])){
                $comment['to_type'] = quotemeta($comment['to_type']);
            }
            $title = "`id`,`group_type`, `group_id`,";
            $content = "'{$comment['id']}', '{$comment['group_type']}', '{$comment['group_id']}', ";
            if(!empty($comment['to_type'])){
                $title .= "`to_type`,";
                $content .= "'{$comment['to_type']}',";
            }
            if(!empty($comment['to_id'])){
                $title .= "`to_id`,";
                $content .= "'{$comment['to_id']}',";
            }
            $title .= "`ip`,";
            $content .= "'{$comment['ip']}',";
            if(!empty($comment['parent_id'])){
                $title .= "`parent_id`,";
                $content .= "'{$comment['parent_id']}',";
            }
            $title .= "`body`, `type`, `score`, `weight`";
            $content .= "'{$comment['body']}', '{$comment['type']}', '{$comment['score']}', '{$comment['weight']}'";

            if(!empty($comment['created_at'])){
                $title .= ", `created_at`";
                $content .= ", '{$comment['created_at']}'";
            }
            if(!empty($comment['updated_at'])){
                $title .= ", `updated_at`";
                $content .= ", '{$comment['updated_at']}'";
            }
            if(!empty($comment['deleted_at'])){
                $title .= ", `deleted_at`";
                $content .= ", '{$comment['deleted_at']}'";
            }
            $insert .= "INSERT INTO `comments`({$title}) VALUES ({$content}); ";
        }
        fwrite($fp, $insert);
        fclose($fp);
        $index++;
    }
    echo "<br>Файлы Созданы<br>";
}

$count = getCountComments($db);
$count = $count[0];

echo $count . "<br>";
$comments = fetchingComments($db, $count);

forComments($comments);