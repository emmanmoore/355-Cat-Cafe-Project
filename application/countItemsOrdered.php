<!-- This query counts how many times an item has been ordered at a specific store and displays count if ordered more than 3 times -->
<?php
ini_set('display_errors', 1);
if (isset($_GET['store'])) {
    $store = $_GET['store']; // Get StoreID from URL
    try {
        require('../pdo_connect.php');
        // SQL statement to select menu items ordered more than 3 times for a specific store
        $sql = 'SELECT mi.ItemName, mi.Price, COUNT(c.ItemID) AS Occurrences
                FROM Menu_Item mi
                JOIN Contains c ON mi.ItemID = c.ItemID
                JOIN Store s ON s.StoreID = :StoreID
                WHERE s.StoreID = :StoreID
                GROUP BY mi.ItemID
                HAVING COUNT(c.ItemID) > 3';

        $stmt = $dbc->prepare($sql);

        // Binds the store ID to the query
        $stmt->execute([
            ':StoreID' => $store,
        ]);

        // Fetch all results
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
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
            echo "<td>" . htmlspecialchars($item['Occurrences']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No popular items found for this store.</td></tr>";
    }
    ?>
    </table>
</body>    
</html>
