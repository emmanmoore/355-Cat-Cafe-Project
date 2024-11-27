<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Search By Role</title>
    <link rel="stylesheet" href="./style.css">
  </head>
  <body>
  <?php
  $store = $_GET["store"];
  ?>
  
    <main>
        <h1>Search Employees by Role</h1>
        <p>Select Role</p>
		<form method="GET" action="retrieveEmpByRole.php">
			<input type="hidden" name="store" value="<?php echo htmlspecialchars($store); ?>">
            <input type="radio" value="Manager" name="type"> Manager<br>
            <input type="radio" value="Shift-lead" name="type">Shift-lead<br>
            <input type="radio" value="Cat Caretaker" name="type">Cat Caretaker<br>
            <input type="radio" value="Baker" name="type">Baker<br>
			<input type="radio" value="Cashier" name="type">Cashier<br>
			<input type="radio" value="Barista" name="type">Barista<br><br>
			<input type="submit" name="submit" value="submit"><br>
        </form>
    </main>
  </body>
</html>