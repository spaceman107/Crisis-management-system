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
                //ρεαδ 
            $query = "select * from user where username = '$user_name' ";
       $result =  mysqli_query($con, $query);
       
       if($result)
        { 
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
            
                if ($user_data["password"] === $password) {
                    $_SESSION['user_id'] = $user_data["user_id"];
                    $_SESSION['user_type'] = $user_data["user_type"]; // Add user type to the session
                    $_SESSION['location_id'] = $user_data["location_id"];
                    // Redirect based on user type
                    switch ($_SESSION['user_type']) {
                        case 'Admin':
                            header("Location: ../landing_pages/admin/admin_landing_page.php");
                            break;
                        case 'Rescuer':
                            header("Location: ../landing_pages/rescuer/rescuer_landing_page.php");
                            break;
                        case 'Citizen':
                        default:
                            header("Location: ../landing_pages/user/user_landing_page.php");
                            break;
                    }
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

    <div class="form-container">
        <h1 class="form-heading">Crisis Management System</h1>
        <h2 class="form-subheading">Log In</h2>

        <form method="post">
            <label for="user_name">User Name:</label><br>
            <input type="text" id="user_name" name="user_name"><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br><br>

            <input type="submit" value="Login" name="submit"><br><br>
            <a href="signup.php">Click to Signup</a><br><br>
        </form>

    </div>

</body>
</html>
 
