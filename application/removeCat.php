<!-- The following allows for the removal of a cat from the database given user input from a form -->
<?php
    ini_set('display_errors', 1);
    if(isset($_GET['store'])) { 
        $store = $_GET["store"];
        try {
            require('../pdo_connect.php');
            //SQL statement to remove a cat using placeholders
            $sql = 'DELETE FROM Cat WHERE CatID = :CatID and StoreID = :StoreID';

            $stmt = $dbc->prepare($sql);
            //connects user input to placeholders in SQL statement
            $stmt->execute([
                ':CatID' => $_POST['CatID'],
                $stmt->bindParam(1, $store);
            ]);

            if ($stmt->rowCount() > 0) {
                echo "Cat removed successfully";
            } else {
                echo "No cat found with the provided ID — Please try again";
            }

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
<title>Remove Cat</title>
<style>
	table, th, td { border: 1px solid black; }
	table td { padding:5px; }
	tr:nth-child(even) { background-color: #D6EEEE; }
	</style>
</head>
<body>
    <h2>Remove a Cat</h2>

    <form action="removeCat.php" method="POST">
        <label for="CatID">Cat's Identification Number:</label>
        <input type="number" id="CatID" name="CatID" placeholder="Cat ID" required><br><br>

        <button type="submit">Register</button>
    </form>
</body>    
</html>