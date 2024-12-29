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


$model = $_GET['car-model'] ?? null;
$color= $_GET['car-color'] ?? null;
$seats = $_GET['num-seats'] ?? null;
$cartype = $_GET['car-type'] ?? null;
$caryear = $_GET['car-year'] ?? null;
$motortype = $_GET['motor-type'] ?? null;



$query = "SELECT c.CarID,c.PlateID,c.Year,c.price_per_day,c.model,c.color,c.carType,c.No_of_seats,c.motor_type,c.Car_status
          FROM car c
          WHERE 1=1";

$params = [];
$types = '';


if ($model) {
    $query .= " AND c.model = ?";
    $params[] = $model;
    $types .= 's';
}
if ($color) {
    $query .= " AND c.color = ?";
    $params[] = $color;
    $types .= 's';
}

if ($seats) {
    $query .= " AND c.No_of_seats = ?";
    $params[] = $seats;
    $types .= 's';
}

if ($cartype) {
    $query .= " AND c.carType = ?";
    $params[] = $cartype;
    $types .= 's';
}

if ($caryear) {
    $query .= " AND c.Year = ?";
    $params[] = $caryear;
    $types .= 's';
}

if ($motortype) {
    $query .= " AND c.motor_type = ?";
    $params[] = $motortype;
    $types .= 's';
}

// Prepare and bind
$stmt = $conn->prepare($query);
if ($stmt && !empty($params)) {
    $stmt->bind_param($types, ...$params);
}

// Execute and fetch results
$stmt->execute();
$result = $stmt->get_result();




$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}


header('Content-Type: application/json');
echo json_encode($data);

$stmt->close();
$conn->close();
?>