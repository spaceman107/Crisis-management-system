<?php 
session_start();
include("../../../login/connection.php");

$CompletedRequestQuery = "
    SELECT 
        YEAR(time_of_submition) as year,
        MONTHNAME(time_of_submition) as monthname, 
        COUNT(transaction_id) as amount
    FROM transaction
    WHERE (type = 'REQUEST' AND status='COMPLETED')
    GROUP BY year, monthname
";

$Requestquery = mysqli_query($con, $CompletedRequestQuery);

$CompltedRequestdata = [];

while ($row = mysqli_fetch_assoc($Requestquery)) {
    $CompltedRequestdata[] = [
        'year' => $row['year'],
        'monthname' => $row['monthname'],
        'amount' => $row['amount'],
    ];
}
    
header('Content-Type: application/json');
echo json_encode($CompltedRequestdata);
?> 
