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

// Vérifier si l'ID de l'emprunt est passé en paramètre
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    // Supprimer l'emprunt de la base de données
    $sql = "DELETE FROM liste_lecture WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Emprunt supprimé avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Aucun ID d'emprunt spécifié";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un emprunt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Supprimer un emprunt</h1>
    </header>
    <main id="search">
        <a href="index.php">⏪ Revenir à la page d'accueil</a>
    </main>
</body>
</html>
