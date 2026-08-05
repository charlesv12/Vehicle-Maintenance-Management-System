<?php
require 'db.php';


if (isset($_POST['add_vehicle'])) {
    $name = $_POST['vehicle_name'];
    $plate = $_POST['plate_number'];
    $type = $_POST['vehicle_type'];


    $stmt = $conn->prepare("INSERT INTO vehicles (vehicle_name, plate_number, vehicle_type) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $plate, $type);
    $stmt->execute();


    header("Location: index.php");
    exit;
}


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM vehicles WHERE id=$id");
    header("Location: index.php");
    exit;
}


$vehicles = $conn->query("SELECT * FROM vehicles ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css"> 
<title>Vehicle Management</title>
</head>
<body>


<h1>Vehicle Management System</h1>


<h2>Add Vehicle</h2>
<form method="POST">
    Vehicle Name:
    <input type="text" name="vehicle_name" required><br><br>


    Plate Number:
    <input type="text" name="plate_number" required><br><br>


    Vehicle Type:
    <input type="text" name="vehicle_type" required><br><br>


    <button type="submit" name="add_vehicle">Add Vehicle</button>
</form>


<hr>


<h2>Vehicle List</h2>


<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Vehicle</th>
    <th>Plate Number</th>
    <th>Type</th>
    <th>Action</th>
</tr>


<?php while ($v = $vehicles->fetch_assoc()): ?>
<tr>
    <td><?= $v['id'] ?></td>
    <td><?= htmlspecialchars($v['vehicle_name']) ?></td>
    <td><?= htmlspecialchars($v['plate_number']) ?></td>
    <td><?= htmlspecialchars($v['vehicle_type']) ?></td>
    <td>
        <a href="maintenance.php?vehicle_id=<?= $v['id'] ?>">Maintenance</a> |
        <a href="index.php?delete=<?= $v['id'] ?>"
           onclick="return confirm('Delete this vehicle?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>


</table>


</body>
</html>





