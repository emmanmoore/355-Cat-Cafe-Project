<!-- This is a query to view all cats at a specific store grouped by gender (aggregate group by having) -->
<?php
ini_set('display_errors', 1);
if (isset($_GET['store'])) {
    $store = $_GET["store"];
    try {
        require_once('../pdo_connect.php');
        
        // SQL query to count the number of male and female cats for a specific store, grouped by gender
        $sql = 'SELECT Gender, COUNT(*) AS CatCount
                FROM Cat
                JOIN Store ON Cat.StoreID = Store.StoreID
                WHERE Store.StoreID = ?
                GROUP BY Gender
                HAVING COUNT(*) > 0
                ORDER BY Gender';  // Optional: Order by gender if needed

        $stmt = $dbc->prepare($sql);
        $stmt->bindParam(1, $store);
        $stmt->execute();
        
        // Fetching the count of male and female cats
        $result = $stmt->fetchAll();
        
        // Store the counts for male and female cats
        $maleCount = 0;
        $femaleCount = 0;

        foreach ($result as $row) {
            if ($row['Gender'] == 'Male') {
                $maleCount = $row['CatCount'];
            } elseif ($row['Gender'] == 'Female') {
                $femaleCount = $row['CatCount'];
            }
        }

        // Fetch the details of all cats for the store (for display in tables)
        $sql2 = 'SELECT * FROM Cat
                 JOIN Store ON Cat.StoreID = Store.StoreID
                 WHERE Store.StoreID = ?
                 ORDER BY CatBirthYear DESC';  // Sorting cats from youngest to oldest
        $stmt2 = $dbc->prepare($sql2);
        $stmt2->bindParam(1, $store);
        $stmt2->execute();
        $cats = $stmt2->fetchAll();
		
		// Fetch the age range of cats at the store
		$sql3 = 'SELECT (MAX(CatBirthYear) - MIN(CatBirthYear)) AS "Range" FROM Cat
				 WHERE StoreID = ?';
		$stmt3 = $dbc->prepare($sql3);
		$stmt3->bindParam(1, $store);
		$stmt3->execute();
		$range = $stmt3->fetch();

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
    <h2>Cats at Store: <?= htmlspecialchars($store); ?></h2>
    
    <!-- Display Total Count of Male and Female Cats -->
    <h3>Summary</h3>
    <p>Total Male Cats: <?= htmlspecialchars($maleCount); ?></p>
    <p>Total Female Cats: <?= htmlspecialchars($femaleCount); ?></p>
	<p>Age Range of Cats: <?= htmlspecialchars($range); ?> Years</p>

    <!-- Display Male Cats -->
    <h3>Male Cats (Youngest to Oldest)</h3>
    <table>
        <tr>
            <th>Cat ID</th>
            <th>Cat Name</th>
            <th>Coat</th>
            <th>Gender</th>
            <th>Birth Year</th>
            <th>Agency ID</th>
            <th>Store Phone</th>
        </tr>
        <?php foreach ($cats as $cat): ?>
            <?php if ($cat['Gender'] == 'Male'): ?>
                <tr>
                    <td><?= htmlspecialchars($cat['CatID']); ?></td>
                    <td><?= htmlspecialchars($cat['CatName']); ?></td>
                    <td><?= htmlspecialchars($cat['Coat']); ?></td>
                    <td><?= htmlspecialchars($cat['Gender']); ?></td>
                    <td><?= htmlspecialchars($cat['CatBirthYear']); ?></td>
                    <td><?= htmlspecialchars($cat['AgencyID']); ?></td>
                    <td><?= htmlspecialchars($cat['StorePhone']); ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>

    <!-- Display Female Cats -->
    <h3>Female Cats (Youngest to Oldest)</h3>
    <table>
        <tr>
            <th>Cat ID</th>
            <th>Cat Name</th>
            <th>Coat</th>
            <th>Gender</th>
            <th>Birth Year</th>
            <th>Agency ID</th>
            <th>Store Phone</th>
        </tr>
        <?php foreach ($cats as $cat): ?>
            <?php if ($cat['Gender'] == 'Female'): ?>
                <tr>
                    <td><?= htmlspecialchars($cat['CatID']); ?></td>
                    <td><?= htmlspecialchars($cat['CatName']); ?></td>
                    <td><?= htmlspecialchars($cat['Coat']); ?></td>
                    <td><?= htmlspecialchars($cat['Gender']); ?></td>
                    <td><?= htmlspecialchars($cat['CatBirthYear']); ?></td>
                    <td><?= htmlspecialchars($cat['AgencyID']); ?></td>
                    <td><?= htmlspecialchars($cat['StorePhone']); ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</body>
</html>
