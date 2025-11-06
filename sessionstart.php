<?php
include 'header.php'; 

$error = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Rellene todos los campos, por favor.';
    } else {
        // Saioa hasi
        if (startSession($username, $password, $conn)) {
            header('Location: index.php');
            exit();
        } else {
            $error = 'Datos incorrectos. No tiene permiso.';
        }
    }
}
?>


    <div class="container">
        <div class="content">
            <h2>Inicio sesión</h2>
            
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn">Iniciar sesión</button>
            </form>

            <div style="margin-top: 20px; padding: 15px; background-color: #ecf0f1; border-radius: 5px;">
                <p><strong>Usuarios de prueba:</strong></p>
                <p>Usuario: <code>admin</code> | Contraseña: <code>password</code></p>
            </div>
        </div>
    </div>

<?php include 'footer.php'; ?>