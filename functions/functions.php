<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/database/db.php';

function get_page_content_curl($url){
    $connection = curl_init($url);

    curl_setopt($connection,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($connection,CURLOPT_HEADER, 0);

    $data = curl_exec($connection);
    curl_close($connection);

    return $data;
}

function debug_comments_and_posts($data){
    if (count($data) == 2){
        echo "<script>console.log( 'Загружено " . $data[0]." записей и ".$data[1]." комментариев' );</script>";
    }
}

function search($search_text){
    $config = include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
    $db = new DB($config['host'], $config['db_name'], $config['user_name'], $config['password']);


    if (strlen($search_text) < 3){
        $returned_row = '<p>Слишком короткий текст запроса, минимальная длинна 3 символа</p>';
    } else if (strlen($search_text) > 256) {
        $returned_row = '<p>Слишком длинный текст запроса, максимальная длинна 255 символов</p>';
    } else {
        $query = 'SELECT c.body, p.title
              FROM comments c JOIN posts p ON p.id = c.post_id
              WHERE c.body LIKE :search';
        $args = [
            'search' => '%'.$search_text.'%'
        ];

        $returned_row = DB::getRows($query, $args);

        if (empty(($returned_row))){
            $returned_row = '<p>Ничего не найдено<p>';
        }
    }

    return $returned_row;
}
