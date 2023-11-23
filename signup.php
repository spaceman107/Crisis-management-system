<?PHP

session_start();
include("connection.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    
    if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
    {

        //save to database
       
        $query = "insert into login_info (username,password,user_type) values ('$user_name','$password','User')";

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
        <input type="text" id="user_name" name="user_name"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Signup" name="submit"><br><br>
     <a href="Login.php">Click to login</a><br><br>  
    </form>

</body>
</html>