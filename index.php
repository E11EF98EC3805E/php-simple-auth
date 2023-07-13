<?php
    require __DIR__ . '/auth.php';
    $login = getUserLogin();

?>
<html>
<head>
    <title>Главная страница</title>
</head>
<body>
    <?php if ($login == null): ?>
        <a href="/login.php">Авторизуйтесь</a> или <a href="/register.php">зарегистрируйтесь</a>
    <?php else: ?>
        Добро пожаловать, <a href="/profile.php"> <?= getUser($login)["username"]; ?> </a>
    <br>
        <a href="/logout.php">Выйти</a>
    <?php endif; ?>
</body>
</html>