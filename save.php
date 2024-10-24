<?php
require_once 'config.php';

// Получаем данные из формы
$name = $_POST['name'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$languages = implode(', ', $_POST['languages']);
$country = $_POST['country'];
$message = $_POST['message'];

// Подготовленный запрос для вставки данных
$stmt = $pdo->prepare("INSERT INTO survey_responses (name, email, gender, languages, country, message) 
                       VALUES (:name, :email, :gender, :languages, :country, :message)");

$stmt->bindParam(':name', $name);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':gender', $gender);
$stmt->bindParam(':languages', $languages);
$stmt->bindParam(':country', $country);
$stmt->bindParam(':message', $message);

try {
    $stmt->execute();
    echo "Спасибо за участие! Ваши ответы успешно сохранены.";
} catch (PDOException $e) {
    echo "Не удалось сохранить ваши ответы: " . $e->getMessage();
}
?>
