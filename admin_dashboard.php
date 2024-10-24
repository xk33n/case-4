<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["is_admin"] != 1) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Административная панель</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Добро пожаловать в административную панель, <?= htmlspecialchars($_SESSION["username"]); ?>!</h1>
        <ul>
            <li><a href="create_survey.php">Создать новую анкету</a></li>
            <li><a href="manage_surveys.php">Управлять анкетами</a></li>
        </ul>
    </div>
</body>
</html>
