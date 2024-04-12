<!DOCTYPE html>
<html>
<body>

<?php
include ("settings.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        
        // Проверяем криптостойкость пароля
        if (strlen($password) < 8) {
            echo "Пароль должен быть не менее 8 символов в длинну.";
            exit;
        }
        if (!preg_match('/[0-9]/', $password)) {
            echo "Пароль должен содержать хотя бы одну цифру.";
            exit;
        }
        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            echo "Пароль должен содержать хотя бы один специальный символ.";
            exit;
        }
        if (!preg_match('/[a-zA-Z]/', $password)) {
            echo "Пароль должен содержать хотя бы одну букву.";
            exit;
        }
        $hash = hash('sha256', $password);

        
 // Создание и выполнение запроса к базе данных
 

 $link = mysqli_connect($DB_SERVER, $DB_USER, $DB_PWD, $DB_NAME);

 // Проверка наличия логина в базе данных перед добавлением
$query_check = "SELECT * FROM logins WHERE Login=?";
$stmt_check = mysqli_prepare($link, $query_check);
mysqli_stmt_bind_param($stmt_check, "s", $username);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if(mysqli_num_rows($result_check) > 0){
    echo "Логин уже существует. Пожалуйста, выберите другой логин.";
    exit;
}

 $query = "INSERT INTO logins (Login, PwdHash, Email) VALUES ('$username', '$hash', '$email')";
 mysqli_query($link, $query);

 // Перенаправление на страницу успеха
 header("Location: //127.0.0.1/cyb/success.php");
 exit;
 } 
}


?>

<form action="" method="post">
 <label for="username">Username:</label>
 <input type="text" id="username" name="username"><br><br>

 <label for="password">Password:</label>
 <input type="password" id="password" name="password"><br><br>

 <label for="email">Email:</label>
 <input type="email" id="email" name="email"><br><br>

 <button type="submit">Зарегистрироваться</button>
</form>

</body>
</html>