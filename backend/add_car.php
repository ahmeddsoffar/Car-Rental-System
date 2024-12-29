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
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$price = $_POST['price'];

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
   
  echo 'This PlateID already exists';
} 

else{

$sql2 =  "INSERT INTO car (year,Car_status, price_per_day,model,PlateID,color,motor_type,no_of_seats,carType,office_ID)
            VALUES ('$year','$status',$price,'$model','$plate_id','$color','$motor_type','$num_seats','$car_type','$office_id');
          ";

$result2 = $conn->query($sql2);

if (!$result2) {
  // If the query failed, output an error message
  die("Error executing query: " . $conn->error);
}

// $sql4 = "SELECT   CarID  FROM car WHERE  PlateID= '$plate_id'";
// $result4 = $conn->query($sql4);
// if (!$result4) {
//   die("Error executing query: " . $conn->error);
// }
// if ($result4->num_rows == 0) {
//   die("No rows found for the given PlateID: $plate_id");
// }
// $row = $result4->fetch_assoc();

$carid = $conn->insert_id;
$sql5 =  "INSERT INTO CarStatus ( CarID, current_status, StartDate, EndDate)
 VALUES ('$carid','$status','$start_date','$end_date');
";
$result5 = $conn->query($sql5);
if (!$result5) {
  die("Error executing query: " . $conn->error);
}


else{
    echo 'success';

}

  
}



$conn->close();
?>