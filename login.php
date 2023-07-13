<?php
define('SMARTCAPTCHA_SERVER_KEY', 'ysc2_XUncLh4PKTNCTAaEq4HSjOZT0Nv9nYBMaqm6Qajx8f867bcc');

function check_captcha($token) {
    $ch = curl_init();
    $args = http_build_query([
        "secret" => SMARTCAPTCHA_SERVER_KEY,
        "token" => $token,
        "ip" => $_SERVER['HTTP_X_FORWARDED_FOR'], // Нужно передать IP-адрес пользователя.
                                         // Способ получения IP-адреса пользователя зависит от вашего прокси.
    ]);
    curl_setopt($ch, CURLOPT_URL, "https://smartcaptcha.yandexcloud.net/validate?$args");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);

    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    var_dump($server_output);
    var_dump($httpcode);
    curl_close($ch);
    if ($httpcode !== 200) {
        echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
        return true;
    }
    $resp = json_decode($server_output);
    return $resp->status === "ok";
}



if (!empty($_POST)) {
    require __DIR__ . '/auth.php';

    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if (checkAuth($login, $password)) {
      if (check_captcha($token)) {
           setcookie('login', $login, 0, '/');
           setcookie('password', $password, 0, '/');
           //header('Location: /index.php');
       }
    } else {
        $error = 'Ошибка авторизации';
        $token = $_POST['smart-token'];
    }
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Авторизация</title>
        <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
	</head>
	<body>
		<div class="auth">
			<h1>Авторизация</h1>
			<?php if (isset($error)): ?>
                <span style="color: red;">
                <?= $error ?>
                </span>
            <?php endif; ?>
			<form action="login.php" method="post" autocomplete="off">
				<label for="login">
				</label>
				<input type="text" name="login" placeholder="Номер или адрес почты" id="login" required>
				<label for="password">
				</label>
				<input type="password" name="password" placeholder="Пароль" id="password" required>
                <div 
                    style="height: 100px"
                    id="captcha-container"
                    class="smart-captcha"
                    data-sitekey="ysc1_XUncLh4PKTNCTAaEq4HS34ecbyohd8BaNXbMKF9Ke634e275"
                ></div>
				<input type="submit" name="login-button" value="Войти в аккаунт">
			</form>
		</div>
	</body>
</html>				