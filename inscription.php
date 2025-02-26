<?php
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

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'utilisateur'; // Valeur par défaut

    // Vérifier si l'email existe déjà
    $stmt = $conn->prepare("SELECT email FROM lecteurs WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = 'Email déjà utilisé.';
        header('Location: inscription.php');
        exit;
    } else {
        // Insérer les informations dans la base de données
        $stmt = $conn->prepare("INSERT INTO lecteurs (nom, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $nom, $email, $password, $role);
    
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Inscription réussie. Vous pouvez maintenant vous connecter.';
            header('Location: connection.php');
            exit;
        } else {
            $_SESSION['error'] = 'Erreur lors de l\'inscription. Veuillez réessayer.';
            header('Location: inscription.php');
            exit;
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription et Connexion</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            display: flex;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            width: 80%;
            max-width: 900px;
            margin-top: 250px;
        }
        .form-section {
            
            background-color:rgb(129, 123, 123);
            padding: 20px;
            flex: 1;
        }
        .form-section form {
            margin-bottom: 20px;
        }
        .form-section h2 {
            margin-top: 0;
        }
        .form-section label {
            display: block;
            margin-bottom: 5px;
        }
        .form-section input {
            width: 85%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-section button {
            width: 90%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            
        }
        .image-section {
            flex: 1;
            background: url('conne.jpg') no-repeat center center;
            background-size: cover;
        }
        header {
            width: 100%;
            padding: 10px 20px;
            background-color: #f5f5f5;
            color: white;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
        }
        .toggle-password {
            cursor: pointer;
        }
        .login-link {
            display: block;
            margin-top: 10px;
            text-align: center;
        }
        
    </style>
</head>
<body>
    <header>
    <nav class="navbar">
        <h1>B<span>i</span>B<span>L</span>i<span>o</span>.</h1> 
            <div class="ab">
                <a href="accueil.php">Accueil</a>
                <a href="#apropos">A propos</a>
                <a href="#">Contact</a>
            </div>
    </nav>
        <h1 style= "color: black ;" >Bienvenue à la Bibliothèque en Ligne</h1>
        <p style= "color: black ;">"Plongez-vous dans notre vaste collection, explorez, empruntez, et enrichissez votre expérience littéraire en quelques clics."</p>  
    </header>
    <div class="container">
        <div class="form-section">
            <section>
                <h2>Inscription</h2>
                <form action="inscription.php" method="POST">
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" id="name" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe:</label>
                        <input type="password" id="password" name="password" required>
                        <span class="toggle-password">👁️</span>
                    </div>
                    <button type="submit">S'inscrire</button>
                    <p>Si vous avez déjà un compte, vueillez vous connecter en cliquant ici: <a class="login-link" href="connection.php">Se connecter</a></p> 
                
                </form>
            </section>
        </div>
        <div class="image-section"></div>
    </div>

    <script>
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordField = document.querySelector('#password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        });
    </script>
</body>
</html>
