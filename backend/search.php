<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_system";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $fields = [
        'car_id' => 'ca.CarID',
        'year' => 'ca.Year',
        'model' => 'ca.model',
        'plate_id' => 'ca.PlateID',
        'color' => 'ca.color',
        'motor_type' => 'ca.motor_type',
        'seats' => 'ca.No_of_seats',
        'car_type' => 'ca.carType',
        'office_id' => 'ca.office_ID',
        'username' => 'c.username',
        'address' => 'c.Address',
        'first_name' => 'c.First_name',
        'last_name' => 'c.Last_name',
        'email' => 'c.email',
        'phone_no' => 'c.phone_no',
        'license_no' => 'c.license_no',
        'reservation_date' => 'r.reservation_Date',
    ];

    $params = [];
    $conditions = [];
    foreach ($fields as $key => $column) {
        if (!empty($_GET[$key])) {
            if (in_array($key, ['model', 'username', 'address', 'first_name', 'last_name', 'email'])) {
                $conditions[] = "$column LIKE :$key";
                $params[":$key"] = "%" . $_GET[$key] . "%";
            } else {
                $conditions[] = "$column = :$key";
                $params[":$key"] = $_GET[$key];
            }
        }
    }

    $query = "SELECT * FROM reservation r
              JOIN car ca ON r.CarID = ca.CarID
              JOIN customer c ON r.CustomerID = c.ID";
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

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