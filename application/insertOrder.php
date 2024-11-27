<?php
ini_set('display_errors', 1);
	if(isset($_GET['store']) && isset($_GET['phone']) && isset($_GET['fn']) && isset($_GET['ln']) && isset($_GET['itemName']) && isset($_GET['quant'])) {  
		$phone = $_GET['phone'];  
		$fn = $_GET['fn'];
		$ln = $_GET['ln'];
		$name = $_GET['itemName'];  
		$quantity = $_GET['quant'];
		$store = $_GET['store'];
	try {
		require_once('../pdo_connect.php'); 
		$sql = 'CALL takeOrder(?, ?, ?, ?, ?, ?)';
		$stmt = $dbc->prepare($sql);
		$stmt->bindParam(1, $phone);
		$stmt->bindParam(2, $fn);
		$stmt->bindParam(3, $ln);
		$stmt->bindParam(4, $name);
		$stmt->bindParam(5, $quantity);
		$stmt->bindParam(6, $store);
		$stmt->execute();
	}catch (PDOException $e){
			echo $e->getMessage();
	}}
	else {
		echo "<h2>You have reached this page in error</h2>";
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Order Submitted</title>
</head>
<body>
	<h1>Your order has been submitted!</h1>
</body>    
</html>