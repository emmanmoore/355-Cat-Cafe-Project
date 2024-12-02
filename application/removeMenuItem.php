<!-- The following allows for the removal of a menu item from the database given user input from a form -->
<?php
    ini_set('display_errors', 1);
    if(isset($_GET['store'])) { 
        $store = $_GET["store"];
        try {
            require('../pdo_connect.php');
            //SQL statement to add a cat using placeholders
            $sql = 'DELETE FROM Menu_Item WHERE ItemName = :ItemName';

            $stmt = $dbc->prepare($sql);
            //connects user input to placeholders in SQL statement
            $stmt->execute([
                ':ItemName' => $_POST['ItemName']
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
<title>Add Menu Item</title>
<style>
	table, th, td { border: 1px solid black; }
	table td { padding:5px; }
	tr:nth-child(even) { background-color: #D6EEEE; }
	</style>
</head>
<body>
	<h2>Add Item to Menu</h2>

	<form action="addMenuItem.php" method="POST">
		<label for="ItemName">Item Name:</label>
		<input type="text" id="ItemName" name="ItemName" placeholder="Item Name" required><br><br>

		<button type="submit">Remove</button>
	</form>
</body>    
</html>

<!-- causes the following trigger to occur:

DELIMITER $$

CREATE TRIGGER AfterMenuItemDelete
AFTER DELETE ON Menu_Item
FOR EACH ROW
BEGIN
    -- Delete the corresponding records from the Has table
    DELETE FROM Has WHERE ItemID = OLD.ItemID;

    -- Delete the corresponding records from the Contains table
    DELETE FROM Contains WHERE ItemID = OLD.ItemID;
END $$

DELIMITER ;

-->