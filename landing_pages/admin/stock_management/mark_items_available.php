<?php
session_start();
include("../../../login/connection.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');

$jsonData = file_get_contents('php://input');
error_log($jsonData, 3, 'errors.log');
$data = json_decode($jsonData);
$result = array();
$result['success'] = true;

if ($data === NULL && json_last_error() !== JSON_ERROR_NONE) {
    $result['success'] = false;
    $result['message'] = 'Error decoding JSON data.';
} elseif (isset($data->productIds)) {
    $productIds = $data->productIds;

    foreach ($productIds as $productId) {
        
        $query = "UPDATE product SET availability = 'YES' WHERE product_id = $productId";

        if ($con->query($query) !== TRUE) {
            $result['success'] = false;
            $result['message'] = $con->error;
            break;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($result);
?>
