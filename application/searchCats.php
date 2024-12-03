<?php
ini_set('display_errors', 1);

// Check if the store is passed in the URL
if (isset($_GET['store'])) { 
    $store = $_GET["store"];
    $result = [];  // Initialize result variable
    
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CatName'])) {
        $catName = $_POST['CatName'];
        try {
            require_once('../pdo_connect.php'); 
            
            // SQL statement to search for a cat in a specific store with a name matching the user input
            $sql = 'SELECT * 
                    FROM Cat c
                    JOIN Store s ON c.StoreID = s.StoreID
                    WHERE c.CatName LIKE :CatName AND c.StoreID = :StoreID';

            $stmt = $dbc->prepare($sql);
            
            // Connect user input to placeholders in SQL statement
            $stmt->execute([
                ':CatName' => '%' . $catName . '%',
                ':StoreID' => $store
            ]);
            
            $result = $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
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
    
    <form action="searchCats.php?store=<?= htmlspecialchars($store); ?>" method="POST">
        <label for="CatName">Enter a name:</label>
        <input type="text" id="CatName" name="CatName" placeholder="Cat Name" required><br><br>

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
            <th>Store Phone</th>
            <th>Store Address</th>
        </tr>
        <?php if (isset($result) && count($result) > 0): ?>
            <?php foreach ($result as $emp): ?>
                <tr>
                    <td><?= htmlspecialchars($emp['CatID']); ?></td>
                    <td><?= htmlspecialchars($emp['CatName']); ?></td>
                    <td><?= htmlspecialchars($emp['Coat']); ?></td>
                    <td><?= htmlspecialchars($emp['Gender']); ?></td>
                    <td><?= htmlspecialchars($emp['CatBirthYear']); ?></td>
                    <td><?= htmlspecialchars($emp['AgencyID']); ?></td>
                    <td><?= htmlspecialchars($emp['StoreID']); ?></td>
                    <td><?= htmlspecialchars($emp['StorePhone']); ?></td>
                    <td><?= htmlspecialchars($emp['Street']) . ", " . htmlspecialchars($emp['City']) . ", " . htmlspecialchars($emp['State']) . " " . htmlspecialchars($emp['Zip']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="9">No cats found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>