<?php
    session_start();

    $user = $_REQUEST["user"];
    $pwd = $_REQUEST["pwd"];
    $hash = hash('sha256', $pwd);
    // echo "User: $user Password: $pwd";

    // Прототип аутентификации
    // if ($hash == "8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92") {
    //     echo "Привет, $user!";
    // }
    // else {
    //     echo "Неверный логин или пароль";
    // }

    // Здесь ниже вопиюшие нарушения правил безопасности:
    // 1. Опасность sql injection
    // 2. Слабый (даже предельно слабый) пароль
    // 3. Секреты в коде
    // 4. Нарушен принцип наименьших привелегий (root - супер администратор)
    
    // Ломает: tmp' OR (1=1) OR '1'='2
    $sql = "SELECT Login FROM Logins 
            WHERE Login='$user' 
            AND PwdHash='$hash' 
    ";
    // echo $sql;

    $conn = mysqli_connect("localhost", "root", "", "cyb");
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
    var_dump($data);

    if (is_null($data)){
        echo "Bad user or password!";
    }
    else {
        echo("<h2>Hello, $user!</h2>");
        $_SESSION["user"] = $user;
    }

    mysqli_close($conn);
