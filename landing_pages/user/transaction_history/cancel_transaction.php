<?php
session_start();
include("../../../login/connection.php");
include("../../../login/functions.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $transactionId = $_POST['transactionId'];

    $sql = "UPDATE transaction SET status = 'CANCELED' WHERE transaction_id = $transactionId";

    if (mysqli_query($con, $sql)) {
        echo "Transaction updated successfully.";
    } else {
        echo "Error updating transaction: " . mysqli_error($con);
    }

}

//close the con
mysqli_close($con);
?>
