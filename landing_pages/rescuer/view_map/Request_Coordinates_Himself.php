<?php
session_start();
include("../../../login/connection.php");
include("../../../login/functions.php");

// COORDINATES FOR USER REQUEST (PINS)

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $logged_in_user_id = $_SESSION['user_id'];
$RequestCoordinatesQuery = "    SELECT x_coordinate AS lat, y_coordinate AS lng ,   
user.first_name ,
user.last_name,
user.phone, 
transaction.time_of_submition,
product_type.name_category,
vehicle.vehicle_name,
transaction.time_of_acceptance
    FROM user
    INNER JOIN  location ON location.location_id = user.location_id 
    INNER JOIN transaction ON user.user_id = transaction.user_id 
    INNER JOIN  product ON transaction.product_id = product.product_id 
    INNER JOIN  product_type ON product.product_category = product_type.product_category_id
    INNER JOIN task ON transaction.transaction_id = task.transaction_id
    INNER JOIN vehicle ON task.vehicle_id = vehicle.vehicle_id
    WHERE user.user_id IN (
        SELECT transaction.user_id 
        FROM transaction
        INNER JOIN task ON task.transaction_id = transaction.transaction_id
        INNER JOIN rescuer ON rescuer.vehicle_id = task.vehicle_id 
        INNER JOIN user ON user.user_id = rescuer.user_id 
        WHERE (transaction.status= 'ACCEPTED' AND transaction.type='REQUEST'AND user.user_id = $logged_in_user_id)
    )
";
$RequestCoordinatesResult = mysqli_query($con, $RequestCoordinatesQuery);

$RequestHimselfCoordinates = [];
while ($row = mysqli_fetch_assoc($RequestCoordinatesResult)) {
    $RequestHimselfCoordinates[] = $row;
}  
 header('Content-Type: application/json');
echo json_encode($RequestHimselfCoordinates);
}
 else {
    // Handle the case where the user is not logged in
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User not logged in']);
}
 

?> 