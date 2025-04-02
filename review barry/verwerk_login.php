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

// Formuliergegevens ophalen
$email = htmlspecialchars($_POST['email']);

// Controleer of e-mail in de database bestaat
$sql = "SELECT id, naam FROM inlog WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Sessievariabelen instellen
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['naam'];
    
    // Doorsturen naar index.php
    header("Location: index.php");
    exit();
} else {
    echo "Ongeldig e-mailadres. Probeer opnieuw.";
}

// Verbinding sluiten
$stmt->close();
$conn->close();
?>
