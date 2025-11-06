<?php
// Datu basearen konexioa PDO erabiliz
$host = 'localhost';
$dbname = 'exam_refugio';
$username = 'root';
$password = '';

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $conn = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    error_log('Conexión errónea a la BBDD: ' . $e->getMessage());
    die('No se ha podido conectar a la BBDD.');
}

?>