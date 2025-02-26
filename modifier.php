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

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
    $titre = $conn->real_escape_string($_POST["titre"]);
    $auteur = $conn->real_escape_string($_POST["auteur"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $maison_edition = $conn->real_escape_string($_POST["maison_edition"]);
    $nombre_exemplaire = intval($_POST["nombre_exemplaire"]);

    // Mettre à jour les informations du livre dans la base de données
    $sql = "UPDATE livres SET titre='$titre', auteur='$auteur', description='$description', maison_edition='$maison_edition', nombre_exemplaire=$nombre_exemplaire WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Livre modifié avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
} else {
    $id = intval($_GET["id"]);
    $sql = "SELECT * FROM livres WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $titre = $row["titre"];
        $auteur = $row["auteur"];
        $description = $row["description"];
        $maison_edition = $row["maison_edition"];
        $nombre_exemplaire = $row["nombre_exemplaire"];
    } else {
        echo "Livre non trouvé";
        exit;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un livre</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
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
        <h1>Modifier un livre</h1>
    </header>
    <main  id="search">
        <form action="modifier.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre" value="<?php echo $titre; ?>" required>
            <label for="auteur">Auteur:</label>
            <input type="text" id="auteur" name="auteur" value="<?php echo $auteur; ?>" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo $description; ?></textarea>
            <label for="maison_edition">Maison d'édition:</label>
            <input type="text" id="maison_edition" name="maison_edition" value="<?php echo $maison_edition; ?>" required>
            <label for="nombre_exemplaire">Nombre d'exemplaires:</label>
            <input type="number" id="nombre_exemplaire" name="nombre_exemplaire" value="<?php echo $nombre_exemplaire; ?>" required>
            <button type="submit">Modifier</button>
        </form>
        <a href="index.php">⏪ Revenir à la page d'accueil</a>
    </main>
</body>
</html>
