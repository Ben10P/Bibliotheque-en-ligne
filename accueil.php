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

// Récupérer les livres de la base de données
$sql = "SELECT * FROM livres";
$result1 = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .book-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        .book {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            width: 250px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .book:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .book img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .book h2 {
            font-size: 1.5em;
            margin: 10px 0;
        }
        .book p {
            font-size: 1em;
            color: #555;
        }
        .btn-detail {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #ff9800;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-detail:hover {
            background-color: #e68a00;
        }
        .navbar {
            background-color: #333;
            padding: 10px;
            color: white;
            text-align: center;
        }
        .navbar h1 {
            margin: 0;
            font-size: 2em;
        }
        .ab a {
            color: white;
            text-decoration: none;
            
        }
        .ab a:hover {
            background-color: #575757;
            border-radius: 5px;
        }
        .btn button {
            background-color:rgb(38, 35, 216);
            border: none;
            color: white;
            padding: 10px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition: background-color 0.3s;
        }
        .btn button:hover {
            background-color: #e68a00;
        }
    </style>
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
                <button type="submit" onclick="inscription()">Inscription</button>
                <button type="submit" onclick="connection()">Connection</button>
            </div>     
    </nav>
   
        <section >
            <div class="xy">
            <h1 style= "color: black ;" >Bienvenue à la Bibliothèque en Ligne</h1>
            <p style= "color: black ;">"Plongez-vous dans notre vaste collection, explorez, empruntez, et enrichissez votre expérience littéraire en quelques clics.  "</p> 
            </div>
           
        </section>
        <section>
        <h1>Liste des livres disponibles</h1>
    <div class="book-list">
        <?php
        if ($result1->num_rows > 0) {
            // Afficher les livres
            while($row = $result1->fetch_assoc()) {
                echo "<div class='book'>";
                echo "<img src='uploads/" . $row['image'] . "' alt='Image du livre'>";
                echo "<h2>" . $row['titre'] . "</h2>";
                echo "<p><strong>Auteur:</strong> " . $row['auteur'] . "</p>";
                echo "<p><strong>Maison d'édition:</strong> " . $row['maison_edition'] . "</p>";
                echo "<a class='btn-detail' href='details.php?id=" . $row['id'] . "'>Détail</a>";
                echo "</div>";
            }
        } else {
            echo "Aucun livre trouvé.";
        }
        ?>
    </div>
            
        
   
    <script src="scripts.js"></script>
</body>
</html>

<script>
    function inscription() {
        window.location.href = "inscription.php";
    }
    function connection() {
        window.location.href = "connection.php";
    }
</script>
</body>
</html>