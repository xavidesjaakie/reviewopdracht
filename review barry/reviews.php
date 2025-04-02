<?php
// Databaseverbinding
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reviewlijst";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Reviews ophalen
$sql = "SELECT naam, bericht, cijfer FROM klant ORDER BY id DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
</head>
<body>
    <h2>Reviews</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>" . htmlspecialchars($row["naam"]) . "</strong> (Cijfer: " . $row["cijfer"] . ")</p>";
            echo "<p>" . nl2br(htmlspecialchars($row["bericht"])) . "</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>Er zijn nog geen reviews.</p>";
    }
    ?>
</body>
</html>
<?php
$conn->close();
?>
