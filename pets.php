<?php include 'header.php'; ?>

<?php

// Adoptatu gabeko maskotak lortu
$sql = "SELECT * FROM pets  WHERE adopted = 0 ORDER BY entry_date DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$pets = $stmt->fetchAll();

// Adoptatu gabeko maskotak lortu
$sql = "SELECT * FROM pets  WHERE adopted = 1 ORDER BY entry_date DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$pets_adopted = $stmt->fetchAll();

?>


    <div class="container">
        <div class="content">
            <h2>ADOPTATZEKO DAUDEN MASKOTAK</h2>
            
            <?php if (count($pets) > 0): ?>
                <div class="pets-grid">
                    <?php 
                    $counter = 0;
                    foreach ($pets as $pet): 
                        // 3naka erakusteko kontrola
                        if ($counter > 0 && $counter % 3 === 0) {
                            echo '</div><div class="pets-grid">';
                        }
                        
                        echo showPetCard($pet);
                        $counter++;
                    endforeach; 
                    ?>
                </div>
            <?php else: ?>
                <div class="info-message">
                    Une honetan ez daukagu maskotarik adopziorako.
                </div>
            <?php endif; ?>
        </div>

        <div class="content">
            <h2>ADOPTATUTA DAUDEN MASKOTAK</h2>
            
            <?php if (count($pets_adopted) > 0): ?>
                <div class="pets-grid">
                    <?php 
                    $counter = 0;
                    foreach ($pets_adopted as $pet): 
                        // 3naka erakusteko kontrola
                        if ($counter > 0 && $counter % 3 === 0) {
                            echo '</div><div class="pets-grid">';
                        }
                        
                        echo showPetCard($pet);
                        $counter++;
                    endforeach; 
                    ?>
                </div>
            <?php else: ?>
                <div class="info-message">
                    Une honetan ez daukagu adoptatutako maskotarik.
                </div>
            <?php endif; ?>
        </div>


    </div>

<?php include 'footer.php'; ?>