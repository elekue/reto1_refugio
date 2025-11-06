<?php include 'header.php'; 

// Estadísticas
$petsByBreed = getPetsByBreed($conn);
$adoptionPercentage = getAdoptionPercentage($conn);
?>


    <div class="container">
        <div class="content">
            <h2>Bienvenid@ a nuestro refugio!!!</h2>
            <p>Aquí encontrarás mascotas que puedes llevar a tu casa. Nuestro objetivo es dar una segunda oportunidad a cada animal y reunirlos con familias adecuadas</p>
        </div>

        <div class="stats-container">
            
            <!-- Arrazen maskota kopurua -->
            <div class="stat-box">
                <h3>Razas y total mascotas</h3>
                <?php 
                if (!empty($petsByBreed)) {
                    foreach ($petsByBreed as $breed => $count) {
                        echo '<div class="stat-item">';
                        echo htmlspecialchars($breed) . ': <strong>' . $count . ' mascota(s)</strong>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No hay datos disponibles.</p>';
                }
                ?>
            </div>

            <!-- Adopzio ehunekoa -->
            <div class="stat-box">
                <h3>Estado de adopción</h3>
                <div class="stat-item">
                    <strong>Adoptados:</strong> 
                    <span class="percentage"><?php echo $adoptionPercentage['adoptados']; ?>%</span>
                </div>
                <div class="stat-item">
                    <strong>Disponible para adopción:</strong> 
                    <span class="percentage" style="color: #3498db;">
                        <?php echo $adoptionPercentage['disponibles']; ?>%
                    </span>
                </div>
            </div>
        </div>

  
    </div>

<?php include 'footer.php'; ?>