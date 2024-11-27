<!DOCTYPE html>
<html lang="en">
<head>
    <title>Find Order Cost</title>
	<meta charset ="utf-8"> 
</head>
<body>
  <?php
  $store = $_GET["store"];
  ?>
	<h2>Search for an order:</h2>
	<form method = "GET" action = "retrieveCost.php">
		<input type="hidden" name="store" value="<?php echo htmlspecialchars($store); ?>">
		<input type="number" name="order" placeholder="Order ID"><br>
		<input type="submit" name="submit" value="Submit" id = "submit">
	</form>
</body>