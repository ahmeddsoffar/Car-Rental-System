<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_system";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
 
$currUser = $_POST['username'];
$first_last_name = explode(" ", $currUser, 2);
$currPass = md5($_POST['password']);

$sql =  "SELECT *
         FROM customer c
         WHERE c.First_name = '$first_last_name[0]'  and  c.Last_name= '$first_last_name[1]' and c.password ='$currPass';
          ";

$result = $conn->query($sql);
if (!$result) {
  // If the query failed, output an error message
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