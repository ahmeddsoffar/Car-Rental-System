<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_system";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
 
$currUser = $_POST['username'];
$currPass = md5($_POST['password']);

$sql =  "SELECT *
         FROM customer C
         WHERE C.username = '$currUser'  and C.password ='$currPass';
          ";

$result = $conn->query($sql);
if (!$result) {
  die("Error executing query: " . $conn->error);
}
if($result->num_rows == 0 ) {
  echo "Incorrect Username or password ";
}
else
{
  echo"success";
}

$conn->close();
?>