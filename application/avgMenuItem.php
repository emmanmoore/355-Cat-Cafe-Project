<?php
	ini_set('display_errors', 1);
	if(isset($_GET['store'])) { 
		$store = $_GET["store"];
		try{
			require_once('../pdo_connect.php'); 
			$sql = 'SELECT AVG(Price) AS AvgItemPrice FROM Store NATURAL JOIN Has NATURAL JOIN Menu_Item WHERE StoreID = ?';
			$stmt = $dbc->prepare($sql);
			$stmt->bindParam(1, $store);
			$stmt->execute();
		}catch (PDOException $e){
			echo $e->getMessage();
		}
		$result = $stmt->fetchAll();
	}else {//end isset
		echo "<h2>You have reached this page in error</h2>";
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Average Menu Item Cost</title>
	<meta charset ="utf-8">
	<style>
	table, th, td { border: 1px solid black; }
	table td { padding:5px; }
	</style>	
</head>
<body>
	<h2> Average Menu Item Cost </h2>
	<table>
		<tr>
			<th>Price</th>
		</tr>
	<?php foreach($result as $emp) {
		echo "<tr>";
		echo "<td>$".round($emp['AvgItemPrice'],2)."</td>";
		echo "</tr>";
	}?> 
	</table>
</body>
</html>