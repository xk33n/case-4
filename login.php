<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        echo "Поля не должны быть пустыми!";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            if (password_verify($password, $user["password"])) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user["id"];
                $_SESSION["username"] = $username;
                header("location: index.php");
            } else {
                echo "Неверный пароль!";
            }
        } else {
            echo "Пользователя с таким именем не существует!";
        }
    }
}
?>

<h2>Авторизация</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="username">Имя пользователя:</label>
    <input type="text" name="username" id="username" required>
    <br><br>
    <label for="password">Пароль:</label>
    <input type="password" name="password" id="password" required>
    <br><br>
    <input type="submit" value="Войти">
</form>
