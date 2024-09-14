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

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al decodificar JSON'
    ]);
    exit();
}

$stmt = $conn->prepare("INSERT INTO users (name, age, gender, day_of_birth, email) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sisss", $data['nombre'], $data['edad'], $data['sexo'], $data['fechaNacimiento'], $data['correo']);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Datos enviados correctamente'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al insertar los datos: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
