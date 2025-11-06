<?php include 'header.php'; 

// Estatistikak lortu
$petsByBreed = getPetsByBreed($conn);
$adoptionPercentage = getAdoptionPercentage($conn);
?>


    <div class="container">
        <div class="content">
            <h2>Ongi etorri gure aterpetxera!</h2>
            <p>Hemen aurkituko dituzu zure etxera eraman dezakezun maskota zoragarriak. Gure helburua animalia bakoitzari bigarren aukera bat ematea eta familia maitakorrekin elkartzea da.</p>
        </div>

        <div class="stats-container">
            
            <!-- Arrazen maskota kopurua -->
            <div class="stat-box">
                <h3>Arrazak eta maskota kopurua</h3>
                <?php 
                if (!empty($petsByBreed)) {
                    foreach ($petsByBreed as $breed => $count) {
                        echo '<div class="stat-item">';
                        echo htmlspecialchars($breed) . ': <strong>' . $count . ' maskota</strong>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Ez dago daturik eskuragarri.</p>';
                }
                ?>
            </div>

            <!-- Adopzio ehunekoa -->
            <div class="stat-box">
                <h3>Adopzio egoera</h3>
                <div class="stat-item">
                    <strong>Adoptatuak:</strong> 
                    <span class="percentage"><?php echo $adoptionPercentage['adoptatuak']; ?>%</span>
                </div>
                <div class="stat-item">
                    <strong>Adopziorako eskuragarri:</strong> 
                    <span class="percentage" style="color: #3498db;">
                        <?php echo $adoptionPercentage['eskuragarri']; ?>%
                    </span>
                </div>
            </div>
        </div>

  
    </div>

<?php include 'footer.php'; ?>