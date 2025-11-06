<?php
// Archivo que agrupa las funciones de consulta a la base de datos
//Función para calcular cuantas mascotas de cada raza para página inicial
/*le estás pasando la conexión a la función para que pueda ejecutar la consulta.
De otro modo, la función no sabría a qué base de datos conectarse.*/
function getPetsByBreed($conn) {
    $sql = "SELECT b.name, COUNT(p.id) as total 
            FROM breeds b 
            LEFT JOIN pets p ON b.id = p.breed_id 
            GROUP BY b.name 
            ORDER BY b.name";
/**Devuelve las 3 razas con más mascotas en el refugio. * Formato: ['nombre_raza' => cantidad] */

    $stmt = $conn->query($sql);
    
    // Crear array asociativo
    $result = [];
    //creo array y voy dejando la raza y el total de mascotas de esa raza
    while ($row = $stmt->fetch()) {
        $result[$row['name']] = $row['total'];//La clave es el nombre de la raza ($row['name']).
                                            //El valor es el número total de mascotas de esa raza ($row['total']).
    }
    
    return $result;
}
/**********OTRA FORMA*********************
 * $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $breeds = [];// Creamos un array vacío donde guardaremos los resultados finales
foreach ($result as $row) {// Recorremos todas las filas devueltas por la consulta
   
    $breeds[$row['breed_name']] = $row['total'];// Usamos el nombre de la raza como clave y la cantidad de mascotas como valor
}

return $breeds;// Devolvemos el array final con el formato ['nombre_raza' => cantidad]
**********************************************/

// funcion para calcular porcentajes de adopción para página inicial
function getAdoptionPercentage($conn) {
    
    $sql = "SELECT adopted FROM pets";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $adoptado = 0;
    $disponible = 0;
    $total = count($pets);

     foreach ($pets as $pet) {
        if ($pet['adopted']) {
            $adoptado++;
        } else {
            $disponible++;
        }
    }

    $adoptadoPercentage = $total > 0 ? round(($adoptado / $total) * 100) : 0;
    $disponiblePercentage = $total > 0 ? round(($disponible / $total) * 100) : 0;

    return [
        'adoptados' => $adoptadoPercentage,
        'disponibles' => $disponiblePercentage
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
//guardamos los valores en la variable SESSION
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
    $card .= '<a href="showpet.php?id=' . $petId . '" class="btn">Más información</a>';
    $card .= '</div>';

    return $card;
}
?>