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

// Récupérer la liste des emprunts
$sql = "SELECT le.id, le.id_livre, le.id_lecteur, le.date_emprunt, le.date_retour, l.titre, r.nom, r.prenom
        FROM liste_lecture le
        INNER JOIN livres l ON le.id_livre = l.id
        INNER JOIN lecteurs r ON le.id_lecteur = r.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des emprunts</title>
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
    
        <h1>Gestion des emprunts</h1>
    
    <main id="search">
        <?php
        if ($result->num_rows > 0) {
            // Afficher la liste des emprunts
            echo "<table>";
            echo "<tr><th>ID Livre</th><th>Titre</th><th>ID Lecteur</th><th>Nom Lecteur</th><th>Date d'emprunt</th><th>Date de retour</th><th>Actions</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id_livre"]. "</td><td>" . $row["titre"]. "</td><td>" . $row["id_lecteur"]. "</td><td>" . $row["nom"]. " " . $row["prenom"]. "</td><td>" . $row["date_emprunt"]. "</td><td>" . $row["date_retour"]. "</td><td><a href='modifier_emprunt.php?id=" . $row["id"]. "'>Modifier</a> | <a href='supprimer_emprunt.php?id=" . $row["id"]. "'>Supprimer</a></td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Aucun emprunt trouvé</p>";
        }
        $conn->close();
        ?>
        <a href="index.php">⏪ Revenir à la page d'accueil</a>
    </main>
</body>
</html>
