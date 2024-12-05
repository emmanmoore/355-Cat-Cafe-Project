<?php
ini_set('display_errors', 1);
	if(isset($_GET['order_id']) && isset($_GET['store'])) {  
		$oid = $_GET['order_id'];
		$store = $_GET['store'];
	try{
		require_once('../pdo_connect.php'); 
		$sql = 'SELECT OrderID FROM CustomerOrder WHERE OrderID = ? AND StoreID = ? AND completed = 0';
		$stmt = $dbc->prepare($sql);
		$stmt->bindParam(1, $oid);
		$stmt->bindParam(2, $store);
		$stmt->execute();
	}catch (PDOException $e){
		echo $e->getMessage();
	}
	$affected = $stmt->RowCount();
	if ($affected == 0){
		echo "We could not find an order with that ID at this store to complete. Please try again.";
		exit;
	}
	else{
		$sql = 'CALL markOrderComplete(?)';
		$stmt = $dbc->prepare($sql);
		$stmt->bindParam(1, $oid);
		$stmt->execute();
	}		
	}else {
		echo "<h2>You have reached this page in error</h2>";
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Order Marked Complete</title>
</head>
<body>
	<h1>The order has been marked as complete!</h1>
</body>    
</html>
