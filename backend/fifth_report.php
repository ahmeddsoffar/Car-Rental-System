<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_system";

try {
   
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $startDate = $_GET['start_date'] ?? null;
    $endDate = $_GET['end_date'] ?? null;


   
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $end->modify('+1 day'); 
    $payments = [];

    // Loop through each day in the date range
    while ($start < $end) {
        
        $currentDate = $start->format('Y-m-d');

        $query = "
            SELECT 
                    SUM(c.price_per_day * DATEDIFF(r.return_date, r.pickup_date)) AS total_payment
            FROM 
                        reservation r
            JOIN 
                        car c ON r.CarID = c.CarID
            WHERE 
                        r.reservation_Date = :current_date
            GROUP BY 
                        r.reservation_Date;
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':current_date', $currentDate, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Store the total payment for the current date
        $payments[] = [
            'payment_date' => $currentDate,
            'total_payment' => $result['total_payment'] ?? 0
        ];

        // Move to the next day
        $start->modify('+1 day');
    }

    // Return the results as JSON
    header('Content-Type: application/json');
    echo json_encode($payments);

} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
} finally {
    $pdo = null;
}
?>