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

// Vérifier si l'ID du livre est passé en paramètre
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    // Récupérer les détails du livre de la base de données
    $sql = "SELECT * FROM livres WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Livre non trouvé";
        exit;
    }
} else {
    echo "Aucun ID de livre spécifié";
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du livre</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
        <h1>B<span>i</span>B<span>L</span>i<span>o</span>.</h1> 
            <div class="ab">
                <a href="#accueil">Accueil</a>
                <a href="#apropos">A propos</a>
                <a href="#">Contact</a>
            </div>
            <div class="btn">
            <a href="deconnexion.php"><button>Déconnexion</button></a> 
            </div>     
    </nav>
    
        <h1>Détails du livre</h1>
    <main  id="search">
        <h2><?php echo $row["titre"]; ?></h2>
        <p><strong>Auteur:</strong> <?php echo $row["auteur"]; ?></p>
        <p><strong>Description:</strong> <?php echo $row["description"]; ?></p>
        <p><strong>Maison d'édition:</strong> <?php echo $row["maison_edition"]; ?></p>
        <p><strong>Nombre d'exemplaires:</strong> <?php echo $row["nombre_exemplaire"]; ?></p>
        <a href="index.php">⏪ Revenir à la page d'accueil</a>
    </main>
</body>
</html>
