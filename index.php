<?php
    require "config.php";
    $showTable = false;
    $message = "";
    if (isset($_POST["submit"])) {


        if (isset($_POST["]add_part"])) {
            $part_name = $_POST["part_name"];
            $part_cost = $_POST["part_cost"];
            $part_category = $_POST["part_category"];


            $sql = "INSERT INTO parts (part_name, part_cost, part_category) VALUES ('$part_name', '$part_cost', '$part_category')";
            if (mysqli_query($conn, $sql)) {
                $message = "Part added successfully!";
                $showTable = true;
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    }    
?>


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


<form method="POST">


<label>Parts Name</label><br>
<input type="text" name="part_name" placeholder="Enter part name" required><br>


<label>Part Cost</label><br>
<input type="number" name="part_cost" placeholder="Enter part cost" required><br>


<label>Part Category</label><br>
<input type="text" name="part_category" placeholder="Enter part category" required><br>


<input type="submit" name="add_part" value="Add Part"><br>


</form>


<?php
    if($showTable)?>
        <h3>Parts List</h3>
        <table border="1">
            <tr>
                <th>Part Name</th>
                <th>Part Cost</th>
                <th>Part Category</th>
            </tr>
            <?php
                $sql = "SELECT * FROM parts";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>".$row['part_name']."</td>";
                    echo "<td>".$row['part_cost']."</td>";
                    echo "<td>".$row['part_category']."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
</body>
</html>
