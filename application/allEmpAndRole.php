<?php
	ini_set('display_errors', 1);
	if(isset($_GET['submit'])) { 
		$store = $_GET["store"];
		try{
			require_once('../pdo_connect.php'); 
			$sql = 'SELECT EmpFN, EmpLN, EmpID, Role FROM Store NATURAL JOIN Employee NATURAL JOIN EmpRole WHERE StoreID = ?';
			$stmt = $dbc->prepare($sql);
			$stmt->bindParam(1, $store);
			$stmt->execute();	
		} catch (PDOException $e){
			echo $e->getMessage();
		}	
		$affected = $stmt->RowCount();
		if ($affected == 0){
			echo "We could not find employees at that store number. Please try again.";
			exit;
		}	
		else {
			$result = $stmt->fetchAll();
		}
	} //end isset
	else {
		echo "<h2>You have reached this page in error</h2>";
		exit;
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Info Page</title>
	<meta charset ="utf-8">
	<style>
	table, th, td { border: 1px solid black; }
	table td { padding:5px; }
	tr:nth-child(even) { background-color: #D6EEEE; }

	</style>	
</head>
<body>
	<h2> Employees at this store: </h2>
	
	<table>
		<tr>
			<th>Employee First Name</th>
			<th>Employee Last Name</th>
			<th>Employee ID</th>
			<th>Employee Role</th>
		</tr>
	<?php foreach($result as $emp) {
		echo "<tr>";
		echo "<td>".$emp['EmpFN']."</td>";
		echo "<td>".$emp['EmpLN']."</td>";
		echo "<td>".$emp['EmpID']."</td>";
		echo "<td>".$emp['Role']."</td>";
		echo "</tr>";
	}?> 
	</table>
</body>
</html>