<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["is_admin"] != 1) {
    header("location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $question = trim($_POST["question"]);
    $options = isset($_POST['options']) ? implode(', ', $_POST['options']) : '';

    if (empty($question) || empty($options)) {
        echo "Вопрос и варианты ответов не должны быть пустыми!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO surveys (question, options) VALUES (:question, :options)");
        $stmt->bindParam(":question", $question);
        $stmt->bindParam(":options", $options);

        if ($stmt->execute()) {
            echo "Новая анкета создана успешно!";
        } else {
            echo "Ошибка при создании анкеты!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание новой анкеты</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Создать новую анкету</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="question">Вопрос:</label>
            <input type="text" name="question" id="question" required>
            <br><br>
            <label>Варианты ответов (разделенные запятыми):</label>
            <textarea name="options" id="" cols="30" rows="10" required></textarea>
            <br><br>
            <input type="submit" value="Создать анкету">
        </form>
    </div>
</body>
</html>
