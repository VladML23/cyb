<?php

session_start();
if (!isset($_SESSION["user"])) {
    echo '<meta http-equiv="refresh" content="3, URL=../login.php" > ';
    die("требуется логин! Вы будете перенаправлены через несколько секунд");
}
$user = $_SESSION["user"];

header("Content-Type: application/json; charset=UTF-8");

$sql = "
    SELECT Login, CalcDate, Result FROM calcs 
    WHERE Login=?
    ORDER BY CalcDate DESC;     
";

// Логируем в БД
include("../settings.php");

// echo $sql;
$conn = mysqli_connect($DB_SERVER, $DB_USER, $DB_PWD, $DB_NAME);
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_all($result);

mysqli_close($conn);

// echo($data); //не выведет массив
// var_dump($data);

echo(json_encode($data));