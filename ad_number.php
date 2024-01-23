<!DOCTYPE html>
<html lang="en">
<head>
    <title>SignaleBrouteur.fr/ad number/</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles2.css">
    
</head>
<body>

<header>
    <h1>SignaleBrouteur.fr</h1>
    <p>Signaler un numéro d'un arnaqueur ou d'un démarcheur commercial</p>
</header>

<nav id="nav">
    <a href="index.php">retour à l'acceuil</a>
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

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $number = $_POST["number"];
        $platform = $_POST["platform"];
        $currentDateTime = date("d-m-Y H:i:s");

        // Échapper les données pour éviter les injections SQL
        $number = $conn->real_escape_string($number);
        $platform = $conn->real_escape_string($platform);

        // date et heure actuelle au format: h:m:s jj/mm/aaaa 
        $dateHeureActuelles = date("h:m:s d/m/Y");


        $checkSql = "SELECT COUNT(*) FROM brouteur WHERE number = $number";
        $checkStmt = $conn->prepare($checkSql);
    
        if ($checkStmt) {
            $checkStmt->bind_param("s", $number);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();
            
            // Redirection vers le signalement qui à été ajouté
            if ($count > 0) {
                header('Location: detail_page.php?number='.$number);
                exit();
            }else{

                // Requête pour insérer les données dans la base de données
                $sqlInsert = "INSERT INTO brouteur (number, platform, date) VALUES ('$number', '$platform', '$dateHeureActuelles')";
        
    
                $sql = "INSERT INTO brouteur (number, platform, date) VALUES ($number, $platform, $currentDateTime)";
                $stmt = $conn->prepare($sql);
    
                if ($conn->query($sqlInsert) === TRUE) {
                    header('Location: detail_page.php?number='.$number);
                    exit();
                } else {
                    echo "Erreur lors de l'enregistrement : " . $conn->error;
                }

            }
        }


    }
    ?>


        <form method="post" action="" id="fm">
            <label for="number">Numéro de téléphone :</label>
            <input type="tel" id="number" name="number" placeholder="0700110011" class="css-input" pattern="[0-9]{10}" minlength="10" maxlength="15" required>
            
            <br><br>

            <label for="platform">L'arnaqueur est sur:</label>

            <select id="platform" name="platform">
                <option value="Démarcheur commercial">Démarcheur commercial</option>
                <option value="Facebook">Facebook</option>
                <option value="Instagram">Instagram</option>
                <option value="SnapChat">SnapChat</option>
                <option value="Twitter">Twitter</option>
                <option value="WhatsApp">WhatsApp</option>
                <option value="linkedin">linkedin</option>
                <option value="Leboncoin">Leboncoin</option>
                <option value="Vinted">Vinted</option>
                <option value="Tinder">Tinder</option>
            </select>

            <br><br>

            <input type="submit" class="send" value="Signaler">
        </form>


</body>
</html>









