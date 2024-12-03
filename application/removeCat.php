<!-- The following allows for the removal of a cat from the database given user input from a form -->
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if 'store' is in the URL
if (isset($_GET['store'])) {
    $store = $_GET['store'];
} else {
    echo "<h2>Error: Store parameter is missing.</h2>";
    exit;
}

// If the form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['CatID']) && !empty($_POST['CatID'])) {
        // Connect to the database and execute SQL
        try {
            require('../pdo_connect.php'); // Make sure this file contains the correct DB connection

            // SQL statement to delete the cat
            $sql = 'DELETE FROM Cat WHERE CatID = :CatID AND StoreID = :StoreID';
            $stmt = $dbc->prepare($sql);

            // Execute the query
            $stmt->execute([
                ':CatID' => $_POST['CatID'],
                ':StoreID' => $store
            ]);

            // Check if the deletion was successful
            if ($stmt->rowCount() > 0) {
                echo "<p>Cat removed successfully.</p>";
            } else {
                echo "<p>No cat found with the provided ID. Please try again.</p>";
            }

        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Error: Please provide a CatID.</p>";
    }
} else {
    // Show the form if not submitted yet
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Remove Cat</title>
    </head>
    <body>
        <h2>Remove a Cat</h2>

        <!-- Form to remove cat -->
        <form action="removeCat.php?store=<?= htmlspecialchars($_GET['store']); ?>" method="POST">
            <label for="CatID">Cat's Identification Number:</label>
            <input type="number" id="CatID" name="CatID" placeholder="Cat ID" required><br><br>

            <button type="submit">Remove</button>
        </form>
    </body>
    </html>
    <?php
}
?>