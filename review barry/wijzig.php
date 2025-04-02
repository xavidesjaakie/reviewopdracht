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

// Haal de review op die bewerkt moet worden
if (isset($_GET['review_id'])) {
    $review_id = (int)$_GET['review_id'];

    // Haal de review uit de database
    $sql = "SELECT * FROM klant WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $review = $result->fetch_assoc();
    } else {
        $error = "Review niet gevonden.";
    }
} else {
    header("Location: index.php");
    exit();
}

// Verwerken van het bewerken van de review
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_review_submit'])) {
    $new_bericht = htmlspecialchars($_POST['bericht']);
    $new_cijfer = (int)$_POST['cijfer'];

    // Controleer of de gebruiker de juiste rechten heeft
    if ($review['naam'] == $_SESSION['user_name'] || $_SESSION['user_email'] == 'admin@gmail.com') {
        // Update de review in de database
        $sql = "UPDATE klant SET bericht = ?, cijfer = ? WHERE id = ? AND (naam = ? OR ? = 'admin@gmail.com')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiss", $new_bericht, $new_cijfer, $review_id, $_SESSION['user_name'], $_SESSION['user_email']);
        
        if ($stmt->execute()) {
            $success = "Review succesvol bijgewerkt.";
            header("Location: index.php");
            exit();
        } else {
            $error = "Er is een fout opgetreden bij het bijwerken van de review.";
        }
    } else {
        $error = "Je hebt geen toestemming om deze review te bewerken.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Bewerken</title>
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
    <h2>Bewerk Review</h2>
    
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>

    <form action="wijzig.php?review_id=<?php echo $review['id']; ?>" method="post">
        <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
        
        <label for="bericht">Bericht:</label><br>
        <textarea id="bericht" name="bericht" rows="4" required><?php echo htmlspecialchars($review['bericht']); ?></textarea><br><br>

        <label for="cijfer">Cijfer (1-10):</label>
        <input type="number" id="cijfer" name="cijfer" min="1" max="10" value="<?php echo $review['cijfer']; ?>" required><br><br>

        <button type="submit" name="edit_review_submit">Bewerk Review</button>
    </form>

    <br>
    <a href="index.php">Terug naar reviews</a>

<?php else: ?>
    <p>Je moet ingelogd zijn om een review te bewerken.</p>
    <a href="index.php">Inloggen</a>
<?php endif; ?>

</body>
</html>
