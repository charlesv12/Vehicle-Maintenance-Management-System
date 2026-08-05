<?php
$conn = new mysqli("localhost", "root", "", "vehicle_maintenance_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_ISSET($_POST['add'])) {
    $vehicleModel = $htmlspecialchar($_POST['vehicleModel']);
    $vehiclePlateNum = $htmlspecialchar($_POST['vehiclePlateNum']);
    $sql = $conn->query("INSERT INTO vehicle (vehicle_model, vehicle_plate_number) VALUES ('$vehicleModel', '$vehiclePlateNum') ");


    if ($conn->query($sql) == TRUE) {
        echo "Succesfullt added a new Vehicle";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif ($_ISSET($_POST['view_maintenance'])) {
    $sql = $conn->query("SELECT
    v.vehicle_model,
    v.vehicle_plate_number,
    m.service_cost,
    m.service_type,
    m.status
    FROM maintenance m
    INNER JOIN vehicle v ON m.maintenance_id = v.vehicle_id");
    

}


?>
