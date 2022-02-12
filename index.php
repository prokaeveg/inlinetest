<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Посты и комментарии</title>
    <link rel="shortcut icon" href="#" />
</head>
<body>
    <form action="search.php" method="post">
        <input type="search" name="search" placeholder="Поиск" required>
        <input type="submit" value="Найти">
    </form>
    <form action="functions/update_db.php" method="post">
        <input type="submit" name="update_db" value="Обновить базу данных">
    </form>
</body>
</html>



