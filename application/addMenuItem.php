<!-- The following allows for the addition of a new menu utem to the database given user input from a form -->
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
    $itemName = isset($_POST['ItemName']) ? $_POST['ItemName'] : null;
    $productType = isset($_POST['ProductType']) ? $_POST['ProductType'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;
    $cookTime = isset($_POST['CookTime']) ? $_POST['CookTime'] : null;
    $prepTime = isset($_POST['PrepTime']) ? $_POST['PrepTime'] : null;

    if (!$itemName || !$productType || !$price || !$cookTime || !$prepTime) {
        echo "<p>Error: All required fields must be filled out.</p>";
        exit;
    }

    try {
        require('../pdo_connect.php'); // Make sure this file contains the correct DB connection

        // Set the StoreID as a user-defined variable before executing the insert
        $dbc->exec("SET @store_id = $store");

        // SQL statement to add a menu item using placeholders
        $sql = 'INSERT INTO Menu_Item (ItemName, ProductType, Price, CookTime, PrepTime) 
                VALUES (:itemname, :producttype, :price, :cooktime, :preptime)';

        $stmt = $dbc->prepare($sql);

        // Execute SQL with placeholders
        $stmt->execute([
            ':itemname' => $itemName,
            ':producttype' => $productType,
            ':price' => $price,
            ':cooktime' => $cookTime,
            ':preptime' => $prepTime
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
        <title>Add Menu Item</title>
    </head>
    <body>
        <h2>Add Item to Menu</h2>

        <!-- Form to add a menu item -->
        <form action="addMenuItem.php?store=<?= htmlspecialchars($_GET['store']); ?>" method="POST">
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

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" placeholder="Enter a price" required><br><br>

            <label for="CookTime">Select Cook Time (Minutes):</label>
            <input type="number" id="CookTime" name="CookTime" placeholder="e.g., 30 for 30 minutes" required><br><br>

            <label for="PrepTime">Select Prep Time (Minutes):</label>
            <input type="number" id="PrepTime" name="PrepTime" placeholder="e.g., 15 for 15 minutes" required><br><br>

            <button type="submit">Add</button>
        </form>
    </body>
    </html>
    <?php
}
?>