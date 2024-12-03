<!-- The following allows for the addition of a new cat to the database given user input from a form -->
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
    // Get POST values and validate them
    $catName = isset($_POST['CatName']) ? $_POST['CatName'] : null;
    $coat = isset($_POST['Coat']) ? $_POST['Coat'] : null;
    $gender = isset($_POST['Gender']) ? $_POST['Gender'] : null;
    $catBirthYear = !empty($_POST['CatBirthYear']) ? $_POST['CatBirthYear'] : null; // Allow NULL for empty birth year

    if (!$catName || !$coat || !$gender) {
        echo "<p>Error: All required fields must be filled out.</p>";
        exit;
    }

    try {
        require('../pdo_connect.php'); // Make sure this file contains the correct DB connection

        // SQL statement to add a cat using placeholders
        $sql = 'INSERT INTO Cat (CatName, Coat, Gender, CatBirthYear, AgencyID, StoreID) 
                VALUES (:catname, :coat, :gender, :catbirthyear, :agencyID, :storeID)';

        $stmt = $dbc->prepare($sql);

        // Hard-code AgencyID since there is only one agency
        $agencyID = '01';

        // Execute SQL with placeholders
        $stmt->execute([
            ':catname' => $catName,
            ':coat' => $coat,
            ':gender' => $gender,
            ':catbirthyear' => $catBirthYear,
            ':agencyID' => $agencyID,
            ':storeID' => $store
        ]);

        echo "<p>Record inserted successfully.</p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
} else {
    // Show the form if not submitted
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cat Registration</title>
    </head>
    <body>
        <h2>Register a Cat</h2>

        <!-- Form to register cat -->
        <form action="addCat.php?store=<?= htmlspecialchars($_GET['store']); ?>" method="POST">
            <label for="CatName">Cat's Name:</label>
            <input type="text" id="CatName" name="CatName" placeholder="Cat Name" required><br><br>

            <label for="Coat">Coat Type:</label>
            <input type="text" id="Coat" name="Coat" placeholder="Coat" required><br><br>

            <label for="Gender">Gender:</label>
            <select id="Gender" name="Gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br><br>

            <label for="CatBirthYear">Birth Year:</label>
            <input type="number" id="CatBirthYear" name="CatBirthYear" placeholder="Leave blank if unknown"><br><br>

            <button type="submit">Register</button>
        </form>
    </body>
    </html>
    <?php
}
?>

<!-- <?php
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['store'])) {
    $store = $_GET["store"];
	var_dump($_GET['store']);  // Debugging output

    try {
        require('../pdo_connect.php');

        // Get POST values and validate them
        $catName = isset($_POST['CatName']) ? $_POST['CatName'] : null;
        $coat = isset($_POST['Coat']) ? $_POST['Coat'] : null;
        $gender = isset($_POST['Gender']) ? $_POST['Gender'] : null;
        $catBirthYear = !empty($_POST['CatBirthYear']) ? $_POST['CatBirthYear'] : null; // Allow NULL for empty birth year

        if (!$catName || !$coat || !$gender) {
            echo "Error: All required fields must be filled out.";
            exit;
        }

        // SQL statement to add a cat using placeholders
        $sql = 'INSERT INTO Cat (CatName, Coat, Gender, CatBirthYear, AgencyID, StoreID) 
                VALUES (:catname, :coat, :gender, :catbirthyear, :agencyID, :storeID)';

        $stmt = $dbc->prepare($sql);

        // Hard-code AgencyID since there is only one agency
        $agencyID = 1;

        // Execute SQL with placeholders
        $stmt->execute([
            ':catname' => $catName,
            ':coat' => $coat,
            ':gender' => $gender,
            ':catbirthyear' => $catBirthYear,
            ':agencyID' => $agencyID,
            ':storeID' => $store
        ]);

        echo "Record inserted successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<h2>You have reached this page in error or with an incomplete form</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cat Registration</title>
<style>
	table, th, td { border: 1px solid black; }
	table td { padding:5px; }
	tr:nth-child(even) { background-color: #D6EEEE; }
	</style>
</head>
<body>
	<h2>Register a Cat</h2>

	<form action="addCat.php?store=<?= htmlspecialchars($_GET['store']); ?>" method="POST">
	
		<p>Debug: Form action is: <code><?= htmlspecialchars("addCat.php?store=" . ($_GET['store'] ?? 'Not set')); ?></code></p>

		<label for="CatName">Cat's Name:</label>
		<input type="text" id="CatName" name="CatName" placeholder="Cat Name" required><br><br>

		<label for="Coat">Coat Type:</label>
		<input type="text" id="Coat" name="Coat" placeholder="Coat" required><br><br>

		<label for="Gender">Gender:</label>
		<select id="Gender" name="Gender" required>
			<option value="male">Male</option>
			<option value="female">Female</option>
		</select><br><br>

		<label for="CatBirthYear">Birth Year:</label>
		<input type="number" id="CatBirthYear" name="CatBirthYear" placeholder="Leave blank if unknown"><br><br>

		 Input for agency not needed (since there is only one) and storeid because it is take dynamically 

		<button type="submit">Register</button>
	</form>
</body>    
</html> -->