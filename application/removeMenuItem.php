<?php
ini_set('display_errors', 1);
error_reporting(E_ALL); // Ensure all errors are displayed for debugging

if (isset($_GET['store'])) {
    $store = $_GET['store'];

    require('../pdo_connect.php');

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ensure 'ItemName' exists in the POST data
        if (isset($_POST['ItemName']) && !empty($_POST['ItemName'])) {
            $itemName = $_POST['ItemName'];

            try {
                // SQL statement to delete the item from Menu_Item table
                $sql = 'DELETE FROM Menu_Item WHERE ItemName = :ItemName';

                $stmt = $dbc->prepare($sql);

                // Delete the item from Menu_Item
                $stmt->execute([
                    ':ItemName' => $itemName
                ]);

                echo "Item '$itemName' deleted successfully!";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "<p>Error: Item name is required.</p>";
        }
    }

    // Fetch item names for dropdown
    try {
        $sql2 = 'SELECT ItemName FROM Menu_Item NATURAL JOIN Has WHERE StoreID = ?';
        $stmt2 = $dbc->prepare($sql2);
        $stmt2->execute([$store]);

        $result = $stmt2->fetchAll();
    } catch (PDOException $e) {
        echo "Error fetching items: " . $e->getMessage();
    }
} else {
    echo "<h2>You have reached this page in error</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Remove Menu Item</title>
<style>
    table, th, td { border: 1px solid black; }
    table td { padding: 5px; }
    tr:nth-child(even) { background-color: #D6EEEE; }
</style>
</head>
<body>
<h2>Remove Item From Menu</h2>

<form action="removeMenuItem.php?store=<?= htmlspecialchars($store); ?>" method="POST">
    <label for="ItemName">Item Name:</label>
    <!-- Dropdown for selecting item -->
    <select name="ItemName" required>
        <?php foreach ($result as $item) { ?>
            <option value="<?php echo htmlspecialchars($item['ItemName']); ?>">
                <?php echo htmlspecialchars($item['ItemName']); ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Remove</button>
</form>

</body>
</html>
