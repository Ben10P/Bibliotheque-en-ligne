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

// Récupérer l'ID du lecteur (utilisateur connecté)
$id_lecteur = 1; // Remplacez cette valeur par l'ID du lecteur connecté

// Vérifier si un livre doit être retiré de la liste de lecture
if (isset($_GET["retirer_id"])) {
    $retirer_id = intval($_GET["retirer_id"]);
    $sql = "DELETE FROM wishlist WHERE id_livre=$retirer_id AND id_lecteur=$id_lecteur";

    if ($conn->query($sql) === TRUE) {
        echo "Livre retiré de la liste de lecture";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

// Récupérer la liste de lecture de l'utilisateur
$sql = "SELECT l.id, l.titre, l.auteur FROM wishlist w INNER JOIN livres l ON w.id_livre = l.id WHERE w.id_lecteur=$id_lecteur";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de lecture</title>
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
    <header>
        <h1>Liste de lecture</h1>
    </header>
    <main  id="search">
        <?php
        if ($result->num_rows > 0) {
            // Afficher la liste de lecture
            echo "<ul>";
            while($row = $result->fetch_assoc()) {
                echo "<li><strong>" . $row["titre"]. "</strong> par " . $row["auteur"]. " <a href='wishlist.php?retirer_id=" . $row["id"] . "'>Retirer</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Votre liste de lecture est vide</p>";
        }
        ?>
        <a href="index.php">⏪ Revenir à la page d'accueil</a>
    </main>
</body>
</html>

<?php
$conn->close();
?>
