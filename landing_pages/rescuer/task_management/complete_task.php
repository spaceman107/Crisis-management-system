<?php
session_start();
include("connection.php");
include("functions.php");


$data = json_decode(file_get_contents('php://input'), true);

$transactionId = $data['transactionId']; 


$sql = "UPDATE transaction SET status ='COMPLETE' WHERE  transaction_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $transactionId);
$result = $stmt->execute();

$sql1 = "DELETE FROM task WHERE task.transaction_id = ?";
$stmt = $con->prepare($sql1);
$stmt->bind_param("i", $transactionId); 
$result1 = $stmt->execute();

if ($result) {
    echo json_encode([ "message" => "Task complete"]);
} else {
    echo json_encode(["message" => "Error completing task"]);
}


$stmt->close();
$con->close();
?>
