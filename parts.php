

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Maintenance Parts Management System</title>
</head>
<body>
<h1>VMS</h1>

<h2>Maintenance Parts Management System</h2>


<?php
if($message != ""){
    echo "<p class='message'>$message</p>";
}
?>


<form action="EventHandler.php" method="POST">


<label>Parts Name</label><br>
<input type="text" name="part_name" placeholder="Enter part name" required><br>


<label>Part Cost</label><br>
<input type="number" name="part_cost" placeholder="Enter part cost" required><br>


<label>Part Category</label><br>
<input type="text" name="part_category" placeholder="Enter part category" required><br>


<Button type="submit" name="add_part" value="Add Part">Submit</Button>


</form>

</body>
</html>
