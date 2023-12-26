<?php 
session_start();
include("connection.php");

$NewOffersQuery = "
    SELECT 
        YEAR(time_of_submition) as year,
        MONTHNAME(time_of_submition) as monthname, 
        COUNT(transaction_id) as amount
    FROM transaction
    WHERE (type = 'OFFER'  AND status= 'PENDING')
    GROUP BY year, monthname
";

$Offerquery = mysqli_query($con, $NewOffersQuery);

$OfferData = [];

while ($row = mysqli_fetch_assoc($Offerquery)) {
    $OfferData[] = [
        'year' => $row['year'],
        'monthname' => $row['monthname'],
        'amount' => $row['amount'],
    ];
}

header('Content-Type: application/json');
echo json_encode($OfferData);
?> 