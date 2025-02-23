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

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $conn->real_escape_string($_POST["titre"]);
    $auteur = $conn->real_escape_string($_POST["auteur"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $maison_edition = $conn->real_escape_string($_POST["maison_edition"]);
    $nombre_exemplaire = intval($_POST["nombre_exemplaire"]);

    // Insérer le nouveau livre dans la base de données
    $sql = "INSERT INTO livres (titre, auteur, description, maison_edition, nombre_exemplaire) VALUES ('$titre', '$auteur', '$description', '$maison_edition', $nombre_exemplaire)";

    if ($conn->query($sql) === TRUE) {
        echo "Nouveau livre ajouté avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un livre</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Ajouter un nouveau livre</h1>
    </header>
    <main  id="search">
        <form action="ajouter.php" method="POST">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre" required>
            <label for="auteur">Auteur:</label>
            <input type="text" id="auteur" name="auteur" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="maison_edition">Maison d'édition:</label>
            <input type="text" id="maison_edition" name="maison_edition" required>
            <label for="nombre_exemplaire">Nombre d'exemplaires:</label>
            <input type="number" id="nombre_exemplaire" name="nombre_exemplaire" required>
            <button type="submit">Ajouter</button>
        </form>
        <a href="index.php">⏪ Revenir à la page d'accueil</a>
    </main>
</body>
</html>
