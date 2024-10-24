<?php
session_start();
require_once 'config.php';

$user_id = $_SESSION["id"];
$name = $_POST['name'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$languages = implode(', ', $_POST['languages']);
$country = $_POST['country'];
$message = $_POST['message'];

$stmt = $pdo->prepare("INSERT INTO profiles (user_id, name, email, gender, languages, country, message) 
                       VALUES (:user_id, :name, :email, :gender, :languages, :country, :message)");

$stmt->bindParam(':user_id', $user_id);
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
