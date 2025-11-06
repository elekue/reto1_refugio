<?php
include 'header.php';

// Ezabaketa mezua erakutsi
$deleted = $_GET['deleted'] ?? 0;

// Maskota guztiak lortu
$sql = "SELECT p.*, b.name as breed_name 
        FROM pets p 
        JOIN breeds b ON p.breed_id = b.id 
        ORDER BY p.entry_date DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$pets = $stmt->fetchAll();
?>


    <div class="container">
        <div class="content">
            <h2>CRUD - Maskoten Kudeaketa</h2>
            
            <?php if ($deleted): ?>
                <div class="success-message">
                    Maskota arrakastaz ezabatu da!
                </div>
            <?php endif; ?>

            <?php if (count($pets) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Irudia</th>
                            <th>Izena</th>
                            <th>Arraza</th>
                            <th>Adina</th>
                            <!-- <th>Tamaina</th>
                            <th>Sexua</th> -->
                            <th>Adoptatuta</th>
                            <th>Ekintzak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pets as $pet): ?>
                            <tr>
                                <td><?php echo $pet['id']; ?></td>
                                <td>
                                    <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($pet['name']); ?>">
                                </td>
                                <td><?php echo htmlspecialchars($pet['name']); ?></td>
                                <td><?php echo htmlspecialchars($pet['breed_name']); ?></td>
                                <td><?php echo $pet['age']; ?> urte</td>
                                <!-- <td><?php // echo htmlspecialchars($pet['size']); ?></td>
                                <td><?php // echo htmlspecialchars($pet['sex']); ?></td> -->
                                <td>
                                    <?php 
                                    if ($pet['adopted']) {
                                        echo '<span style="color: #27ae60; font-weight: bold;">BAI</span>';
                                    } else {
                                        echo '<span style="color: #3498db; font-weight: bold;">EZ</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="showpet.php?id=<?php echo $pet['id']; ?>" 
                                       class="btn" style="font-size: 0.85em; padding: 5px 10px;">
                                        Erakutsi
                                    </a>
                                    <a href="showpet.php?id=<?php echo $pet['id']; ?>&action=delete" 
                                       class="btn btn-danger" style="font-size: 0.85em; padding: 5px 10px;">
                                        Ezabatu
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="info-message">
                    Ez dago maskotarik datu-basean.
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php include 'footer.php'; ?>