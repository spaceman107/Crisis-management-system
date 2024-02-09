<?php
session_start();
include("../../../login/connection.php");
include("../../../login/functions.php");
$userID = $_SESSION['user_id'];
// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respondWithError('Invalid request method');
}
error_log('Received data: ' . file_get_contents('php://input'));
// Extract userId and transactionId from POST data
$data = json_decode(file_get_contents('php://input'), true);
$userId = isset($data['userId']) ? $data['userId'] : null;
$transactionId = isset($data['transactionId']) ? $data['transactionId'] : null;
logToErrorLog('User ID: ' . $userId);

// Validate that they are integers (optional but recommended)
if (!is_numeric($userId) || !is_numeric($transactionId)) {
    respondWithError('Invalid input. Non-numeric values provided.');
}

// Validate and establish the database connection
if (!$con || !$con instanceof mysqli) {
    respondWithError('Database connection failed or not a valid mysqli object.');
}

// Example SQL queries (replace with your actual queries)
$sql1 = "SELECT vehicle_id FROM rescuer WHERE user_id = $userID";
$result1 = $con->query($sql1);

if ($result1) {
    $row = $result1->fetch_assoc();

    if ($row) {
        $vehicleId = $row['vehicle_id'];

        $sql2 = "INSERT INTO task (vehicle_id, transaction_id) VALUES ('$vehicleId', '$transactionId')";
        $result2 = $con->query($sql2);

        if ($result2) {
            // Update status in the transaction table
            $updateStatusQuery = "UPDATE transaction SET status = 'ACCEPTED' WHERE transaction_id='$transactionId'";
            $updateStatusResult = $con->query($updateStatusQuery);

            if (!$updateStatusResult) {
                respondWithError('Error updating status in the transaction table');
            }

            respondWithSuccess('Data inserted successfully');
        } else {
            respondWithError('Error executing the second SQL query');
        }

        $result2->close();
    } else {
        respondWithError('No result found in the first query');
    }

    $result1->close();
} else {
    respondWithError('Error executing the first SQL query');
}

// Close the database connection
$con->close();
exit;

// Helper function to log errors and respond with an error message
function respondWithError($errorMessage) {
    logToErrorLog($errorMessage);
    header('Content-Type: application/json');
    echo json_encode(array('error' => $errorMessage));
    exit;
}

// Helper function to log messages to the error log
function logToErrorLog($message) {
    error_log($message);
}

// Helper function to respond with a success message
function respondWithSuccess($successMessage) {
    header('Content-Type: application/json');
    echo json_encode(array('success' => $successMessage));
    exit;
}