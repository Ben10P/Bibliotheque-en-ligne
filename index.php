<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_connecte']) || $_SESSION['utilisateur_connecte'] !== true) {
    // Rediriger vers la page d'inscription si l'utilisateur n'est pas connecté
    header("Location: inscription.php");
    exit;
}

// Connexion à la base de données
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

// Récupérer l'ID du lecteur connecté
$id_lecteur = $_SESSION['id_lecteur'];

// Récupérer le nombre de livres dans le wishlist
$sql = "SELECT COUNT(*) as count FROM wishlist WHERE id_lecteur = $id_lecteur";
$result = $conn->query($sql);

$nombre_livres_wishlist = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre_livres_wishlist = $row['count'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque en ligne</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .user-info {
            display: flex;
            align-items: left;
            float: right;
            margin-top: 30px;
        }
        .user-icon, .wishlist-icon {
            margin-left: 20px;
            position: relative;
            margin-right: 30px;
        }
        .user-icon::after {
            content: '';
            width: 10px;
            height: 10px;
            background-color: green;
            border-radius: 50%;
            position: absolute;
            top: 0;
            right: 0;
        }
       .ef {
        align-items: center;
       }
    </style>
</head>
<body>
    <header>
        <h1>Bienvenue à la Bibliothèque en Ligne</h1>
        <p>"Plongez-vous dans notre vaste collection, explorez, empruntez, et enrichissez votre expérience littéraire en quelques clics."</p>
        <nav>
            <div class="user-info">
                <div class="user-icon">
                    <img style = "background-color: white;" src="user-icon2.png" alt="Utilisateur connecté">
                </div>
                
                <div>
                    <a href="deconnexion.php"><button>Déconnexion</button></a> 
                </div>
                  
            </div>
        </nav>
        
    </header>
    <main id= "search" style = "margin-top: 50px;">
        <section id="search">
            <h2>Recherche de livres</h2>
            <form action="resultats.php" method="GET">
                <label for="titre">Titre:</label>
                <input type="text" id="titre" name="titre">
                <label for="auteur">Auteur:</label>
                <input type="text" id="auteur" name="auteur">
                <button type="submit">Rechercher</button>
            </form>
            <div >
                
        </div>
        </section>
        <section class= "ef">
            <a href="ajouter.php"><button>Ajouter un livre</button></a>
            <a href="emprunter.php"><button>Emprunter un livre</button></a>
            <a href="emprunts.php"><button>Gérer les emprunts</button></a>
            <a href="wishlist.php"><button>Ma liste de lecture</button></a>
        </section>
    </main>
</body>
</html>
