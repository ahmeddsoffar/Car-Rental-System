<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_system";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $carId = $_GET['car_id'] ?? null;
    $startDate = $_GET['start_date'] ?? null;
    $endDate = $_GET['end_date'] ?? null;

    if (!$carId || !$startDate || !$endDate) {
        http_response_code(400); 
        echo json_encode(["error" => "Car ID, start date, and end date are required."]);
        exit;
    }

    $query = "
        SELECT *
        FROM reservation r
        JOIN car ca ON r.CarID = ca.CarID
        WHERE ca.CarID = :car_id 
        AND r.reservation_Date BETWEEN :start_date AND :end_date
        ORDER BY r.pickup_date ASC;
    ";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':car_id', $carId, PDO::PARAM_INT);
    $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);

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