<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shift_management"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serialNumber = $_POST['serialNumber'];
    $tireCode = $_POST['tireCode'];
    $brand = $_POST['brand'];
    $tireWeight = $_POST['tireWeight'];
    $pressNumber = $_POST['pressNumber'];

    // Validate form data
    if (empty($serialNumber) || empty($tireCode) || empty($brand) || empty($tireWeight) || empty($pressNumber)) {
        die("Error: All fields are required.");
    }

    // Insert tire details into the database
    $sql = "INSERT INTO tire_data (serialNumber, tireCode, brand, tireWeight, pressNumber) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $serialNumber, $tireCode, $brand, $tireWeight, $pressNumber);

    if ($stmt->execute()) {
        // Redirect to about2.html after successful insertion
        header("Location: about2.html");
        exit();
    } else {
        die("Error executing query: " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>
