<?php
require 'db.php';


$maintenance_id = intval($_GET['maintenance_id'] ?? 0);


$maintenance = $conn->query("
    SELECT m.*, v.vehicle_name, v.plate_number
    FROM maintenances m
    JOIN vehicles v ON v.id=m.vehicle_id
    WHERE m.id=$maintenance_id
")->fetch_assoc();


if (!$maintenance) {
    die("Maintenance record not found.");
}


if (isset($_POST['add_part'])) {
    $name = $_POST['part_name'];
    $cost = $_POST['part_cost'];
    $category = $_POST['part_category'];


    $stmt = $conn->prepare("
        INSERT INTO maintenance_parts
        (maintenance_id, part_name, part_cost, part_category)
        VALUES (?, ?, ?, ?)
    ");


    $stmt->bind_param("isds", $maintenance_id, $name, $cost, $category);
    $stmt->execute();


    header("Location: parts.php?maintenance_id=$maintenance_id");
    exit;
}


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM maintenance_parts WHERE id=$id");
    header("Location: parts.php?maintenance_id=$maintenance_id");
    exit;
}


$parts = $conn->query("
    SELECT * FROM maintenance_parts
    WHERE maintenance_id=$maintenance_id
    ORDER BY id DESC
");


$total_parts = $conn->query("
    SELECT COALESCE(SUM(part_cost),0) AS total
    FROM maintenance_parts
    WHERE maintenance_id=$maintenance_id
")->fetch_assoc()['total'];


$overall = $maintenance['service_cost'] + $total_parts;
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Maintenance Parts</title>
</head>
<body>


<a href="maintenance.php?vehicle_id=<?= $maintenance['vehicle_id'] ?>">
← Back to Maintenance
</a>


<h1>Maintenance Parts Management</h1>


<h2>
Maintenance #<?= $maintenance_id ?>
-
<?= htmlspecialchars($maintenance['vehicle_name']) ?>
</h2>


<h3>Add Replacement Part</h3>


<form method="POST">


Part Name:
<input type="text" name="part_name" required>
<br><br>


Part Cost:
<input type="number" name="part_cost" step="0.01" min="0" required>
<br><br>


Part Category:
<select name="part_category" required>
    <option>Engine Part</option>
    <option>Electrical Part</option>
    <option>Body Part</option>
</select>
<br><br>


<button type="submit" name="add_part">
Add Part
</button>


</form>


<hr>


<h2>Replacement Parts</h2>


<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Part Name</th>
    <th>Part Cost</th>
    <th>Category</th>
    <th>Action</th>
</tr>


<?php while ($p = $parts->fetch_assoc()): ?>


<tr>
    <td><?= $p['id'] ?></td>
    <td><?= htmlspecialchars($p['part_name']) ?></td>
    <td>₱<?= number_format($p['part_cost'],2) ?></td>
    <td><?= htmlspecialchars($p['part_category']) ?></td>
    <td>
        <a href="parts.php?maintenance_id=<?= $maintenance_id ?>&delete=<?= $p['id'] ?>"
           onclick="return confirm('Delete this part?')">
            Delete
        </a>
    </td>
</tr>


<?php endwhile; ?>


</table>


<h2>Cost Summary</h2>


<p>
Service Cost:
<strong>₱<?= number_format($maintenance['service_cost'],2) ?></strong>
</p>


<p>
Total Parts Cost:
<strong>₱<?= number_format($total_parts,2) ?></strong>
</p>


<p>
Overall Maintenance Cost:
<strong>₱<?= number_format($overall,2) ?></strong>
</p>


</body>
</html>



