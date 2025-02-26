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

// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $conn->real_escape_string($_POST["titre"]);
    $auteur = $conn->real_escape_string($_POST["auteur"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $maison_edition = $conn->real_escape_string($_POST["maison_edition"]);
    $nombre_exemplaire = intval($_POST["nombre_exemplaire"]);
    $image = $_FILES["image"]["name"];
    $target_dir = "C:\wamp64\www\Projet_biblio";
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifiez si le fichier est une image réelle
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insérer le nouveau livre dans la base de données avec seulement le nom de l'image
            $sql = "INSERT INTO livres (titre, auteur, description, maison_edition, nombre_exemplaire, image) VALUES ('$titre', '$auteur', '$description', '$maison_edition', $nombre_exemplaire, '$image')";

            if ($conn->query($sql) === TRUE) {
                echo "Nouveau livre ajouté avec succès";
            } else {
                echo "Erreur: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    } else {
        echo "Le fichier n'est pas une image.";
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
<nav class="navbar">
        <h1>B<span>i</span>B<span>L</span>i<span>o</span>.</h1> 
            <div class="ab">
                <a href="#accueil">Accueil</a>
                <a href="#apropos">A propos</a>
                <a href="#">Contact</a>
            </div>
            <div class="btn">
            <a href="deconnexion.php"><button>Déconnexion</button></a> </a> 
            </div> 
               
    </nav>

    <h1>Ajouter un nouveau livre</h1> 
    <main  id="search">
        <form action="ajouter.php" method="POST" enctype="multipart/form-data">
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
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <button type="submit">Ajouter</button>
        </form>
        <a href="index.php">⏪ Revenir à la page d'accueil</a>
    </main>
</body>
</html>
