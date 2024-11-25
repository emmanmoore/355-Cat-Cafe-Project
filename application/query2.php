<?php
	ini_set('display_errors', 1);
	if(isset($_GET['submit'])) { //Form was submitted
		$store = $_GET["store"];
		$name = $_GET["name"];
		$name = '%'.$name.'%'; 
		try{
			require_once('../pdo_connect.php'); 
			$sql = 'SELECT EmpFN, EmpLN, EmpID FROM Store NATURAL JOIN Employee WHERE StoreID = ? AND (EmpFN LIKE ? OR EmpLN LIKE ?)';
			$stmt = $dbc->prepare($sql);
			$stmt->bindParam(1, $store);
			$stmt->bindParam(2, $name);
			$stmt->bindParam(3, $name);
			$stmt->execute();	
		} catch (PDOException $e){
			echo $e->getMessage();
		}	
		$affected = $stmt->RowCount();
		if ($affected == 0){
			echo "We could not find an employee at that store matching that name. Please try again.";
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
    <title>Store Info Page</title>
	<meta charset ="utf-8"> 
</head>
<body>
	<h2> Employees Found: </h2>
	<table>
		<tr>
			<th>Employee First Name</th>
			<th>Employee Last Name</th>
			<th>Employee ID</th>
		</tr>
	<?php foreach($result as $emp) {
		echo "<tr>";
		echo "<td>".$emp['EmpFN']."</td>";
		echo "<td>".$emp['EmpLN']."</td>";
		echo "<td>".$emp['EmpID']."</td>";
		echo "</tr>";
	}?> 
	</table>
</body>
</html>