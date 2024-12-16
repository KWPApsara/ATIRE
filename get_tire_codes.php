<?php
// Database configuration
$servername = "localhost";
$username = "root";  // Default MySQL username
$password = "";      // Default MySQL password (empty for XAMPP/local dev)
$dbname = "shift_management";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Return JSON error response
    header('Content-Type: application/json');
    echo json_encode([
        "error" => "Connection failed: " . $conn->connect_error,
        "status" => "error"
    ]);
    exit();
}

try {
    // Prepare SQL to fetch distinct tire codes
    $sql = "SELECT DISTINCT tire_code FROM tires ORDER BY tire_code ASC";
    
    // Execute query
    $result = $conn->query($sql);

    // Check if any tire codes exist
    if ($result->num_rows > 0) {
        $tire_codes = [];
        
        // Fetch tire codes
        while ($row = $result->fetch_assoc()) {
            // Trim and sanitize tire code
            $tire_code = htmlspecialchars(trim($row['tire_code']));
            
            // Add to array if not empty
            if (!empty($tire_code)) {
                $tire_codes[] = $tire_code;
            }
        }

        // Return successful JSON response
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "tire_codes" => $tire_codes,
            "total_codes" => count($tire_codes)
        ]);
    } else {
        // No tire codes found
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "no_data",
            "message" => "No tire codes found in the database.",
            "tire_codes" => []
        ]);
    }
} catch (Exception $e) {
    // Catch any unexpected errors
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "error",
        "message" => "An unexpected error occurred: " . $e->getMessage()
    ]);
} finally {
    // Always close the database connection
    $conn->close();
}
?>