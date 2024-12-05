<?php
	ini_set('display_errors', 1);
	if(isset($_GET['store'])) { 
		$store = $_GET["store"];
		try{
			require_once('../pdo_connect.php'); 
			$sql = 'SELECT ItemName FROM Menu_Item NATURAL JOIN Has NATURAL JOIN Store WHERE StoreID = ?';
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Input Customer Order</title>
	<style>
	table, th, td { border: 1px solid black; }
	table td { padding:5px; }
	tr:nth-child(even) { background-color: #D6EEEE; }
	</style>
  </head>
  <body>
  
    <main>
		<h2> Enter Customer Info </h2>
		<form method="GET" action="insertOrder.php">
			<input type="hidden" name="store" value="<?php echo htmlspecialchars($store); ?>">
			<input type="number" name="phone" placeholder="phone number"><br>
			<input type="text" name="fn" value="First Name"><br>
			<input type="text" name="ln" value="Last Name"><br><br>
			
			<table>
				<tr>
					<th>Menu Item</th>
					<th>Quantity</th>
				</tr>
				<tr>
					<td>
						<!-- Dropdown to select the menu item -->
						<select name="itemName">
							<?php foreach ($result as $item) { ?>
								<option value="<?php echo htmlspecialchars($item['ItemName']); ?>">
									<?php echo htmlspecialchars($item['ItemName']); ?>
								</option>
							<?php } ?>
						</select>
					</td>
					<td>
						<!-- Input field to specify the quantity -->
						<input type="number" name="quant" min="1" placeholder="1">
					</td>
				</tr>
			</table>
			<br><input type="submit" name="submit" value="Submit"><br>
		</form>
    </main>
  </body>
</html>
