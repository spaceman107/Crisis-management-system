<?php
session_start();
include("../../../login/connection.php");
}

//select categories from the database
$sql = "SELECT * FROM product_type";
$result = mysqli_query($con, $sql);

//check for errors in the query
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

//save associative array
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

//return the categories as JSON
header('Content-Type: application/json');
echo json_encode($categories);

mysqli_close($con);
?>

