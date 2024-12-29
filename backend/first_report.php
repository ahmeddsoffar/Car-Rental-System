<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_system";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query parameters
    $startDate = $_GET['start_date'] ?? null;
    $endDate = $_GET['end_date'] ?? null;

    if (!$startDate || !$endDate) {
        http_response_code(400);
        echo json_encode(["error" => "Start date and end date are required."]);
        exit;
    }

    $query = "
        SELECT *    
        FROM reservation r
        JOIN car ca ON r.CarID = ca.CarID
        JOIN customer c ON r.CustomerID = c.ID
        WHERE r.pickup_date BETWEEN :start_date AND :end_date
        ORDER BY r.pickup_date ASC;
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);

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
