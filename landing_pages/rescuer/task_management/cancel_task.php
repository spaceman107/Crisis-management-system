<?php
session_start();
include("connection.php");
include("functions.php");


$data = json_decode(file_get_contents('php://input'), true);

$transactionId = $data['transactionId']; // Capture the transaction_id from the request

// Update your SQL to also check for transaction_id
$sql = "UPDATE transaction SET status = 'cancelled' WHERE  transaction_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $transactionId); // Ensure correct parameter types are used ("i" for integer)
$result = $stmt->execute();

$sql1 = "DELETE FROM task WHERE task.transaction_id = ?";
$stmt = $con->prepare($sql1);
$stmt->bind_param("i", $transactionId); // Ensure correct parameter types are used ("i" for integer)
$result1 = $stmt->execute();


if ($result) {
    echo json_encode([ "message" => "Task cancelled"]);
} else {
    echo json_encode([ "message" => "Error cancelling task"]);
}

$stmt->close();
$con->close();
?>
