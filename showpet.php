<?php
include 'header.php';

// Maskotaren ID-a lortu
$petId = $_GET['id'] ?? 0;
$action = $_GET['action'] ?? '';

// Ezabatzeko ekintza
if ($action === 'delete' && isset($_GET['confirm']) && $_GET['confirm'] === '1' && $isAdmin) {
    $sql = "DELETE FROM pets WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $petId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header('Location: petscrud.php?deleted=1');
        exit();
    }
}

// Adoptatuta aldatzeko ekintza
if ($action === 'aldatu' && $isAdmin) {
    $sql = "UPDATE pets SET adopted = NOT adopted WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $petId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Birbideratu berriz orri honetara
    header('Location: showpet.php?id=' . $petId);
    exit();
}

// Maskotaren datuak lortu
$sql = "SELECT p.*, b.name as breed_name FROM pets p JOIN breeds b ON p.breed_id = b.id WHERE p.id = :id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $petId, PDO::PARAM_INT);
$stmt->execute();
$pet = $stmt->fetch();

// Maskota ez bada existitzen
if (!$pet) {
    header('Location: pets.php');
    exit();
}

$isDeleteConfirmation = $action === 'delete';
?>


    <div class="container">
        <div class="content">
            <?php if ($isDeleteConfirmation && $isAdmin): ?>
                <h2 style="color: #e74c3c;">⚠️ Ezabatu maskota</h2>
                <div class="error-message">
                    <strong>Ziur zaude maskota hau bajan eman nahi duzula?</strong>
                </div>
            <?php else: ?>
                <h2><?php echo htmlspecialchars($pet['name']); ?></h2>
            <?php endif; ?>

            <div class="pet-details">
                <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" 
                     alt="<?php echo htmlspecialchars($pet['name']); ?>">
                
                <div class="pet-info">
                    <strong>Izena:</strong> <?php echo htmlspecialchars($pet['name']); ?>
                </div>
                <div class="pet-info">
                    <strong>Arraza:</strong> <?php echo htmlspecialchars($pet['breed_name']); ?>
                </div>
                <div class="pet-info">
                    <strong>Adina:</strong> <?php echo htmlspecialchars($pet['age']); ?> urte
                </div>
                <div class="pet-info">
                    <strong>Egoera:</strong> 
                    <?php 
                    if ($pet['adopted']) {
                        echo '<span style="color: #27ae60; font-weight: bold;">Adoptatuta ✓</span>';
                    } else {
                        echo '<span style="color: #3498db; font-weight: bold;">Eskuragarri</span>';
                    }
                    ?>
                </div>
                <div class="pet-info">
                    <strong>Sarrera data:</strong> <?php echo date('Y-m-d', strtotime($pet['entry_date'])); ?>
                </div>
                <div class="pet-info">
                    <strong>Deskribapena:</strong><br>
                    <?php echo nl2br(htmlspecialchars($pet['description'])); ?>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <?php if ($isDeleteConfirmation && $isAdmin): ?>
                    <!-- Ezabatzeko baieztapena -->
                    <a href="showpet.php?id=<?php echo $pet['id']; ?>&action=delete&confirm=1" 
                       class="btn btn-danger">
                        Ados, baja eman
                    </a>
                    <a href="petscrud.php" class="btn btn-secondary">
                        Atzera itzuli
                    </a>
                <?php elseif ($isAdmin): ?>
                    <!-- Administratzailearen botoiak -->
                    <a href="showpet.php?id=<?php echo $pet['id']; ?>&action=aldatu" 
                       class="btn btn-success">
                        Aldatu (<?php echo $pet['adopted'] ? 'Ez adoptatua' : 'Adoptatua'; ?>)
                    </a>


                    <?php if ($pet['adopted']) { ?>
                        <a href="showpet.php?id=<?php echo $pet['id']; ?>&action=delete" class="btn btn-danger">
                            Ezabatu
                        </a>
                    <?php } ?>

                    <a href="pets.php" class="btn btn-secondary">
                        Atzera itzuli
                    </a>
                <?php else: ?>
                    <!-- Erabiltzaile normalaren botoia -->
                    <a href="pets.php" class="btn btn-secondary">
                        Atzera itzuli
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>