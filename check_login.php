<?php
    session_start();

    $user = $_REQUEST["user"];
    $pwd = $_REQUEST["pwd"];
    $hash = hash('sha256', $pwd);
    // echo "User: $user Password: $pwd";

    include("settings.php");
    
    $conn = mysqli_connect($DB_SERVER, $DB_USER, $DB_PWD, $DB_NAME);

    // Для защиты от sql injection применяются
    // параметрические запросы. В PHP они называются
    // prepared statements. В выражении ниже ? - параметры
    // которые нужно передать
    $sql = "SELECT Login FROM Logins 
        WHERE Login=? 
        AND PwdHash=? 
    ";

    // Подготавливаем выражение к исполнению
    $stmt = mysqli_prepare($conn, $sql);
    // Передаем значения параметров (ss - типы string у двух параметров)
    mysqli_stmt_bind_param($stmt, "ss", $user, $hash);
    // Выполняем выражение
    mysqli_stmt_execute($stmt);
    // Получаем ссылку на результат и извлекаем его
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    // Собственно аутентификация
    if (is_null($data)){
        echo "Bad user or password!";
        echo '<meta http-equiv="refresh" content="3, URL=login.php" > ';
    }
    else {
        echo("<h2>Hello, $user!</h2>");
        $_SESSION["user"] = $user;
        echo '<meta http-equiv="refresh" content="3, URL=home1.php" > ';
    }

    mysqli_close($conn);
