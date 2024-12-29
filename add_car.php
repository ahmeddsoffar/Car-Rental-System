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

$model = $_POST['model'];
$year = $_POST['year'];
$plate_id = $_POST['plate_id'];
$color = $_POST['color'];
$motor_type = $_POST['motor_type'];
$num_seats = $_POST['num_seats'];
$car_type = $_POST['car_type'];
$office_id = $_POST['office_id'];
$status = $_POST['status'];

$sql1 = "SELECT office_ID FROM office WHERE office_ID = '$office_id'";
$sql3 = "SELECT * FROM car WHERE PlateID = '$plate_id'";

$result3 = $conn->query($sql3);
$result1 = $conn->query($sql1);

if (!$result1||!$result3) {
  die("Error executing query: " . $conn->error);
}

if ($result1->num_rows == 0 ) {
   
    echo 'This office_ID doesnot exist';
} if ($result3->num_rows > 0 ) {
   
  echo 'This office_ID doesnot exist';
} 

else{

$sql2 =  "INSERT INTO car (year,Car_status,model,PlateID,color,motor_type,no_of_seats,carType,office_ID)
            VALUES ('$year','$status','$model','$plate_id','$color','$motor_type','$num_seats','$car_type','$office_id');
          ";

$result2 = $conn->query($sql2);
if (!$result2) {
  // If the query failed, output an error message
  die("Error executing query: " . $conn->error);
}
else{
    echo 'success';

}

  
}



$conn->close();
?>