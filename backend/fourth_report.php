<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_system";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $customerId = $_GET['customer_id'] ?? null;

    if (!$customerId) {
        http_response_code(400); 
        echo json_encode(["error" => "Customer ID is required."]);
        exit;
    }

    $query = "
        SELECT r.reservation_ID, r.reservation_Date, r.pickup_date, r.return_date,
               c.ID, c.email, c.phone_no, c.license_no, c.Address, c.username,
               c.First_name, c.Last_name, ca.model, ca.PlateID
        FROM reservation r
        JOIN customer c ON r.CustomerID = c.ID
        JOIN car ca ON r.CarID = ca.CarID
        WHERE c.ID = :customer_id
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':customer_id', $customerId, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($data);

} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
} finally {
    $pdo = null;
}
?>