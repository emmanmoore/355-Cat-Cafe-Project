<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Agency Info Page</title>
</head>
<body>
<h1>Agency Information Page</h1>
<!-- display all cats within agency -->
<?php
try {
require('../pdo_connect.php');
$sql = 'SELECT AgencyName, CatName FROM Agency NATURAL JOIN Cat';
$result = $dbc->query($sql);
} catch (PDOException $e){
echo $e->getMessage();
}

foreach ($result as $name) {
echo "<tr>";
echo "<td>".$name['AgencyName']."</td>";
echo "<td>".$name['CatName']."</td>";
echo "</tr>";
}

?>
</body>
</html>