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
$first_name = $_POST['first-name'];
$last_name = $_POST['last-name'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone_no = $_POST['phone'];
$dob = $_POST['dob'];
$license_id = $_POST['license'];
$password = md5($_POST['password']);

$sql1 = "SELECT email FROM customer WHERE email = '$email'";
$sql2 = "SELECT username FROM customer WHERE username = '$currUser'";
$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
if (!$result1 || !$result2) {
  die("Error executing query: " . $conn->error);
}

if ($result1->num_rows > 0 ||$result2->num_rows >0) {
   
    echo 'Email or username already registered on an account';
} 
else{

$sql3 =  "INSERT INTO customer (username,Address,First_name,Last_name,DOB,email,phone_no,license_no, password)
            VALUES ('$currUser','$address','$first_name','$last_name','$dob','$email','$phone_no','$license_id','$password');
          ";

$result3 = $conn->query($sql3);
if (!$result3) {
  // If the query failed, output an error message
  die("Error executing query: " . $conn->error);
}
else{
    echo 'success';

}

  
}



$conn->close();
?>