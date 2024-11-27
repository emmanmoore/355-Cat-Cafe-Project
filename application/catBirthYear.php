<?php
try {
	require('../pdo_connect.php');
	$sql = 'SELECT A.CatName AS CatNameA, B.CatName AS CatNameB, A.CatBirthYear FROM Cat A JOIN Cat B WHERE A.CatBirthYear = B.CatBirthYear AND A.CatID < B.CatID ORDER BY A.CatBirthYear';
	$result = $dbc->query($sql);
} catch (PDOException $e){
echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cat Birth Year Matches</title>
<style>
	table, th, td { border: 1px solid black; }
	table td { padding:5px; }
	tr:nth-child(even) { background-color: #D6EEEE; }
	</style>
</head>
<body>
<h2>Matching Birth Years</h2>
	<table>
		<tr>
			<th>Cat 1's Name</th>
			<th>Cat 2's Name</th>
			<th>Cat Birth Year</th>
		</tr>
		<?php
		foreach ($result as $name) {
		echo "<tr>";
		echo "<td>".$name['CatNameA']."</td>";
		echo "<td>".$name['CatNameB']."</td>";
		echo "<td>".$name['CatBirthYear']."</td>";
		echo "</tr>";
		}
		?>
	</table>
</body>    
</html>