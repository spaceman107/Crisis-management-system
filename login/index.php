 <?PHP
session_start();
$_SESSION;
include("functions.php");
include("connection.php");
$user_data = check_login($con); 
?>


<!DOCTYPE html>
<html lang="el">
<head>
    <link rel="stylesheet" href="styles.css">
   <title>My volunteer Platform</title>
</head>
<body>

<head1><h1>ΦΟΡΜΑ ΠΑΡΟΧΗΣ ΒΟΗΘΕΙΑΣ</h1></head1>
<head1><h2>main page</h2></head1>
    
     <a href="Login.php">Click to Logout</a><br><br>  
    </form>

</body>
</html>