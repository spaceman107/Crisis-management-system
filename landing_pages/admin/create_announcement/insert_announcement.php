<?php
session_start();
include("connection.php");

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
// Insert data into the 'announcement' table
$sql = "INSERT INTO announcement (description) VALUES ('$announcementText')";
$con->query($sql);

// Get the last inserted announcement_id
$announcementId = $con->insert_id;

// Insert data into the 'announcement_products' table
foreach ($productIds as $productId) {
    $sql = "INSERT INTO announcement_products (announcement_id, product_id) VALUES ('$announcementId', '$productId')";
    $con->query($sql);
}

$con->close();

// Helper function to log messages to the error log
function logToErrorLog($message) {
    error_log($message);
}
?>

