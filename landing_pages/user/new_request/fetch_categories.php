<?php
session_start();
include("../../../login/connection.php");
include("../../../login/functions.php");

$sql = "SELECT * FROM product_type";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($categories);

mysqli_close($con);
?>

