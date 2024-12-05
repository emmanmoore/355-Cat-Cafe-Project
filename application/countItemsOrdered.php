<!-- This query counts how many times an item has been ordered at a specific store and displays count if ordered >= 3 times -->
<?php
ini_set('display_errors', 1);
if (isset($_GET['store'])) {
    $store = $_GET['store']; // Get StoreID from URL
    try {
        require('../pdo_connect.php');
        // SQL statement to select menu items ordered more than 3 times for a specific store
        $sql = 'SELECT ItemName, Price, COUNT(ItemID) AS timesOrdered 
				FROM CustomerOrder NATURAL JOIN  Contains NATURAL JOIN Menu_Item 
				WHERE StoreID = ?
				GROUP BY ItemID
				HAVING timesOrdered >= 3;';
		$stmt = $dbc->prepare($sql);
		$stmt->bindParam(1, $store);
		$stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
	$result = $stmt->fetchAll();
} else { // End isset
    echo "<h2>You have reached this page in error</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popular Items for Store</title>
    <style>
        table, th, td { border: 1px solid black; }
        table td { padding: 5px; }
        tr:nth-child(even) { background-color: #D6EEEE; }
    </style>
</head>
<body>
    <h2>Popular Items for Store ID: <?php echo htmlspecialchars($store); ?></h2>

    <table>
        <tr>
            <th>Item Name</th>
            <th>Price</th>
            <th>Occurrences</th>
        </tr>
    <?php
    if (!empty($result)) {
        foreach ($result as $item) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($item['ItemName']) . "</td>";
            echo "<td>" . number_format($item['Price'], 2) . "</td>";
            echo "<td>" . htmlspecialchars($item['timesOrdered']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No popular items found for this store.</td></tr>";
    }
    ?>
    </table>
</body>    
</html>
