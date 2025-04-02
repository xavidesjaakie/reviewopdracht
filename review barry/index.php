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

// Uitloggen als de gebruiker op 'logout' klikt
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Registreren
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $naam = htmlspecialchars($_POST['naam']);
    $email = htmlspecialchars($_POST['email']);

    // Controleer of e-mail al bestaat
    $sql = "SELECT id FROM inlog WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Dit e-mailadres is al in gebruik.";
    } else {
        // Nieuwe gebruiker toevoegen
        $sql = "INSERT INTO inlog (naam, email) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $naam, $email);
        if ($stmt->execute()) {
            $success = "Account aangemaakt! Je kunt nu inloggen.";
        } else {
            $error = "Er ging iets mis, probeer opnieuw.";
        }
    }

    $stmt->close();
}

// Inloggen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);

    // Controleer of e-mail in de database staat
    $sql = "SELECT id, naam, email FROM inlog WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['naam'];
        $_SESSION['user_email'] = $row['email'];
        
        // Check of de gebruiker admin is (specifieke e-mail voor beheerder)
        if ($_SESSION['user_email'] == "admin@gmail.com") {
            $_SESSION['is_admin'] = true;
        }

        header("Location: index.php");
        exit();
    } else {
        $error = "Ongeldig e-mailadres. Probeer opnieuw.";
    }

    $stmt->close();
}

// Verwijder review
if (isset($_GET['delete_review'])) {
    $review_id = (int)$_GET['delete_review'];

    // Controleer of de review van de ingelogde gebruiker is
    $sql = "DELETE FROM klant WHERE id = ? AND (naam = ? OR ? = 'admin@gmail.com')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $review_id, $_SESSION['user_name'], $_SESSION['user_email']);
    if ($stmt->execute()) {
        $success = "Review succesvol verwijderd.";
    } else {
        $error = "Er is een fout opgetreden bij het verwijderen van de review.";
    }

    $stmt->close();
}

// Bewerken van review
if (isset($_POST['edit_review'])) {
    $review_id = (int)$_POST['review_id'];
    $new_bericht = htmlspecialchars($_POST['bericht']);
    $new_cijfer = (int)$_POST['cijfer'];

    // Update de review
    $sql = "UPDATE klant SET bericht = ?, cijfer = ? WHERE id = ? AND (naam = ? OR ? = 'admin@gmail.com')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiss", $new_bericht, $new_cijfer, $review_id, $_SESSION['user_name'], $_SESSION['user_email']);
    if ($stmt->execute()) {
        $success = "Review succesvol bijgewerkt.";
    } else {
        $error = "Er is een fout opgetreden bij het bijwerken van de review.";
    }

    $stmt->close();
}

// Verwerken van het formulier voor het toevoegen van een review
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
    if (isset($_POST['naam'], $_POST['bericht'], $_POST['cijfer'])) {
        $naam = htmlspecialchars($_POST['naam']);
        $bericht = htmlspecialchars($_POST['bericht']);
        $cijfer = (int)$_POST['cijfer'];

        // Invoegen van de review in de database
        $sql = "INSERT INTO klant (naam, bericht, cijfer) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $naam, $bericht, $cijfer);

        if ($stmt->execute()) {

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

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Systeem</title>
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
    <h2>Welkom, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
    <p>Je bent ingelogd.</p>
    <a href="index.php?logout=true">Uitloggen</a>

   
    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
        <h3>Beheer alle reviews</h3>
        <a href="index.php?action=edit_all">Bewerk alle reviews</a> | 
        <a href="index.php?action=delete_all">Verwijder alle reviews</a>
    <?php endif; ?>

    <h2>Schrijf een review</h2>
    <form action="index.php" method="post">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required><br><br>

        <label for="bericht">Bericht:</label><br>
        <textarea id="bericht" name="bericht" rows="4" required></textarea><br><br>

        <label for="cijfer">Cijfer (1-10):</label>
        <input type="number" id="cijfer" name="cijfer" min="1" max="10" required><br><br>

        <button type="submit" name="submit_review">Verzenden</button>
    </form>

    <h2>Reviews</h2>
    <?php

    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "SELECT id, naam, bericht, cijfer FROM klant ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>" . htmlspecialchars($row["naam"]) . "</strong> (Cijfer: " . $row["cijfer"] . ")</p>";
            echo "<p>" . nl2br(htmlspecialchars($row["bericht"])) . "</p>";

    
            if ($row['naam'] == $_SESSION['user_name'] || isset($_SESSION['is_admin'])) {
                echo "<a href='index.php?delete_review=" . $row["id"] . "'>Verwijder review</a> | ";
                echo "<a href='index.php?edit_review=" . $row["id"] . "'>Bewerk review</a>";
            }
            echo "<hr>";
        }
    } else {
        echo "<p>Er zijn nog geen reviews.</p>";
    }

    $conn->close();
    ?>

<?php else: ?>
    <h2>Inloggen</h2>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
    <form action="index.php" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit" name="login">Inloggen</button>
    </form>

    <h2>Account aanmaken</h2>
    <form action="index.php" method="post">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit" name="register">Registreren</button>
    </form>
<?php endif; ?>

</body>
</html>
