<?php
require_once 'connection.php';
require_once 'functions.php';

session_start();
$isAdmin = false;
$isAdmin = validateSession();
$username = $_SESSION['username'] ?? null;

?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animalien Aterpetxea - Hasiera</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
    <header>
        <h1>🐾 Animalien Aterpetxea 🐾</h1>
    </header>
    <nav class="menu">
        <ul>
        <li><a href="index.php">Hasiera</a></li>
        <li><a href="pets.php">Maskotak</a></li>

    <?php if ($isAdmin) { ?>
            <!-- <li><a href="petscrud.php">CRUD</a></li> -->
            <li><a href="logout.php">Saioa Itxi</a></li>
            <li><a href="#" class="username">Kaixo <?php echo htmlspecialchars($username); ?></a></li>

        <?php } else { ?>
            <li><a href="sessionstart.php">Saioa Hasi</a></li>
        <?php } ?>
        
        </ul>
    </nav>
    
  