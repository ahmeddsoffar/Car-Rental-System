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



if (isset($_POST['user_name'], $_POST['pickup_date'], $_POST['return_date'])) {
    $currUser = $_POST['user_name'];
    $pickup = $_POST['pickup_date'];
    $return = $_POST['return_date'];
    $carID = $_POST['car_ID'];

    $sql1 = "SELECT *
     FROM reservation
     WHERE  CarID ='$carID' AND (pickup_date BETWEEN '$pickup' AND '$return' OR return_date BETWEEN '$pickup' AND '$return' OR (pickup_date <= '$pickup' AND return_date >= '$return'))  ;";

$result1 = $conn->query($sql1);
if (!$result1) {
  die("Error executing query: " . $conn->error);
}

if($result1->num_rows == 0 ) {


    // Insert query
    $sql2 = "INSERT INTO reservation (reservation_Date, pickup_date, return_date, CarID, CustomerID)
            VALUES (NOW(), '$pickup', '$return', $carID, (SELECT ID
                              FROM customer
                              WHERE username = '$currUser' ))";

    if ($conn->query($sql2) === TRUE) {
        // Return a JSON response
        echo json_encode(['status' => 'success', 'message' => 'Reservation created successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error inserting reservation: ' . $conn->error]);
    }
} else {
    // Return error if required fields are missing
    echo json_encode(['status' => 'error', 'message' => 'Clash in reservation : Please choose another Date interval !.']);
}
}else {
    // Return error if required fields are missing
    echo json_encode(['status' => 'error', 'message' => 'Required form fields are missing.']);
}
$conn->close();
?>