<?php
ini_set('display_errors', 1);
	if(isset($_GET['order_id'])) {  
		$oid = $_GET['order_id'];
	try {
		require_once('../pdo_connect.php'); 
		$sql = 'CALL markOrderComplete(?)';
		$stmt = $dbc->prepare($sql);
		$stmt->bindParam(1, $oid);
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
	<title>Order Marked Complete</title>
</head>
<body>
	<h1>The order has been marked as complete!</h1>
</body>    
</html>