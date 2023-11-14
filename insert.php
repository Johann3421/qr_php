<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "qrcodebd";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['qrCodeValue']) && isset($_POST['opcion'])) {
    $qrCodeValue = $_POST['qrCodeValue'];
    $opcion = $_POST['opcion'];

    // Evitar la inyección SQL utilizando consultas preparadas
    $sql = "INSERT INTO table_attendance (STUDENTID, TIMEIN, OPCION) VALUES (?, NOW(), ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $qrCodeValue, $opcion);

    if ($stmt->execute()) {
        echo "Insertado correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
