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
                //ρεαδ φρομ  database
            $query = "select * from login_info where username = '$user_name' limit 1";
       $result =  mysqli_query($con, $query);
       
       if($result)
        { 
          if($result && mysqli_num_rows($result) > 0 )
            {
                 
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data["password"] === $password )
                {
                  $_SESSION['id'] = $user_data["id"];
                  header("Location: index.php");
                  die;
                }
            } 

         }
       
     echo "Please enter some valid information!";
        
    }
    else
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
<head1><h2>LOG IN</h2></head1>
    <form  method="post">                                      <!--form-->
        <label for="user_name">User_name:</label><br>
        <input type="text" id="user_name" name="user_name"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login" name="submit"><br><br>
     <a href="signup.php">Click to Signup</a><br><br>  
    </form>

</body>
</html>