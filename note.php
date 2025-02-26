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

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inscription"])) {
    $nom = $conn->real_escape_string($_POST["nom"]);
    $email = $conn->real_escape_string($_POST["email"]);

    // Insérer le nouveau lecteur dans la base de données
    $sql = "INSERT INTO lecteurs (nom, email) VALUES ('$nom', '$email')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['utilisateur_connecte'] = true;
        $_SESSION['id_lecteur'] = $conn->insert_id;
        header("Location: incription.php");
        exit;
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["connexion"])) {
    $email = $conn->real_escape_string($_POST["email"]);

    // Vérifier si l'utilisateur existe dans la base de données
    $sql = "SELECT * FROM lecteurs WHERE email='$email'";
    $result = $conn->query($sql);
    $number = $_POST['number'];

    if ($result->num_rows > 0 && $number != 228) {
        $row = $result->fetch_assoc();
        $_SESSION['utilisateur_connecte'] = true;
        $_SESSION['id_lecteur'] = $row['id'];
        header("Location: index.php");
        exit;
    } else if ($result->num_rows > 0  && $number == 228) {
        $row = $result->fetch_assoc();
        $_SESSION['utilisateur_connecte'] = true;
        $_SESSION['id_lecteur'] = $row['id'];
        header("Location: index_admin.php");
        exit;
    }
    else {
        echo "Aucun compte trouvé avec cet email";
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
                <form action="connection.php" method="POST">
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
                    <a class="login-link" href="connection.php">Se connecter</a>
                
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
