<?PHP
session_start();
include("connection.php");
include("functions.php");
// COORDINATES FOR BASE(PINS)
$BaseCoordinatesQuery = "SELECT base.base_id, location.x_coordinate AS lat, location.y_coordinate AS lng
    FROM location 
    INNER JOIN base ON location.location_id = base.location_id";
$BaseCoordinatesResult = mysqli_query($con, $BaseCoordinatesQuery);

$BaseCoordinates = [];
while ($row = mysqli_fetch_assoc($BaseCoordinatesResult)) {
    $BaseCoordinates[] = $row;
    header('Content-Type: application/json');
echo json_encode($BaseCoordinates);
}

?>