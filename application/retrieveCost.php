<?php
	ini_set('display_errors', 1);
	if(isset($_GET['submit']) && isset($_GET['order']) && isset($_GET['store'])) {
		$order = $_GET['order'];  
		$store = $_GET['store'];
		try{
			require_once('../pdo_connect.php');
			$sql = 'SELECT get_Cost(OrderID, StoreID) AS total FROM CustomerOrder WHERE OrderID = ? AND StoreID = ?';
			$stmt = $dbc->prepare($sql);
			$stmt->bindParam(1, $order);
			$stmt->bindParam(2, $store);
			$stmt->execute();	
		} catch (PDOException $e){
			echo $e->getMessage();
		}	
		$affected = $stmt->RowCount();
		if ($affected == 0){
			echo "We could not find an order at your store with this ID. Please try again.";
			exit;
		}	
		else {
			$result = $stmt->fetchAll();
		}
	}
	else {
		echo "<h2>You have reached this page in error</h2>";
		exit;
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Cost</title>
	<meta charset ="utf-8">
	<style>
	table, th, td { border: 1px solid black; }
	table td { padding:5px; }
	</style>	
</head>
<body>
	<h2> Order Cost </h2>
	<table>
		<tr>
			<th>Total Cost</th>
		</tr>
	<?php foreach($result as $ord) {
		echo "<tr>";
		echo "<td>$".$ord['total']."</td>";
		echo "</tr>";
	}?> 
	</table>
</body>
</html>