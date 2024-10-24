<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["is_admin"] != 1) {
    header("location: login.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
    echo "Анкета не найдена!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $question = trim($_POST["question"]);
    $options = isset($_POST['options']) ? implode(', ', $_POST['options']) : '';

    if (empty($question) || empty($options)) {
        echo "Вопрос и варианты ответов не должны быть пустыми!";
    } else {
        $stmt = $pdo->prepare("UPDATE surveys SET question = :question, options = :options WHERE id = :id");
        $stmt->bindParam(":question", $question);
        $stmt->bindParam(":options", $options);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            echo "Анкета обновлена успешно!";
        } else {
            echo "Ошибка при обновлении анкеты!";
        }
    }
} else {
    $stmt = $pdo->prepare("SELECT * FROM surveys WHERE id = :id LIMIT 1");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $survey = $stmt->fetch();

    if (!$survey) {
        echo "Анкета не найдена!";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование анкеты</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Редактировать анкету</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$id; ?>" method="post">
            <label for="question">Вопрос:</label>
            <input type="text" name="question" id="question" value="<?= htmlspecialchars($survey["question"]); ?>" required>
            <br><br>
            <label>Варианты ответов (разделенные запятыми):</label>
            <textarea name="options" id="" cols="30" rows="10" required><?php echo implode(", ", explode(",", $survey["options"])); ?></textarea>
            <br><br>
            <input type="submit" value="Сохранить изменения">
        </form>
    </div>
</body>
</html>
