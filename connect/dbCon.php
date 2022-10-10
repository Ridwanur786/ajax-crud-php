<?php 

$servername = "127.0.0.1:33306";
$username = "root";
$password = "";
$dbName = 'employees';

// Create connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($servername, $username, $password, $dbName);
// var_dump($conn);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>