<!-- View the recent trending product types across stores -->
<?php
try{
		require_once('../pdo_connect.php'); 
		$sql = 'SELECT ProductType FROM Menu_Item WHERE ItemID IN (SELECT ItemID FROM Contains NATURAL JOIN CustomerOrder WHERE (CURDATE()-DateTimePlaced) < 8) GROUP BY ProductType';
		$result = $dbc->query($sql);
		}catch (PDOException $e){
			echo $e->getMessage();
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trending Products</title>
<style>
	table, th, td { border: 1px solid black; }
	table td { padding:5px; }
	tr:nth-child(even) { background-color: #D6EEEE; }
	</style>
</head>
<body>
<h2>Last Week's Trending Product Types Across Cafes</h2>
	<table>
		<tr>
			<th>Products</th>
		</tr>
		<?php
		foreach ($result as $name) {
		echo "<tr>";
		echo "<td>".$name['ProductType']."</td>";
		echo "</tr>";
		}
		?>
	</table>
</body>    
</html>