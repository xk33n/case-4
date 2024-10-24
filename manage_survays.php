<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["is_admin"] != 1) {
    header("location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM surveys ORDER BY id DESC");
$surveys = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление анкетами</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Список анкет</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Вопрос</th>
                <th>Действия</th>
            </tr>
            <?php foreach ($surveys as $survey): ?>
                <tr>
                    <td><?= $survey["id"]; ?></td>
                    <td><?= htmlspecialchars($survey["question"]); ?></td>
                    <td>
                        <a href="edit_survey.php?id=<?= $survey["id"]; ?>">Редактировать</a> |
                        <a href="delete_survey.php?id=<?= $survey["id"]; ?>" onclick="return confirm('Вы уверены, что хотите удалить эту анкету?');">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
