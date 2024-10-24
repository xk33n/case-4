<?php
// Настройки подключения к базе данных
$servername = "localhost";
$username = "username";
$password = "ypassword";
$dbname = "database";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получаем данные из формы
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $languages = implode(',', $_POST['languages']); // Преобразуем массив языков в строку
    $country = $_POST['country'];
    $message = $_POST['message'];

    // Подготовленный запрос для вставки данных
    $stmt = $conn->prepare("INSERT INTO responses (name, email, gender, languages, country, message) VALUES (:name, :email, :gender, :languages, :country, :message)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':languages', $languages);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        echo "Спасибо за участие! Ваши ответы успешно сохранены.";
    } else {
        throw new Exception("Не удалось сохранить ваши ответы.");
    }
} catch (PDOException $e) {
    echo "Ошибка при подключении к базе данных: " . $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
