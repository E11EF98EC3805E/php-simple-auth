<?php

setcookie('login', '$login', -10, '/');
setcookie('password' , '$password', -10, '/');
header('location: index.php' );