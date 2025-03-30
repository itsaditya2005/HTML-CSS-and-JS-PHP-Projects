<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "database");

// Connection Error Check
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Retrieve Form Data
$place = $_POST['destination'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// SQL Query to Check for Existing Bookings
$sql = "SELECT * FROM form2 WHERE place = ? AND (NOT (checkout_date < ? OR checkin_date > ?));";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $place, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

// Redirect Based on Result
if ($result->num_rows > 0) {
    echo "<script>alert('No bookings available for the selected date range and destination.'); window.location.href='index.html';</script>";
} else {
    echo "<script>alert('Bookings are available for the selected date range and destination.'); window.location.href='booking.html';</script>";
}

// Close Connection
$stmt->close();
$conn->close();
?>
