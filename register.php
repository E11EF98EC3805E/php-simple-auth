<?php
session_start();
//connect to database
$conn = require __DIR__ . '/db_functions/conn.php';
if(isset($_POST['register-button']))
{
	$username = $_POST['username'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$passwordr = $_POST['password-repeat'];
	//echo "${username} ${email}  ${phone} ${password} ${passwordr}";

	$result =  $conn->query("SELECT id FROM user where email = '${email}'");
	//echo '</br>';
	$email_result = $result->fetch();

	$result =  $conn->query("SELECT id FROM user where phonenumber = '${phone}'");
	//echo '</br>';
	$phone_result = $result->fetch();
	//var_dump($result->fetch());

	if ($email_result)
	{
		$_SESSION['email-unique-message']="Почта уже используется";   
	}

	if ($phone_result)
	{
		$_SESSION['phone-unique-message']="Номер уже используется";   
	}

	if ($password!=$passwordr)
	{
		$_SESSION['password-repeat-message']="Пароли не совпадают";   
	}

	if (!isset($_SESSION['email-unique-message']) and !isset($_SESSION['phone-unique-message']) and !isset($_SESSION['password-repeat-message']))
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$sql=$conn->query("INSERT INTO user(username, email, phonenumber, pass) VALUES('$username','$email', '$phone', '$password')");
		$_SESSION['message']="Вы зарегистрированы!"; 
        $_SESSION['username']=$username;
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Регистрация</title>
	</head>
	<body>
		<div class="register">
			<h1>Регистрация</h1>
			<?php
    				if(isset($_SESSION['message']))
    				{
         				echo "<div id='error_msg'>".$_SESSION['message']."</div>";
         				unset($_SESSION['message']);
    				}
				?>
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
		</div>
	</body>
</html>