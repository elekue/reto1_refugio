<?php
// Datu basearen konexioa PDO erabiliz
$host = 'localhost';
$dbname = 'exam_aterpetxea';
$username = 'root';
$password = 'root';

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $conn = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    error_log('DB konexio errorea: ' . $e->getMessage());
    die('Ezin izan da datu-basearekin konektatu.');
}

?>