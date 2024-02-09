<?php
session_start();
include("connection.php");
include("functions.php");
// Assuming $con is your database connection
$OfferCoordinatesQuery = " SELECT x_coordinate AS lat, y_coordinate AS lng ,   
user.first_name ,
user.last_name,
user.phone, 
transaction.time_of_submition,
product_type.name_category,
vehicle.vehicle_name
    FROM location 
    INNER JOIN user  ON location.location_id = user.location_id 
    INNER JOIN transaction ON user.user_id = transaction.user_id 
    INNER JOIN  product ON transaction.product_id = product.product_id 
    INNER JOIN  product_type ON product.product_category = product_type.product_category_id
    INNER JOIN task ON transaction.transaction_id = task.transaction_id
    INNER JOIN vehicle ON task.vehicle_id = vehicle.vehicle_id  
    WHERE (transaction.type = 'OFFER'AND transaction.status='ACCEPTED')";
$OfferCoordinatesResult = mysqli_query($con, $OfferCoordinatesQuery);

$OfferCoordinates1 = [];
while ($row = mysqli_fetch_assoc($OfferCoordinatesResult)) {
    $OfferCoordinates1[] = $row;
}

header('Content-Type: application/json');

echo json_encode($OfferCoordinates1);
?>