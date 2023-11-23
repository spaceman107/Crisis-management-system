<?PHP

$dbhost ="localhost";
$dbuser ="root";
$dbpass = "";
$dbname ="crisis management";


$con =  mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if ($con -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}