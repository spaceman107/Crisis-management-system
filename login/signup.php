<?PHP

session_start();
include("connection.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $location_id = $_POST['location_id'];

    if (
        !empty($user_name) && !empty($password) && !is_numeric($user_name)
        && !empty($first_name) && !empty($last_name) && !empty($phone) && !empty($location_id)
    ) {

        // save to database

        $query = "INSERT INTO login_info (username, password, user_type, first_name, last_name, phone, location_id) 
        VALUES ('$user_name', '$password', 'User', '$first_name', '$last_name', '$phone', '$location_id')";

        mysqli_query($con, $query);

        header("Location:Login.php");
        die;
    }else
    {
        echo "Please enter some valid information!";
    }
}

?>


<!DOCTYPE html>
<html lang="el">
<head>
    <link rel="stylesheet" href="styles.css">
   
</head>
<body>

<head1><h1>ΦΟΡΜΑ ΠΑΡΟΧΗΣ ΒΟΗΘΕΙΑΣ</h1></head1>
<head1><h2>SIGN UP</h2></head1>
    <form method="post">                                      <!--form-->
        <label for="user_name">Username:</label><br>
        <input type="text" id="user_name" name="user_name" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" required><br>
        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" required><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required><br>
        <label for="location_id">Location ID:</label><br>
        <input type="text" id="location_id" name="location_id" required><br><br>
        <input type="submit" value="Signup" name="submit"><br><br>
     <a href="Login.php">Click to login</a><br><br>  
    </form>

</body>
</html>
