<?php
header('Content-Type: application/json');

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "users_biosina";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Conexión fallida: ' . $conn->connect_error
    ]);
    exit();
}

$sql = "SELECT name, email FROM users";
$result = $conn->query($sql);

$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

echo json_encode([
    'status' => 'success',
    'data' => $rows
]);

$conn->close();
?>
