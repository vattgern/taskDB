<?php
// Подлючение к старой БД
function connectOldDB(){
    return new PDO("mysql:host=localhost;port=3306;dbname=vapenew-old", 'root', '');
}
$db = connectOldDB();
require './users.php';
require './articles.php';
require  './tags.php';
require './article_tag.php';

require './roles.php';
require './accesses.php';
require './accesses_role.php';
require './user_role.php';
require './flags.php';
require  './article_flag.php';
require './comments.php';
require './reports.php';
require './user_sub.php';

require './bookmarks.php';
require './chapters.php';
require './article_chapter.php';

require './user_flag.php';
require './chapter_sub.php';
require './search_input.php';
require './media.php';
require './article_comment.php';
require './comment_likes.php';
require './article_dayjest.php';
require './verifications.php';