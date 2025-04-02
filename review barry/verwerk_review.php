<?php
session_start();

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

// Verwerken van het formulier voor het toevoegen van een review
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['naam'], $_POST['bericht'], $_POST['cijfer'])) {
        $naam = htmlspecialchars($_POST['naam']);
        $bericht = htmlspecialchars($_POST['bericht']);
        $cijfer = (int)$_POST['cijfer'];

        // Invoegen van de review in de database
        $sql = "INSERT INTO klant (naam, bericht, cijfer) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $naam, $bericht, $cijfer);

        if ($stmt->execute()) {
            // Redirect naar index.php na succesvolle toevoeging
            header("Location: index.php");
            exit();
        } else {
            echo "Er is een fout opgetreden bij het toevoegen van de review.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
