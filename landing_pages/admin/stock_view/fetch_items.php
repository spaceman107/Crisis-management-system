<?php
session_start();
include("../../../login/connection.php");
include("functions.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
$product_category_id = isset($input['product_category_id']) ? $input['product_category_id'] : 0;

$query = "SELECT product_id, product_name FROM product WHERE product_category = $product_category_id";
$result = $con->query($query);

// Fetch items as an associative array
$items = array();
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

header('Content-Type: application/json');
echo json_encode($items);
?>
