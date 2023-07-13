<?php
    require __DIR__ . '/auth.php';
    $login = getUserLogin();
    //echo 'User IP - ' . getHostByName(getHostName());
    //echo 'User IP - ' . $_SERVER['HTTP_CLIENT_IP'];

?>
<html>
<head>
    <title>Главная страница</title>
</head>
<body>
    <?php if ($login == null): ?>
        <a href="/login.php">Авторизуйтесь</a> или <a href="/register.php">зарегистрируйтесь</a>
    <?php else: ?>
        Добро пожаловать, <?= $login ?>
    <br>
        <a href="/logout.php">Выйти</a>
    <?php endif; ?>
</body>
</html>