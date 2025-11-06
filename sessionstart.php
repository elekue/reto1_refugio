<?php
include 'header.php'; 

$error = '';

// Formularioa prozesatu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Mesedez, bete eremu guztiak.';
    } else {
        // Saioa hasi
        if (startSession($username, $password, $conn)) {
            header('Location: index.php');
            exit();
        } else {
            $error = 'Datu okerrak. Ez daukazu baimenik.';
        }
    }
}
?>


    <div class="container">
        <div class="content">
            <h2>Saioa Hasi</h2>
            
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Erabiltzailea:</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Pasahitza:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn">Saioa Hasi</button>
            </form>

            <div style="margin-top: 20px; padding: 15px; background-color: #ecf0f1; border-radius: 5px;">
                <p><strong>Probatzeko erabiltzaileak:</strong></p>
                <p>Erabiltzailea: <code>admin</code> | Pasahitza: <code>password</code></p>
            </div>
        </div>
    </div>

<?php include 'footer.php'; ?>