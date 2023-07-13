<?php
    require __DIR__ . '/auth.php';
    $login = getUserLogin();
    

?>
<html>
<head>
    <title>Профиль</title>
</head>
<body>
    <?php if ($login == null): header('Location: /index.php'); else: ?>
        Добро пожаловать, <?= $login ?>
    <br>

    <form action="register.php" method="post" autocomplete="off">
				<label for="username">
				</label>
				<input type="text" name="username" placeholder="Логин" id="username" required>
				<label for="password">
				</label>
				<input type="password" name="password" placeholder="Пароль" id="password" required>
				<label for="password-repeat">
				</label>
				<input type="password" name="password-repeat" placeholder="Повторите пароль" id="password-repeat" required>
				<?php
    				if(isset($_SESSION['password-repeat-message']))
    				{
         				echo "<div id='error_msg'>".$_SESSION['password-repeat-message']."</div>";
         				unset($_SESSION['password-repeat-message']);
    				}
				?>
				<label for="email">
				</label>
				<input type="email" name="email" placeholder="Почтовый ящик" id="email" required>
				<?php
    				if(isset($_SESSION['email-unique-message']))
    				{
         				echo "<div id='error_msg'>".$_SESSION['email-unique-message']."</div>";
         				unset($_SESSION['email-unique-message']);
    				}
				?>
				<label for="phone">
				</label>
				<input type="phone" name="phone" placeholder="Номер телефона" id="phone" required>
				<?php
    				if(isset($_SESSION['phone-unique-message']))
    				{
         				echo "<div id='error_msg'>".$_SESSION['phone-unique-message']."</div>";
         				unset($_SESSION['phone-unique-message']);
    				}
				?>

				<input type="submit" name="register-button" value="Создать аккаунт">
			</form>
        <a href="/logout.php">Выйти</a>
    <?php endif; ?>
</body>
</html>