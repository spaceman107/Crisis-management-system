<?php
session_start();
include("../../../login/connection.php");

//fetch categories names from the database
$sql = "SELECT * FROM product_type";
$result = mysqli_query($con, $sql);

//catch errors in the query
if (!$result) {
    die("Error: " . mysqli_error($con));
}

//turn the results in an associative array
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

//use the assosiative array to return the products as JSON
header('Content-Type: application/json');
echo json_encode($categories);

//close the con
mysqli_close($con);
?>

