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
 
$first_name = $_POST['first-name'];
$last_name = $_POST['last-name'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone_no = $_POST['phone'];
$dob = $_POST['dob'];
$license_id = $_POST['license'];
$password = md5($_POST['password']);

$sql = "SELECT email FROM customer WHERE email = '$email'";
$result = $conn->query($sql);
if (!$result) {
  // If the query failed, output an error message
  die("Error executing query: " . $conn->error);
}

if ($result->num_rows > 0) {
   
    echo 'Email already registered on an account';
} 
else{


$sql1 =  "INSERT INTO customer (Address,First_name,Last_name,DOB,email,phone_no,license_no, password)
            VALUES ('$address','$first_name','$last_name','$dob','$email','$phone_no','$license_id','$password');
          ";

$result1 = $conn->query($sql1);
if (!$result1) {
  // If the query failed, output an error message
  die("Error executing query: " . $conn->error);
}
else{
    echo 'success';

}

  
}



$conn->close();
?>