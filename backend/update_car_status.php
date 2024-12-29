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

$status = $_POST['status'];
$car_ID= $_POST['car-id'];
$start_date= $_POST['start_date'];
$end_date= $_POST['end_date'];

$sql = "SELECT * FROM Car WHERE CarID = '$car_ID'";



$result1 = $conn->query($sql);

if (!$result1) {
  die("Error executing query: " . $conn->error);
}

if ($result1->num_rows == 0 ) {
   
    echo 'This car doesnot exist';
} 

else{

    $sql2 = "UPDATE Car SET  Car_status = '$status'  WHERE  CarID='$car_ID'";
    $sql3 =  "INSERT INTO CarStatus ( CarID, current_status, StartDate, EndDate)
            VALUES ('$car_ID','$status','$start_date','$end_date');
          ";

$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
if (!$result2||!$result3) {
  // If the query failed, output an error message
  die("Error executing query: " . $conn->error);
}
else{
    echo 'success';

}

  
}



$conn->close();
?>