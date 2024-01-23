<!DOCTYPE html>
<html>
<head>
    <title>SB.fr/fiche/<?php echo isset($_GET['number']) ? $_GET['number'] : ''; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/styles.css">
</head>

<body>

<header>
    <h1>SignaleBrouteur.fr</h1>
    <p>Rechercher ou Signaler les numéros d'arnaqueur ou de démarcheur commercial</p>
</header>

<nav id="nav">
    <a href="index.php">retour à l'acceuil</a>
    <a href="ad_number.php">Signaler un numéro</a>
</nav>

<br>
<br>


<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "brouteur_db"; // Assurez-vous que cette base de données existe

    $conn = new mysqli($servername, $username, $password, $dbName);

    $conn->set_charset("utf8mb4");

    if (isset($_GET['number'])) {
        $number = $_GET['number'];
    
        // Échapper les données pour éviter les injections SQL
        $number = $conn->real_escape_string($number);
    
        $sqlCheckNumero = "SELECT * FROM brouteur WHERE number = '$number'";
        $resultCheckNumero = $conn->query($sqlCheckNumero);
    
        if ($resultCheckNumero->num_rows > 0) {

            while ($row = $resultCheckNumero->fetch_assoc()) {
                echo "
                    <div id='num_line_b'>
                        <img src='img/hacker_1320457.png'/><br><br>
                        <span id='num'>numéro de l'arnaqueur: " . $row["number"] . "</span><br><br>
                        <span id='plat'>réseau sociale: " . $row["platform"] . "</span><br><br>
                        <span id='plat'>date du singalement: " . $row["date"] . "</span>
                    </div>
                ";
            }
    
        } else {
            echo "<p id='no_number'>Numéro $number non trouvé dans la base de données.</p>";
        }
    } else {
        echo "<p id='no_number'>pas de numéro entré dans l'URL.</p>";
    }
    
    $conn->close();


?>


    
</body>
</html>









