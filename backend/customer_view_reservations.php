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

$user_name = $_POST['user-name'];

$sql = "SELECT r.reservation_ID, c.model,r.pickup_date,r.return_date
        FROM reservation r 
        NATURAL JOIN car c
        WHERE r.CustomerID = (SELECT ID
                              FROM customer
                              WHERE username = '$user_name' );";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}


header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>