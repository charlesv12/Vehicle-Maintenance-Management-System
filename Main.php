
<!DOCTYPE html>
<html>
<head>
<title>Vehicle Management</title>
</head>
<body>


<h1>Vehicle Management System</h1>


<h2>Add Vehicle</h2>
<form action = "EventHandler.php" method="POST">
    Vehicle Name:
    <input type="text" name="vehicle_name" required><br><br>


    Plate Number:
    <input type="text" name="plate_number" required><br><br>


    Vehicle Type:
    <input type="text" name="vehicle_type" required><br><br>


    <button type="submit" name="add_vehicle">Add Vehicle</button>

    <button type="submit" name="view_maintenance" onclick="<script>window.location.href = 'ViewMainenance.php'</script>">View Maintenance</button>
</form>


<hr>


<h2>Vehicle List</h2>



</body>
</html>





