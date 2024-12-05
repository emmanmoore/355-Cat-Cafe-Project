<!-- This is a query to view all menu items -->
<?php
ini_set('display_errors', 1);
if (isset($_GET['store'])) {
    $store = $_GET["store"];
    try {
        require_once('../pdo_connect.php');
        
        // SQL query to display the menu for the store
        $sql = 'SELECT M.ItemID AS Item, ItemName, ProductType, Price, CookTime, PrepTime
				FROM Store S JOIN Has H JOIN Menu_Item M
				WHERE S.StoreID = H.StoreID AND M.ItemID = H.ItemID AND S.StoreID = ?
				ORDER BY ProductType, ItemName';

        $stmt = $dbc->prepare($sql);
        $stmt->bindParam(1, $store);
        $stmt->execute();
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
    <title>Store Menu</title>
	<meta charset ="utf-8">
	<style>
	table, th, td { border: 1px solid black; }
	table td { padding:5px; }
	tr:nth-child(even) { background-color: #D6EEEE; }

	</style>	
</head>
<body>
	<h2> Store Menu </h2>
	
	<table>
		<tr>
			<th>Item ID</th>
			<th>Item Name</th>
			<th>Product Type</th>
			<th>Price</th>
			<th>Prep Time (mins)</th>
			<th>Cook Time (mins)</th>
		</tr>
	<?php foreach($result as $item) {
		echo "<tr>";
		echo "<td>".$item['Item']."</td>";
		echo "<td>".$item['ItemName']."</td>";
		echo "<td>".$item['ProductType']."</td>";
		echo "<td>".$item['Price']."</td>";
		echo "<td>".$item['PrepTime']."</td>";
		echo "<td>".$item['CookTime']."</td>";
		echo "</tr>";
	}?> 
	</table>
</body>
</html>
