<?PHP

session_start();
include("connection.php");


if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        $coordinatesQuery = "INSERT INTO location (x_coordinate, y_coordinate) VALUES ('$latitude', '$longitude')";

        if (mysqli_query($con, $coordinatesQuery)) {
            $location_id = mysqli_insert_id($con);

            $query = "INSERT INTO user (username, password, user_type, first_name, last_name, phone, location_id) 
                      VALUES ('$user_name', '$password', 'Rescuer', '$first_name', '$last_name', '$phone', '$location_id')";
 $result = mysqli_query($con, $query);
 if ($result) {
    // Success response
    $response = array('status' => 'success', 'message' => 'Rescuer Added');
    echo json_encode($response);
} else {
    // Error response
    $response = array('status' => 'error', 'message' => 'Error updating coordinates');
    echo json_encode($response);
}
} else {
// Invalid or missing parameters
$response = array('status' => 'error', 'message' => 'Invalid or missing parameters');
echo json_encode($response);
}
}}
?>
