<?php
// Connexion à la base de données
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque_db0";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $adminCode = isset($_POST['admin-code']) ? $_POST['admin-code'] : '';

    $correctAdminCode = '228';

    $stmt = $conn->prepare("SELECT * FROM lecteurs WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['password'] === $password && $user['role'] === $role) {
            $_SESSION['user'] = $user;
            $_SESSION['utilisateur_connecte'] = true;
            $_SESSION['id_lecteur'] = $user['id']; // Assigner l'ID du lecteur à la session
            if ($role === 'administrateur' && $adminCode === $correctAdminCode) {
                header('Location: index_admin.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $_SESSION['error'] = 'Mot de passe incorrect, rôle incorrect, ou code admin incorrect.';
        }
    } else {
        $_SESSION['error'] = 'Compte non trouvé. Vueillez vous inscrire .';
    }
    header('Location: connection.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color:rgb(109, 188, 231);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group select, .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <h1>B<span>i</span>B<span>L</span>i<span>o</span>.✨</h1> 
                <div class="ab">
                    <a href="accueil.php">Accueil</a>
                    <a href="#apropos">A propos</a>
                    <a href="#">Contact</a>
                </div>
        </nav>
    </header>

    <div class="form-container">

        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <form action="connection.php" method="POST">
        <h2>Connection</h2>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle:</label>
                <select id="role" name="role" required>
                    <option value="utilisateur">Utilisateur</option>
                    <option value="administrateur">Administrateur</option>
                </select>
            </div>
            <div class="form-group">
                <label for="admin-code">Code Admin (facultatif):</label>
                <input type="password" id="admin-code" name="admin-code">
            </div>
            <button type="submit">Se connecter</button>
            <p>Si vous n'avez pas encore un compte, vueillez vous inscrire ici: <a class="login-link" href="inscription.php">S' inscrire</a></p> 
        </form>
    </div>
</body>
</html>
