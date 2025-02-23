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
    $id = intval($_POST["id"]);
    $id_livre = intval($_POST["id_livre"]);
    $id_lecteur = intval($_POST["id_lecteur"]);
    $date_emprunt = $conn->real_escape_string($_POST["date_emprunt"]);
    $date_retour = $conn->real_escape_string($_POST["date_retour"]);

    // Mettre à jour les informations de l'emprunt dans la base de données
    $sql = "UPDATE liste_lecture SET id_livre=$id_livre, id_lecteur=$id_lecteur, date_emprunt='$date_emprunt', date_retour='$date_retour' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Emprunt modifié avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Récupérer les informations de l'emprunt pour pré-remplir le formulaire
    $id = intval($_GET["id"]);
    $sql = "SELECT * FROM liste_lecture WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_livre = $row["id_livre"];
        $id_lecteur = $row["id_lecteur"];
        $date_emprunt = $row["date_emprunt"];
        $date_retour = $row["date_retour"];
    } else {
        echo "Emprunt non trouvé";
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
    <title>Modifier un emprunt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Modifier un emprunt</h1>
    </header>
    <main id = "search">
        <form action="modifier_emprunt.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="id_livre">ID du livre:</label>
            <input type="number" id="id_livre" name="id_livre" value="<?php echo $id_livre; ?>" required>
            <label for="id_lecteur">ID du lecteur:</label>
            <input type="number" id="id_lecteur" name="id_lecteur" value="<?php echo $id_lecteur; ?>" required>
            <label for="date_emprunt">Date d'emprunt:</label>
            <input type="date" id="date_emprunt" name="date_emprunt" value="<?php echo $date_emprunt; ?>" required>
            <label for="date_retour">Date de retour:</label>
            <input type="date" id="date_retour" name="date_retour" value="<?php echo $date_retour; ?>" required>
            <button type="submit">Modifier</button>
        </form>
        <a href="index.php">⏪ Revenir à la page d'accueil</a>
    </main>
</body>
</html>
