<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
echo '<h1>Получение данных и обновление базы</h1>';
require_once $_SERVER['DOCUMENT_ROOT'].'/database/db.php';
    $config = include $_SERVER['DOCUMENT_ROOT'].'\config\config.php';
    $db = new DB($config['host'], $config['db_name'], $config['user_name'], $config['password']);

    $posts_url = 'https://jsonplaceholder.typicode.com/posts';
    $comments_url = 'https://jsonplaceholder.typicode.com/comments';
    $posts_count = 0;
    $comment_count = 0;

    DB::sql('DELETE FROM comments');
    DB::sql('DELETE FROM posts');


    $data=get_page_content_curl($posts_url);
    $json_decode = json_decode($data, true);


    foreach ($json_decode as $item){
        $id = $item['id'];
        $user_id = $item['userId'];
        $title = $item['title'];
        $body = $item['body'];


        $query = 'INSERT INTO posts(
                        id,
                        user_id,
                        title,
                        body
                        ) VALUES(
                        :id,
                        :user_id,
                        :title,
                        :body
                        )';
        $args = [
            'id' => $id,
            'user_id' => $user_id,
            'title' => $title,
            'body' => $body
        ];

        [$query, $affected_rows] = DB::sql_returned_rows($query, $args);
        $posts_count+=$affected_rows;
    }

    $data=get_page_content_curl($comments_url);
    $json_decode = json_decode($data, true);
    foreach ($json_decode as $item){
        $id = $item['id'];
        $post_id = $item['postId'];
        $name = $item['name'];
        $email = $item['email'];
        $body = $item['body'];


        $query = 'INSERT INTO comments(
                                    id,
                                    post_id,
                                    name,
                                    email,
                                    body
                                    ) VALUES(
                                    :id,
                                    :post_id,
                                    :name,
                                    :email,
                                    :body
                                    )';
        $args = [
            'id' => $id,
            'post_id' => $post_id,
            'name' => $name,
            'email' => $email,
            'body' => $body
        ];

        [$result, $affected_rows] = DB::sql_returned_rows($query, $args);
        $comment_count+=$affected_rows;
    }

    debug_comments_and_posts([$posts_count, $comment_count]);

    echo 'Данные в таблице обнолены до актуальных';
    echo '<a href="../index.php">Вернуться на главную</a>';
