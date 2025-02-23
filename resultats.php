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

// Récupérer les paramètres de recherche
$titre = isset($_GET['titre']) ? $_GET['titre'] : '';
$auteur = isset($_GET['auteur']) ? $_GET['auteur'] : '';

// Récupérer l'ID du lecteur (utilisateur connecté)
$id_lecteur = 1; // Remplacez cette valeur par l'ID du lecteur connecté

// Vérifier si un livre doit être ajouté à la wishlist
if (isset($_GET["ajouter_id"])) {
    $ajouter_id = intval($_GET["ajouter_id"]);
    $sql = "INSERT INTO wishlist (id_lecteur, id_livre) VALUES ($id_lecteur, $ajouter_id)";

    if ($conn->query($sql) === TRUE) {
        echo "Livre ajouté à la liste de lecture";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

// Construire la requête SQL uniquement si les champs de recherche sont remplis
$sql = "SELECT * FROM livres WHERE 1=1";
if ($titre != '' || $auteur != '') {
    if ($titre != '') {
        $sql .= " AND titre LIKE '%" . $conn->real_escape_string($titre) . "%'";
    }
    if ($auteur != '') {
        $sql .= " AND auteur LIKE '%" . $conn->real_escape_string($auteur) . "%'";
    }

    // Exécuter la requête
    $result = $conn->query($sql);
    $search_performed = true;
} else {
    $search_performed = false;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Résultats de recherche</h1>
    </header>
    <main id="search">
        <section id="results">
            <h2>Résultats de recherche</h2>
            <?php
            if ($search_performed) {
                if ($result->num_rows > 0) {
                    // Afficher les résultats de la recherche
                    echo "<ul>";
                    while($row = $result->fetch_assoc()) {
                        echo "<li><strong>" . $row["titre"]. "</strong> par " . $row["auteur"]. " <a href='details.php?id=" . $row["id"] . "'>Voir les détails</a> <a href='resultats.php?ajouter_id=" . $row["id"] . "&titre=" . urlencode($titre) . "&auteur=" . urlencode($auteur) . "'><button >Ajouter à la liste de lecture</button></a></li>";
                    }
                    
                    echo "</ul>";
                } else {
                    echo "<p>Aucun livre trouvé</p>";
                }
            }
            // Fermer la connexion
            $conn->close();
            ?>
        </section>
        <a href="index.php">⏪ Revenir à la page d'accueil</a>
    </main>
</body>
</html>
