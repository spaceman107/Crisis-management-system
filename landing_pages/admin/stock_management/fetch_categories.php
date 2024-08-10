<?php
session_start();
include("../../../login/connection.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');

$query = "SELECT product_category_id, name_category FROM product_type";
$result = $con->query($query);


$categories = array();
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

header('Content-Type: application/json');
echo json_encode($categories);
?>
