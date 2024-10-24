<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        echo "Поля не должны быть пустыми!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);

        if ($stmt->execute()) {
            echo "Регистрация прошла успешно!";
        } else {
            echo "Ошибка при регистрации!";
        }
    }
}
?>

<h2>Регистрация</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="username">Имя пользователя:</label>
    <input type="text" name="username" id="username" required>
    <br><br>
    <label for="password">Пароль:</label>
    <input type="password" name="password" id="password" required>
    <br><br>
    <input type="submit" value="Зарегистрироваться">
</form>
