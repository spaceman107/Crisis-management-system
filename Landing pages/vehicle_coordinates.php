<?php
session_start();
include("connection.php");
include("functions.php");
$VehicleCoordinatesQuery = "
SELECT 
    vehicle.vehicle_name, 
    GROUP_CONCAT(product.name) AS product_names, 
    GROUP_CONCAT(transaction.status) AS transaction_statuses,
    location.x_coordinate AS lat,
    location.y_coordinate AS lng,
FROM 
    location 
    INNER JOIN user ON location.location_id = user.location_id 
    INNER JOIN rescuer ON user.user_id = rescuer.user_id
    INNER JOIN vehicle ON rescuer.vehicle_id = vehicle.vehicle_id 
    INNER JOIN task ON vehicle.vehicle_id = task.vehicle_id
    INNER JOIN transaction ON task.transaction_id = transaction.transaction_id
    INNER JOIN product ON transaction.product_id = product.product_id

GROUP BY vehicle.vehicle_name, lat, lng";

$VehicleCoordinatesResult = mysqli_query($con, $VehicleCoordinatesQuery);

$VehicleCoordinates = [];
while ($row = mysqli_fetch_assoc($VehicleCoordinatesResult)) {
    $VehicleCoordinates[] = $row;
}
header('Content-Type: application/json');
echo json_encode($VehicleCoordinates);
?>
