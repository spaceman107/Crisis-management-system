<?php 
session_start();
include("../../../login/connection.php");

$CompletedOffersQuery = "
    SELECT 
        YEAR(time_of_submition) as year,
        MONTHNAME(time_of_submition) as monthname, 
        COUNT(transaction_id) as amount
    FROM transaction
    WHERE( type = 'OFFER' AND status = 'COMPLETE')
    GROUP BY year, monthname
";

$CompletedOfferquery = mysqli_query($con, $CompletedOffersQuery);

$CompletedOfferData = [];

while ($row = mysqli_fetch_assoc($CompletedOfferquery)) {
    $CompletedOfferData[] = [
        'year' => $row['year'],
        'monthname' => $row['monthname'],
        'amount' => $row['amount'],
    ];
}

header('Content-Type: application/json');
echo json_encode($CompletedOfferData);
?> 
