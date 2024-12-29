<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_system";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query parameters
    $Date = $_GET['date'] ?? null;

    if (!$Date) {
        http_response_code(400);
        echo json_encode(["error" => " date  is required."]);
        exit;
    }

    $query = "
        SELECT c.CarID,c.model,c.PlateID,cs.current_status    
        FROM carstatus cs
        JOIN car c ON cs.CarID = c.CarID
        WHERE :date BETWEEN cs.startDate AND cs.endDate
        ORDER BY c.CarID ASC;
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':date', $Date);
   

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
