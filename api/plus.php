<?php

// Проверяем жетон безопасности (=сессионную переменную)
session_start();
if (!isset($_SESSION["user"])) {
    die("требуется логин!");
}

$csrf_token = $_REQUEST["csrf_token"];
if ($csrf_token != session_id()) {
    die("возможно, попытка CSRF");
}

$login = $_SESSION["user"];

// Получаем параметры запроса (например, из строки адреса, x и у)
$x = $_REQUEST["x"];
$y = $_REQUEST["y"];
$z = $x + $y;

// Логируем в БД
include("../settings.php");

// Это надо переделать на параметрические запросы
$sql = "
    INSERT INTO Calcs(Login,Result) 
    VALUES('$login', $z)
";

// echo $sql;
$conn = mysqli_connect($DB_SERVER, $DB_USER, $DB_PWD, $DB_NAME);
mysqli_query($conn, $sql);


// Имитация задержки
sleep(3);

// Вернули результат тому, кто его запросил (скорее всего, js'у)
echo($z);