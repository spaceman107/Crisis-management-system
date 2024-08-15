<?php
session_start();
include("../../../login/connection.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respondWithError('Invalid request method');
}
error_log('Received data: ' . file_get_contents('php://input'));

$data = json_decode(file_get_contents('php://input'), true);
$announcementText =$data['announcementText'];
$productIds = $data['productIds'];
logToErrorLog('Product id: ' . $productIds);

$sql = "INSERT INTO announcement (description) VALUES ('$announcementText')";
$con->query($sql);

//get last id after insertion
$announcementId = $con->insert_id;


foreach ($productIds as $productId) {
    $sql = "INSERT INTO announcement_products (announcement_id, product_id) VALUES ('$announcementId', '$productId')";
    $con->query($sql);
echo json_encode(['status' => 'success']);
}

$con->close();


function logToErrorLog($message) {
    error_log($message);
}
?>

