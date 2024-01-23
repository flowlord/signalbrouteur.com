<!DOCTYPE html>
<html>
<head>
    <title>SignaleBrouteur.fr</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/styles.css">
</head>

<body>

<span class="mobile-version">Affichage mobile</span>

<header>
    <h1>SignaleBrouteur.fr</h1>
    <p>Rechercher ou Signaler les numéros d'arnaqueur ou de démarcheur commercial</p>
</header>

<nav id="nav">
    <a href="ad_number.php">Signaler un numéro</a>
</nav>

<br>
<br>


<?php

    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "brouteur_db";

    $conn = new mysqli($servername, $username, $password, $dbName);

    $conn->set_charset("utf8mb4");
    
    $sqlSelect = "SELECT number, platform FROM brouteur"; // Sélectionne les colonnes spécifiées depuis la table "brouteur"
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        
        echo "<h2 id='ns'>Numéros signalés :</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "
                <div id='num_line'>
                    <img src='img/hacker_1320457.png'/>
                    <span id='num'>" . $row["number"] . "</span><br><br>
                    <span id='plat'>platform: " . $row["platform"] . "</span><br><br>
                    <a href='detail_page.php?number=" . $row["number"] ."'>Plus de détaile</a>
                </div>
            ";
        }
    
    } else {
        echo "<p id='no_number'>Aucun numéro signalé.</p>";
    }


    $conn->close();


?>

<a href="#nav" id="bubble"></a>

    
</body>
</html>




