<!-- The following allows for the addition of a new cat to the database given user input from a form -->
<?php
ini_set('display_errors', 1);
if(isset($_GET['store'])) { 
	$store = $_GET["store"];
	try {
		require('../pdo_connect.php');
		//SQL statement to add a cat using placeholders
		$sql = 'INSERT INTO Cat(name, coat, gender, catbirthyear, agencyID, storeID) 
				VALUES (:name, :coat, :gender, :catbirthyear, :agencyID, :storeID)';

		$stmt = $dbc->prepare($sql);
		//connects user input to placeholders in SQL statement
		$stmt->execute([
			':name' => $_POST['name'],
			':coat' => $_POST['coat'],
			':gender' => $_POST['gender'],
			':catbirthyear' => $_POST['catbirthyear'],
			$agencyID = 1;  // Always 1 since we only have 1 agency
			$stmt->bindParam(':agencyID', $agencyID, PDO::PARAM_INT);  // Bind as an integer
			$stmt->bindParam(1, $store);
		]);

		echo "Record inserted successfully";
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
} else {//end isset
	echo "<h2>You have reached this page in error</h2>";
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

	<form action="addCat.php" method="POST">
		<label for="name">Cat's Name:</label>
		<input type="text" id="name" name="name" placeholder="Name" required><br><br>

		<label for="coat">Coat Type:</label>
		<input type="text" id="coat" name="coat" placeholder="Coat" required><br><br>

		<label for="gender">Gender:</label>
		<select id="gender" name="gender" required>
			<option value="male">Male</option>
			<option value="female">Female</option>
		</select><br><br>

		<label for="catbirthyear">Birth Year:</label>
		<input type="number" id="catbirthyear" name="catbirthyear" placeholder="Leave blank if unknown"><br><br>

		<!-- Input for agency not needed since there is only one -->

		<label for="storeID">Store ID:</label>
		<input type="number" id="storeID" name="storeID" required><br><br>

		<button type="submit">Register</button>
	</form>
</body>    
</html>