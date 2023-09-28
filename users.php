<?php
/*
 * NEW - OLD
 * ---------
 * id - id
 * login - login
 * name - name
 * lastname - lastname
 * gender - gender
 * location - location
 * status - status
 * ip - ip
 * rating - rating
 * score - score
 * email - email
 * email_info = email_info
 * website - website
 * password - password
 * avatar_path - avatar_path
 * cover_path - нету в старом бд
 * last_seen - last_seen
 * remember_token
 * email_verify_at - email_verify_at
 * created_at
 * updated_at
 * deleted_at
 */

// Подлючение к старой БД
function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
// Подключение к новой БД
function connectNewDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenews", 'root', '');
}
// Получаем пол-ей
function getUsers($db){
    $result = $db->query("SELECT * FROM users LIMIT 1");
    return $result->fetchAll();
}
// Записывает пол-ей в файл
function writeFile($arr){
    $fd = fopen('users.txt', 'w') or die('не удалось создать файл');
    foreach ($arr as $row){
        fwrite($fd, json_encode($row));
    }
    fclose($fd);
//    echo "Users записаны в файл";
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $user){
        if(empty($user['cover_path'])){
            $user['cover_path'] = null;
        }
        $insert .= "INSERT INTO `users`
                    (`id`, 
                     `". (empty($user['login']) ? '' : '`login`') ."`, 
                     `". (empty($user['name']) ? '' : '`name`') ."`, 
                     `". (empty($user['lastname']) ? '' : '`lastname`') ."`, 
                     `gender`, 
                     `". (empty($user['location']) ? '' : '`location`') ."`, 
                     `". (empty($user['status']) ? '' : '`status`') ."`, 
                     `". (empty($user['ip']) ? '' : '`ip`') ."`, 
                     `rating`, 
                     `score`, 
                     `". (empty($user['email']) ? '' : '`email`') ."`, 
                     `". (empty($user['email_info']) ? '' : '`email_info`') ."`, 
                     `". (empty($user['website']) ? '' : '`website`') ."`, 
                     `". (empty($user['password']) ? '' : '`password`') ."`, 
                     `". (empty($user['avatar_path']) ? '' : '`avatar_path`') ."`, 
                     `cover_path`, 
                     `last_seen`, 
                     `remember_token`, 
                     `email_verify_at`,
                     `created_at`,
                     `updated_at`) 
                    VALUES (
                        '". ($user['id']) ."',
                        '". (empty($user['login']) ? null : $user['login']) ."',
                        '". (empty($user['name']) ? null : $user['name']) ."',
                        '". (empty($user['lastname']) ? null : $user['lastname']) ."',
                        '". (empty($user['gender']) ? 'none' : $user['gender']) ."',
                        '". (empty($user['location']) ? null : $user['location']) ."',
                        '". (empty($user['status']) ? null : $user['status']) ."',
                        '". (empty($user['ip']) ? null : $user['ip']) ."',
                        '". (empty($user['rating']) ? 0 : $user['rating']) ."',
                        '". (empty($user['score']) ? 0 : $user['score']) ."',
                        '". (empty($user['email']) ? null : $user['email']) ."',
                        '". (empty($user['email_info']) ? null : $user['email_info']) ."',
                        '". (empty($user['website']) ? null : $user['website']) ."',
                        '". (empty($user['password']) ? null : $user['password']) ."',
                        '". (empty($user['avatar_path']) ? null : $user['avatar_path']) ."',
                        '". null ."',
                        '". (empty($user['last_seen']) ? null : $user['last_seen']) ."',
                        '". (empty($user['remember_token']) ? null : $user['remember_token']) ."',
                        '". (empty($user['email_verify_at']) ? null : $user['email_verify_at']) ."',
                        '". (empty($user['created_at']) ? null : $user['created_at']) ."',
                        '". (empty($user['updated_at']) ? null : $user['updated_at']) ."');";
    }
    return $insert;
}
//
//                     `deleted_at`
//,
//
//                        '". (empty($user['deleted_at']) ? '' : $user['deleted_at']) ."'



$db = connectOldDB();
$users= getUsers($db);
//writeFile($users);
$db = null;
$db = connectNewDB();
$request = madeInsert($users);
$db->query($request);
echo $request;