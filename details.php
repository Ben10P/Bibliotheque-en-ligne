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
    <header>
        <h1>Détails du livre</h1>
    </header>
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
