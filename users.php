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
    $result = $db->query("SELECT * FROM users");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
function madeInsert($arr){
    $insert = '';
    foreach ($arr as $user){
        if(!empty($user['login']) && stristr($user['login'],"'")){
            $user['login'] = htmlspecialchars($user['login']);
        }
        if(!empty($user['name']) && stristr($user['name'],"'")){
            $user['name'] = htmlspecialchars($user['name']);
        }
        if(!empty($user['lastname']) && stristr($user['lastname'],"'")){
            $user['lastname'] = htmlspecialchars($user['lastname']);
        }
        if(!empty($user['status']) && stristr($user['status'],"'")){
            $user['status'] = htmlspecialchars($user['status']);
        }
        $insert .= "INSERT INTO `users` (`id`,". (empty($user['login']) ? null : '`login`,') . (empty($user['name']) ? null : '`name`,') . (empty($user['lastname']) ? null : '`lastname`,') ." `gender`, ". (empty($user['location']) ? null : '`location`,') . (empty($user['status']) ? null : '`status`,') . (empty($user['ip']) ? null : '`ip`,') . " `rating`, `score`, `email`, " . (empty($user['email_info']) ? null : '`email_info`,') . (empty($user['website']) ? null : '`website`,') . (empty($user['password']) ? null : '`password`,') . (empty($user['avatar_path']) ? null : '`avatar_path`,') . (empty($user['last_seen']) ? null : '`last_seen`,') . (empty($user['remember_token']) ? null : '`remember_token`,') . (empty($user['email_verify_at']) ? null : '`email_verify_at`,') . (empty($user['created_at']) ? null : '`created_at`,') . (empty($user['updated_at']) ? null : (empty($user['deleted_at']) ? '`updated_at`' : '`updated_at`,')) . (empty($user['deleted_at']) ? null : '`deleted_at`') .") VALUES ('". ($user['id']) ."',". (empty($user['login']) ? null : "'" . $user['login'] . "',") . (empty($user['name']) ? null : "'" . $user['name'] . "',") . (empty($user['lastname']) ? null : "'" . $user['lastname'] . "',") . (empty($user['gender']) ? null : "'" . $user['gender'] . "',") . (empty($user['location']) ? "'ru'," : "'" . $user['location'] . "',") . (empty($user['status']) ? null : "'" . $user['status'] . "',") . (empty($user['ip']) ? null : "'" . $user['ip'] . "',") ."'". (empty($user['rating']) ? 0 : $user['rating']) ."','". (empty($user['score']) ? 0 : $user['score']) ."',". (empty($user['email']) ? "'test'," : "'" . $user['email'] . "',") . (empty($user['email_info']) ? null : "'" . $user['email_info'] . "',") . (empty($user['website']) ? null : "'" . $user['website'] . "',") . (empty($user['password']) ? null : "'" . $user['password'] . "',") . (empty($user['avatar_path']) ? null : "'" . $user['avatar_path'] . "',") . (empty($user['last_seen']) ? null : "'" . $user['last_seen'] . "',") . (empty($user['remember_token']) ? null : "'" . $user['remember_token'] . "',") . (empty($user['email_verify_at']) ? null : "'" . $user['email_verify_at'] . "',") . (empty($user['created_at']) ? null : "'" . $user['created_at'] . "',") . (empty($user['updated_at']) ? null : "'" . $user['updated_at'] . (empty($user['deleted_at']) ? "'" : "',")). (empty($user['deleted_at']) ? null : "'" . $user['deleted_at'] . "'") ."); ";
    }
    return $insert;
}

$db = connectOldDB();
$users= getUsers($db);
echo "<br>" . count($users) . "<br>";

$db = null;
$db = connectNewDB();

$result = madeInsert($users);

$fp = fopen("files/users.sql", "w");
fwrite($fp, $result);
fclose($fp);