<?php
session_start();
include("connection.php");
include("functions.php");
// Assuming $con is your database connection
$OfferCoordinatesQuery = "SELECT x_coordinate AS lat, y_coordinate AS lng, user.first_name, user.last_name, user.phone, transaction.time_of_submition, product.product_category 
    FROM location 
    INNER JOIN user ON location.location_id = user.location_id 
    INNER JOIN transaction ON user.user_id = transaction.user_id 
    INNER JOIN product ON transaction.product_id = product.product_id 
    WHERE (transaction.type = 'OFFER' AND transaction.status = 'PENDING'  )";
$OfferCoordinatesResult = mysqli_query($con, $OfferCoordinatesQuery);

$OfferCoordinates = [];
while ($row = mysqli_fetch_assoc($OfferCoordinatesResult)) {
    $OfferCoordinates[] = $row;
}

header('Content-Type: application/json');

echo json_encode($OfferCoordinates);
?>