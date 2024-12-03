<!-- This is a query to view all cats associated with a specific store -->
<?php
ini_set('display_errors', 1);
if (isset($_GET['store'])) { 
    $store = $_GET["store"];
    try {
        require_once('../pdo_connect.php'); 
        
        // SQL statement to search for a cat in a specific store with a name matching the user input
        $sql = 'SELECT * 
                FROM Cat c
                JOIN Store s ON c.StoreID = s.StoreID
                WHERE c.Name LIKE :Name AND c.StoreID = :StoreID';

        $stmt = $dbc->prepare($sql);
        
        // Connects user input to placeholders in SQL statement
        $stmt->execute([
            ':Name' => '%' . $_POST['Name'] . '%',
            ':StoreID' => $store
        ]);
        
        $result = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    echo "<h2>You have reached this page in error</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Cats</title>
    <meta charset="utf-8">
    <style>
        table, th, td { border: 1px solid black; }
        table td { padding:5px; }
        tr:nth-child(even) { background-color: #D6EEEE; }
    </style>  
</head>
<body>
    <h2>Search for a Cat:</h2>
    
    <form action="searchCats.php" method="POST">
        <label for="Name">Enter a name:</label>
        <input type="text" id="Name" name="Name" placeholder="Name" required><br><br>

        <button type="submit">Search</button>
    </form>
    
    <table>
        <tr>
            <th>Cat ID</th>
            <th>Cat Name</th>
            <th>Coat</th>
            <th>Gender</th>
            <th>Birth Year</th>
            <th>Agency ID</th>
            <th>Store ID</th>
            <th>Store Name</th>
            <th>Store Phone</th>
            <th>Store Address</th>
        </tr>
        <?php if (isset($result) && count($result) > 0): ?>
            <?php foreach ($result as $emp): ?>
                <tr>
                    <td><?= htmlspecialchars($emp['CatID']); ?></td>
                    <td><?= htmlspecialchars($emp['Name']); ?></td>
                    <td><?= htmlspecialchars($emp['Coat']); ?></td>
                    <td><?= htmlspecialchars($emp['Gender']); ?></td>
                    <td><?= htmlspecialchars($emp['CatBirthYear']); ?></td>
                    <td><?= htmlspecialchars($emp['AgencyID']); ?></td>
                    <td><?= htmlspecialchars($emp['StoreID']); ?></td>
                    <td><?= htmlspecialchars($emp['StoreName']); ?></td> <!-- Assuming StoreName is in Store table -->
                    <td><?= htmlspecialchars($emp['StorePhone']); ?></td> <!-- Assuming StorePhone is in Store table -->
                    <td><?= htmlspecialchars($emp['Street']) . ", " . htmlspecialchars($emp['City']) . ", " . htmlspecialchars($emp['State']) . " " . htmlspecialchars($emp['Zip']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="10">No cats found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
