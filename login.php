<html>
	<head> 
		<title>Логин</title>
		<meta charset="utf-8" />
		<style>
			input {
				width: 120px;
				margin-bottom: 6px;
				text-align: center;
			}
			
			button {
				width: 120px;
				margin-bottom: 6px;
			}	
		</style>
	</head>
	
	<body>
		<h1>Введите ваши данные</h1>
		<!-- <form action="check_login_vulnerable.php" method="post"> -->
		<form action="check_login.php" method="post">	
			<input name="user"/> <br />
			<input type="password" name="pwd"/> <br />
			<button name="go">Войти</button>
		</form>
		<form action="register.php" method="post">	
			<button name="go">Регистрация</button>
		</form>
	</body>
</html>