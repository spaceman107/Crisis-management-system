<?php
session_start();
include("../../../login/connection.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedProducts = $_POST['products'];
    $numPeople = $_POST['num-people'];

    for ($i = 0; $i < count($selectedProducts); $i++) {
        $product = $selectedProducts[$i];
        
        $sql = "INSERT INTO transaction (transaction_id, user_id,product_id,number_of_people_in_need,status, type, quantity) VALUES (20,4,$product,$numPeople,'PENDING','REQUEST', '10')";
                   
            mysqli_query($con, $sql);

    }
}
?>
