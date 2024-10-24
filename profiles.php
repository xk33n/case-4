<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"];

$stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = :user_id");
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();
$profiles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои анкеты</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Привет, <?= htmlspecialchars($_SESSION["username"]); ?>! Это твои анкеты:</h1>

        <?php foreach ($profiles as $profile): ?>
            <div class="profile">
                <h3>Анкета от <?= date('Y-m-d H:i:s', strtotime($profile["created_at"])); ?></h3>
                <ul>
                    <li>Имя: <?= htmlspecialchars($profile["name"]); ?></li>
                    <li>Email: <?= htmlspecialchars($profile["email"]); ?></li>
                    <li>Пол: <?= htmlspecialchars($profile["gender"]); ?></li>
                    <li>Языки программирования: <?= htmlspecialchars($profile["languages"]); ?></li>
                    <li>Страна: <?= htmlspecialchars($profile["country"]); ?></li>
                    <li>Сообщение: <?= htmlspecialchars($profile["message"]); ?></li>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
