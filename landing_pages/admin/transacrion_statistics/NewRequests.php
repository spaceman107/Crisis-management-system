<?php 
session_start();
include("connection.php");

$NewRequestQuery = "
    SELECT 
        YEAR(time_of_submition) as year, 
        MONTHNAME(time_of_submition) as monthname, 
        COUNT(transaction_id) as amount
    FROM transaction
    WHERE type = 'REQUEST'
    GROUP BY year, monthname
";

$query = mysqli_query($con, $NewRequestQuery);

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = [
        'year' => $row['year'],
        'monthname' => $row['monthname'],
        'amount' => $row['amount'],
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?> 