<?php
$conn = new mysqli("localhost", "root", "", "vehicle_maintenance_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add Vehicle
if (isset($_POST['add'])) {

    $vehicleModel = htmlspecialchars($_POST['vehicleModel']);
    $vehiclePlateNum = htmlspecialchars($_POST['vehiclePlateNum']);

    $sql = "INSERT INTO vehicle (vehicle_model, vehicle_plate_number)
            VALUES ('$vehicleModel', '$vehiclePlateNum')";

    if ($conn->query($sql) === TRUE) {
        echo "Successfully added a new vehicle.";
    } else {
        echo "Error: " . $conn->error;
    }

// View Maintenance
} elseif (isset($_POST['view_maintenance'])) {

    $sql = $conn->query("
        SELECT
            v.vehicle_model,
            v.vehicle_plate_number,
            m.service_cost,
            m.service_type,
            m.status
        FROM maintenance m
        INNER JOIN vehicle v
            ON m.vehicle_id = v.vehicle_id
    ");

    if ($sql->num_rows > 0) {

        echo "<table border='1'>";
        echo "<tr>
                <th>Vehicle Model</th>
                <th>Vehicle Plate Number</th>
                <th>Service Cost</th>
                <th>Service Type</th>
                <th>Status</th>
              </tr>";

        while ($row = $sql->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['vehicle_model'] . "</td>";
            echo "<td>" . $row['vehicle_plate_number'] . "</td>";
            echo "<td>" . $row['service_cost'] . "</td>";
            echo "<td>" . $row['service_type'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

    } else {
        echo "No maintenance records found.";
    }

// Add Part
} elseif (isset($_POST['add_part'])) {

    $partName = htmlspecialchars($_POST['part_name']);
    $partCost = htmlspecialchars($_POST['part_cost']);
    $partCategory = htmlspecialchars($_POST['part_category']);

    $sql = "INSERT INTO maintenance_part (part_name, part_cost, part_category)
            VALUES ('$partName', '$partCost', '$partCategory')";

    if ($conn->query($sql) === TRUE) {
        echo "Successfully added a new part.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>