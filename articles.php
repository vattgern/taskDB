<?php
/*
 * NEW - OLD
 * ---------
 * id - id
 * user_id - user_id
 * user_ip - user_ip
 * public_id - public_id
 * title - title
 * body - body
 * teaser - teaser
 * clear_data - clear_data
 * url - url
 * rating - rating
 * score - score
 * views - views
 * cover - cover
 * publish - publish
 * type - type
 * weight - weight
 * fixed - fixed
 * pool_mode - pool_mode
 * check_solution - check_solution
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
function getCountArticles($db){
    $result = $db->query("SELECT MAX(id) FROM `articles`; ");
    return $result->fetch();
}
function fetchingArticles($db, $count){
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
    $result = $db->query("SELECT * FROM `articles` WHERE id > " . $from . " AND id <= " . $to);
    return $result->fetchAll();
}

function madeInsert($arr){
    $index = 1;
    foreach ($arr as $step){
        $fp = fopen("files/articles-".$index.'.sql', 'w');
        $insert = '';
        echo "Файл articles-{$index} создан<br>";
        foreach ($step as $article){
            if(!empty($article['title'])){
                $article['title'] = htmlspecialchars($article['title']);
            }
            if(!empty($article['body'])){
                $article['body'] = htmlspecialchars($article['body']);
            }
            if(!empty($article['teaser'])){
                $article['teaser'] = htmlspecialchars($article['teaser']);
            }
            if(!empty($article['clear_data'])){
                $article['clear_data'] = htmlspecialchars($article['clear_data']);
            }
            $insert .= "INSERT INTO `articles` (`id`, `user_id`, ". (empty($article['user_ip']) ? null : '`user_ip`,') ." ". (empty($article['public_id']) ? null : '`public_id`,') ." ". (empty($article['title']) ? null : '`title`,') ." ". (empty($article['body']) ? null : '`body`,') ."  ". (empty($article['teaser']) ? null : '`teaser`,') ."  ". (empty($article['clear_data']) ? null : '`clear_data`,') ."   ". (empty($article['url']) ? null : '`url`,') ." `rating`,`score`,`views`, ". (empty($article['cover']) ? null : '`cover`,') ." `publish`, `type`, `weight`, `fixed`, `pool_mode`, `check_solution`,  ". (empty($article['created_at']) ? null : (empty($article['updated_at']) ? '`created_at`' : '`created_at`,')) ." ". (empty($article['updated_at']) ? null : (empty($article['deleted_at']) ? '`updated_at`' : '`updated_at`,')) ." ". (empty($article['deleted_at']) ? null : '`deleted_at`') ." ) VALUES ( '". $article['id'] ."', '" . $article['user_id'] ."', " . (empty($article['user_ip']) ? null : "'" . $article['user_ip'] . "',") ." " . (empty($article['title']) ? null : "'" . $article['title'] . "',") ." " . (empty($article['body']) ? null : "'" . $article['body'] . "',") ." " . (empty($article['teaser']) ? null : "'" . $article['teaser'] . "',") ." " . (empty($article['clear_data']) ? null : "'" . $article['clear_data'] . "',") ." " . (empty($article['url']) ? null : "'" . $article['url'] . "',") ." " . (empty($article['rating']) ? "'" . 0 . "'," : "'" . $article['rating'] . "',") ." " . (empty($article['score']) ? "'" . 0 . "'," : "'" . $article['score'] . "',") ." " . (empty($article['views']) ? "'" . 0 . "'," : "'" . $article['views'] . "',") ." " . (empty($article['cover']) ? null : "'" . $article['cover'] . "',") ." " . (empty($article['publish']) ? "'prod'," : "'" . $article['publish'] . "',") ." " . (empty($article['type']) ? "'article'," : "'" . $article['type'] . "',") ." " . (empty($article['weight']) ? "'" . 0 . "'," : "'" . $article['weight'] . "',") ." " . (empty($article['fixed']) ? "'" . 0 . "'," : "'" . $article['fixed'] . "',") ." " . (empty($article['pool_mode']) ? "'vapenews'," : "'" . $article['pool_mode'] . "',") ." " . (empty($article['check_solution']) ? "'unchecked'," : "'" . $article['check_solution'] . "',") ." ". (empty($article['created_at']) ? null : (empty($article['updated_at']) ? "'". $article['created_at'] ."'" : "'". $article['created_at'] ."',")) ." ". (empty($article['updated_at']) ? null : (empty($article['deleted_at']) ? "'". $article['updated_at'] ."'" : "'". $article['updated_at'] ."',")) ." ". (empty($article['deleted_at']) ? null : "`" . $article['deleted_at'] ."`") ." ); ";
        }
        fwrite($fp, $insert);
        fclose($fp);
        $index++;
    }
    echo "<br>Файлы Созданы<br>";
}



$db = connectOldDB();
$count = getCountArticles($db);
$count = $count[0];

echo $count . "<br>";
$articles = fetchingArticles($db, $count);
echo "<br>Загрузка прошла<br>";

madeInsert($articles);
