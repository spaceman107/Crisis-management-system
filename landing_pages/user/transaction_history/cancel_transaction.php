<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "crisis management";

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Create connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if transactionId is set and valid
    if (isset($_POST['transactionId']) && is_numeric($_POST['transactionId'])) {
        $transactionId = $_POST['transactionId'];

        // Prepare the SQL statement to delete the transaction
        $sql = "UPDATE transaction SET status = 'REJECTED' WHERE transaction_id = $transactionId";

        // Execute the SQL statement
        if (mysqli_query($connection, $sql)) {
            echo "Transaction updated successfully.";
        } else {
            echo "Error updating transaction: " . mysqli_error($connection);
        }
    } else {
        echo "Invalid transaction ID.";
    }
}

// Close the database connection
mysqli_close($connection);
?>
