<?php
session_start();
include("../../../login/connection.php");
include("../../../login/functions.php");

$RequestCoordinatesQuery = " SELECT x_coordinate AS lat, y_coordinate AS lng ,user.user_id   ,
user.first_name ,
user.last_name,
user.phone, 
transaction.time_of_submition,
transaction.transaction_id,
transaction.quantity,
product_type.name_category

    FROM location 
    INNER JOIN user  ON location.location_id = user.location_id 
    INNER JOIN transaction ON user.user_id = transaction.user_id 
    INNER JOIN  product ON transaction.product_id = product.product_id 
    INNER JOIN  product_type ON product.product_category = product_type.product_category_id
    WHERE (transaction.type = 'REQUEST' AND transaction.status = 'PENDING')";
$RequestCoordinatesResult = mysqli_query($con, $RequestCoordinatesQuery);

$RequestCoordinates = [];
while ($row = mysqli_fetch_assoc($RequestCoordinatesResult)) {
    $RequestCoordinates[] = $row;
}
    header('Content-Type: application/json');
echo json_encode($RequestCoordinates);

?> 