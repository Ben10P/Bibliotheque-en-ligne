<?php
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

    // Supprimer le livre de la base de données
    $sql = "DELETE FROM livres WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Livre supprimé avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Aucun ID de livre spécifié";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un livre</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Supprimer un livre</h1>
    </header>
    <main  id="search">
        <a href="index.php">⏪ Revenir à la page d'accueil</a>
    </main>
</body>
</html>
