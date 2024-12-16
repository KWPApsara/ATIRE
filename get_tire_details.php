<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "shift_management";  // Ensure this is the correct DB name


$conn = new mysqli("localhost", "root", "", "shift_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['tireCode'])) {
    $tireCode = $_GET['tireCode'];

    $sql = "SELECT brand, tire_weight, press_number FROM tires WHERE tire_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tireCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "No details found for the provided tire code."]);
    }

    $stmt->close();
}

$conn->close();
?>

