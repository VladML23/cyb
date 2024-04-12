<?php
	session_start();
	if (!isset($_SESSION["user"])) {
		echo '<meta http-equiv="refresh" content="3, URL=login.php" > ';
		die("Вы успешно зарегистрированы! Вы будете перенаправлены через несколько секунд");
	}
?>