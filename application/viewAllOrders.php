<!-- This is a query to view all current orders -->
<?php
ini_set('display_errors', 1);
if (isset($_GET['store'])) {
    $store = $_GET["store"];
    try {
        require_once('../pdo_connect.php');
        
        // SQL query to display the menu for the store
        $sql = 'SELECT OrderID, DateTimePlaced, C.CustPhone AS Phone, CustFN, CustLN
				FROM CustomerOrder O JOIN Customer C
				WHERE C.CustPhone = O.CustPhone AND completed = 0 AND StoreID = ?';

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
    <title>Active Orders</title>
	<meta charset ="utf-8">
	<style>
	table, th, td { border: 1px solid black; }
	table td { padding:5px; }
	tr:nth-child(even) { background-color: #D6EEEE; }

	</style>	
</head>
<body>
	<h2>Active Orders</h2>
	
	<table>
		<tr>
			<th>Order ID</th>
			<th>DateTimePlaced</th>
			<th>Customer Phone</th>
			<th>First Name</th>
			<th>Last Name</th>
		</tr>
	<?php foreach($result as $item) {
		echo "<tr>";
		echo "<td>".$item['OrderID']."</td>";
		echo "<td>".$item['DateTimePlaced']."</td>";
		echo "<td>".$item['Phone']."</td>";
		echo "<td>".$item['CustFN']."</td>";
		echo "<td>".$item['CustLN']."</td>";
		echo "</tr>";
	}?> 
	</table>
</body>
</html>