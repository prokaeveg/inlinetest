<?php
    require_once __DIR__.'/functions/functions.php';

    if (!empty($_POST['search'])){
        $result = search($_POST['search']);
    }

    if (is_array($result)){
            foreach ($result as $item){
                echo "<h1>".$item['title']."</h1>";
                echo "<p>".$item['body']."</p>";
            }
    } else {
        echo $result;
    }
    ?>
    <button><a href="index.php">Возврат на главную страницу</a></button>
