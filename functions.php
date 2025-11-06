<?php


function getPetsByBreed($conn) {
    $sql = "SELECT b.name, COUNT(p.id) as total 
            FROM breeds b 
            LEFT JOIN pets p ON b.id = p.breed_id 
            GROUP BY b.name 
            ORDER BY b.name";

    $stmt = $conn->query($sql);
    
    // Array asoziatibo sortu
    $result = [];
    while ($row = $stmt->fetch()) {
        $result[$row['name']] = $row['total'];
    }
    
    return $result;
}


function getAdoptionPercentage($conn) {
    
    $sql = "SELECT adopted FROM pets";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $adoptatuta = 0;
    $eskuragarri = 0;
    $total = count($pets);

     foreach ($pets as $pet) {
        if ($pet['adopted']) {
            $adoptatuta++;
        } else {
            $eskuragarri++;
        }
    }

    $adoptatutaPercentage = $total > 0 ? round(($adoptatuta / $total) * 100) : 0;
    $eskuragarriPercentage = $total > 0 ? round(($eskuragarri / $total) * 100) : 0;

    return [
        'adoptatuak' => $adoptatutaPercentage,
        'eskuragarri' => $eskuragarriPercentage
    ];
}

/**
 * startSession - Saioa hasi erabiltzailea eta pasahitza balidatuz
 * @param string $username - Erabiltzailea
 * @param string $password - Pasahitza
 * @param PDO $conn - Datu-basearen konexioa
 * @return bool - true baldin eta datuak zuzenak badira
 */
function startSession($username, $password, $conn) {
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();

        // Pasahitza egiaztatu
        if (password_verify($password, $user['password'])) {
            // Saioa hasi
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['is_admin'] = true; // Erabiltzaile guztiak admin dira
            $_SESSION['username'] = $user['username'];

            return true;
        }
    }

    return false;
}


function validateSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}


function showPetCard($pet) {
    $imagePath = 'images/' . $pet['image'];
    $petId = $pet['id'];
    $petName = htmlspecialchars($pet['name']);

    $card = '<div class="pet-card">';
    $card .= '<img src="' . $imagePath . '" alt="' . $petName . '">';
    $card .= '<h3>' . $petName . '</h3>';
    $card .= '<a href="showpet.php?id=' . $petId . '" class="btn">Informazio gehiago ikusi</a>';
    $card .= '</div>';

    return $card;
}
?>