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
$first_name = $_POST['first-name'];
$last_name = $_POST['last-name'];
$address = $_POST['address'];
$email = $_POST['email'];
$phone_no = $_POST['phone'];
$password = md5($_POST['password']);


$sql1 = "SELECT email FROM admin WHERE email = '$email'";
$sql2 = "SELECT username FROM admin WHERE username = '$currUser'";
$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
if (!$result1 || !$result2) {
  die("Error executing query: " . $conn->error);
}
if ($result1->num_rows > 0 ||$result2->num_rows >0) {
   
    echo 'Email or username already registered on an account';
} 
else{
    $sql3 =  "INSERT INTO admin (username,Address,First_name,Last_name,email,phone_no,password)
            VALUES ('$currUser','$address','$first_name','$last_name','$email','$phone_no','$password');
          ";

$result3 = $conn->query($sql3);
if (!$result3) {
  die("Error executing query: " . $conn->error);
}
else{
    echo 'success';

}

  
}


$conn->close();
?>