<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "database"; // Change this to your actual database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get mobile number from URL
$mobile_number = $_GET['mobile_number'] ?? '';

if (empty($mobile_number)) {
    echo "Mobile number is required.";
    exit;
}

// Delete record from the database
$sql = "DELETE FROM form2 WHERE mobile_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $mobile_number);

if ($stmt->execute()) {
    echo "Booking canceled successfully.";
} else {
    echo "Error canceling booking: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
