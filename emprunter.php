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
    $id_livre = intval($_POST["id_livre"]);
    $id_lecteur = intval($_POST["id_lecteur"]);
    $date_emprunt = $conn->real_escape_string($_POST["date_emprunt"]);
    $date_retour = $conn->real_escape_string($_POST["date_retour"]);

    // Enregistrer l'emprunt dans la base de données
    $sql = "INSERT INTO liste_lecture (id_livre, id_lecteur, date_emprunt, date_retour) VALUES ($id_livre, $id_lecteur, '$date_emprunt', '$date_retour')";

    if ($conn->query($sql) === TRUE) {
        echo "Livre emprunté avec succès";
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
    <title>Emprunter un livre</title>
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
   
        <h1>Emprunter un livre</h1>
    
    <main id="search">
        <form action="emprunter.php" method="POST">
            <label for="id_livre">ID du livre:</label>
            <input type="number" id="id_livre" name="id_livre" required>
            <label for="id_lecteur">ID du lecteur:</label>
            <input type="number" id="id_lecteur" name="id_lecteur" required>
            <label for="date_emprunt">Date d'emprunt:</label>
            <input type="date" id="date_emprunt" name="date_emprunt" required>
            <label for="date_retour">Date de retour:</label>
            <input type="date" id="date_retour" name="date_retour" required>
            <button type="submit">Emprunter</button>
        </form>
        <a href="index.php">⏪ Revenir à la page d'accueil</a>
    </main>
</body>
</html>
