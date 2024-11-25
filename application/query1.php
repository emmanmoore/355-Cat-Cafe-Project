<?php
try {
require('../pdo_connect.php');
$sql = 'SELECT AgencyName, CatName FROM Agency NATURAL JOIN Cat';
$result = $dbc->query($sql);
} catch (PDOException $e){
echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Agency Info Page</title>
</head>
<body>
<h2>Cats</h2>
	<table>
		<tr>
			<th>Agency Name</th>
			<th>Cat Name</th>
		</tr>
		<!-- display all cats within agency -->
		<?php
		foreach ($result as $name) {
		echo "<tr>";
		echo "<td>".$name['AgencyName']."</td>";
		echo "<td>".$name['CatName']."</td>";
		echo "</tr>";
		}
		?>
	</table>
</body>    
</html>
