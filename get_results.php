<?php
require_once 'config.php';

// Функция для подсчета количества элементов в массиве
function countArrayElements($array) {
    $counts = array_count_values($array);
    return $counts;
}

// Извлечение данных из базы данных
$sql = "SELECT gender, languages, country FROM survey_responses";
$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Подсчет количеств для каждого типа данных
$genders = [];
$languages = [];
$countries = [];
foreach ($data as $row) {
    $genders[] = $row['gender'];
    $languages = array_merge($languages, explode(', ', $row['languages']));
    $countries[] = $row['country'];
}

$genderCounts = countArrayElements($genders);
$languageCounts = countArrayElements($languages);
$countryCounts = countArrayElements($countries);

// Формирование результата
$result = [
    'genderCount' => $genderCounts,
    'languageCount' => $languageCounts,
    'countryCount' => $countryCounts
];

echo json_encode($result);
?>
