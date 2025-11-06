<?php
include 'header.php';

// ID MAscota
$petId = $_GET['id'] ?? 0;
$action = $_GET['action'] ?? '';

// Eliminar
if ($action === 'delete' && isset($_GET['confirm']) && $_GET['confirm'] === '1' && $isAdmin) {
    $sql = "DELETE FROM pets WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $petId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header('Location: petscrud.php?deleted=1');
        exit();
    }
}

// Aldaketa adoptatuta eremuan
if ($action === 'aldatu' && $isAdmin) {
    $sql = "UPDATE pets SET adopted = NOT adopted WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $petId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Redirijir
    header('Location: showpet.php?id=' . $petId);
    exit();
}

// Obtener datos mascota
$sql = "SELECT p.*, b.name as breed_name FROM pets p JOIN breeds b ON p.breed_id = b.id WHERE p.id = :id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $petId, PDO::PARAM_INT);
$stmt->execute();
$pet = $stmt->fetch();

// Si no existe la mascota
if (!$pet) {
    header('Location: pets.php');
    exit();
}

$isDeleteConfirmation = $action === 'delete';
?>


    <div class="container">
        <div class="content">
            <?php if ($isDeleteConfirmation && $isAdmin): ?>
                <h2 style="color: #e74c3c;">⚠️ Eliminar mascota</h2>
                <div class="error-message">
                    <strong>Está seguro que quiere dar de baja la mascota?</strong>
                </div>
            <?php else: ?>
                <h2><?php echo htmlspecialchars($pet['name']); ?></h2>
            <?php endif; ?>

            <div class="pet-details">
                <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" 
                     alt="<?php echo htmlspecialchars($pet['name']); ?>">
                
                <div class="pet-info">
                    <strong>Nombre:</strong> <?php echo htmlspecialchars($pet['name']); ?>
                </div>
                <div class="pet-info">
                    <strong>Raza:</strong> <?php echo htmlspecialchars($pet['breed_name']); ?>
                </div>
                <div class="pet-info">
                    <strong>Edad:</strong> <?php echo htmlspecialchars($pet['age']); ?> urte
                </div>
                <div class="pet-info">
                    <strong>Situación:</strong> 
                    <?php 
                    if ($pet['adopted']) {
                        echo '<span style="color: #27ae60; font-weight: bold;">Adoptado ✓</span>';
                    } else {
                        echo '<span style="color: #3498db; font-weight: bold;">Disponible</span>';
                    }
                    ?>
                </div>
                <div class="pet-info">
                    <strong>Fecha de entrada:</strong> <?php echo date('Y-m-d', strtotime($pet['entry_date'])); ?>
                </div>
                <div class="pet-info">
                    <strong>Descripción:</strong><br>
                    <?php echo nl2br(htmlspecialchars($pet['description'])); ?>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <?php if ($isDeleteConfirmation && $isAdmin): ?>
                    <!-- Ezabatzeko baieztapena -->
                    <a href="showpet.php?id=<?php echo $pet['id']; ?>&action=delete&confirm=1" 
                       class="btn btn-danger">
                        OK, dar de baja
                    </a>
                    <a href="petscrud.php" class="btn btn-secondary">
                        Volver
                    </a>
                <?php elseif ($isAdmin): ?>
                    <!-- Botones administrador -->
                    <a href="showpet.php?id=<?php echo $pet['id']; ?>&action=aldatu" 
                       class="btn btn-success">
                        Modificar (<?php echo $pet['adopted'] ? 'No adoptado' : 'Adoptado'; ?>)
                    </a>


                    <?php if ($pet['adopted']) { ?>
                        <a href="showpet.php?id=<?php echo $pet['id']; ?>&action=delete" class="btn btn-danger">
                            Eliminar
                        </a>
                    <?php } ?>

                    <a href="pets.php" class="btn btn-secondary">
                        Volver
                    </a>
                <?php else: ?>
                    <!-- Erabiltzaile normalaren botoia -->
                    <a href="pets.php" class="btn btn-secondary">
                        Volver
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>