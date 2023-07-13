<?php
    require __DIR__ . '/auth.php';
	$conn = require __DIR__ . '/db_functions/conn.php';
    $login = getUserLogin();
	
	$userdata = getUser($login);
    if(isset($_POST['save-button']))
	{
		$username = $_POST['username'] == '' ? $userdata['username'] : $_POST['username'];
		$email = $_POST['email'] == '' ? $userdata['email'] : $_POST['email'];
		$old_email = $userdata['email'];
		$phone = $_POST['phone'] == '' ? $userdata['phonenumber'] : $_POST['phone'];
		$old_phone = $userdata['phonenumber'];
		$password = $_POST['password'] == '' ? $userdata['pass'] : $_POST['password'];
		//echo $username . '</br>' . $email . '</br>' . $phone . '</br>' . $password;
		$update_query =  $conn->query("UPDATE user set username = '${username}', email = '${email}', phonenumber = '${phone}', pass = '${password}' where email = '$old_email' and phonenumber = '$old_phone'")->execute();
		setcookie('login', $email, 0, '/');
		$userdata = getUser($email);
	}
?>
<html>
<head>
    <title>Профиль</title>
</head>
<body>
    <?php if ($login == null): header('Location: /index.php'); else: ?>
        Добро пожаловать, <?= $userdata["username"] ?>
    <br>

    <form action="profile.php" method="post" autocomplete="off">
				<label for="username">
					Юзернейм: <?php echo $userdata["username"] ?>
				</label>
				<input type="text" name="username" placeholder="Юзернейм" id="username"> </br>
				<label for="password"> Пароль:
				</label>
				<input type="password" name="password" placeholder="Пароль" id="password"> </br>
				<label for="email"> Почтовый ящик: <?php echo $userdata["email"] ?>
				</label>
				<input type="email" name="email" placeholder="Почтовый ящик" id="email"> 
				<?php
    				if(isset($_SESSION['email-unique-message']))
    				{
         				echo "<div id='error_msg'>".$_SESSION['email-unique-message']."</div>";
         				unset($_SESSION['email-unique-message']);
    				}
				?> </br>
				<label for="phone"> Номер телефона: <?php echo $userdata["phonenumber"] ?>
				</label>
				<input type="phone" name="phone" placeholder="Номер телефона" id="phone"> 
				<?php
    				if(isset($_SESSION['phone-unique-message']))
    				{
         				echo "<div id='error_msg'>".$_SESSION['phone-unique-message']."</div>";
         				unset($_SESSION['phone-unique-message']);
    				}
				?> </br>

				<input type="submit" name="save-button" value="Сохранить">
			</form>
        <a href="/logout.php">Выйти</a>
    <?php endif; ?>
</body>
</html>