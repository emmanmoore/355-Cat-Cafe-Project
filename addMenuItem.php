<!-- The following allows for the addition of a new menu utem to the database given user input from a form -->
<?php
    ini_set('display_errors', 1);
    if(isset($_GET['store'])) { 
        $store = $_GET["store"];
        try {
            require('../pdo_connect.php');
            //SQL statement to add a menu item using placeholders
            $sql = 'INSERT INTO Menu_Item (ItemName, ProductType, Price, CookTime, PrepTime) 
                    VALUES (:ItemName, :ProductType, :Price, :CookTime, :PrepTime)';

            $stmt = $dbc->prepare($sql);
            //connects user input to placeholders in SQL statement
            $stmt->execute([
                ':ItemName' => $_POST['ItemName'],
                ':ProductType' => $_POST['ProductType'],
                ':Price' => $_POST['Price'],
                ':CookTime' => $_POST['CookTime'],
                ':PrepTime' => $_POST['PrepTime']
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

		<label for="ProductType">Product Type:</label>
		<select id="ProductType" name="ProductType" required>
			<option value="HotCoffee">Hot Coffee</option>
			<option value="IcedCoffee">Iced Coffee</option>
            <option value="HotTea">Hot Tea</option>
            <option value="IcedTea">Iced Tea</option>
            <option value="Pastry">Pastry</option>
            <option value="Breakfast">Breakfast</option>
		</select><br><br>

		<label for="Price">Price:</label>
		<input type="number" id="price" name="price" step="0.01" placeholder="Enter a price" required><br><br>

        <label for="CookTime">Select Cook Time:</label>
        <input type="time" id="CookTime" name="CookTime" required><br><br>

        <label for="PrepTime">Select Prep Time:</label>
        <input type="time" id="PrepTime" name="PrepTime" required><br><br>

		<button type="submit">Add</button>
	</form>
</body>    
</html>

<!-- causes the following trigger to occur:

DELIMITER $$

CREATE TRIGGER AfterMenuItemAdd
AFTER INSERT ON Menu_Item
FOR EACH ROW
BEGIN
    -- Insert into Has table using the StoreID and ItemID
    INSERT INTO Has (StoreID, ItemID) 
    VALUES (NEW.StoreID, NEW.ItemID); -- Detected from recent addition
END $$

DELIMITER ;


-->