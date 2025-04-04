<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project4_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get Form Data
$name = $_POST['myname1'] ?? '';
$email = $_POST['myemail'] ?? '';
$phone = $_POST['myphone'] ?? '';
$age = $_POST['myage'] ?? '';
$gender = $_POST['mygender'] ?? '';
$departure = $_POST['departuredate'] ?? '';
$return = $_POST['returndate'] ?? '';
$package = $_POST['locations'] ?? '';
$created_at = date("Y-m-d H:i:s");

// Handle Multiple Destinations
$destination = isset($_POST['td']) && is_array($_POST['td']) ? implode(", ", $_POST['td']) : '';

// Validate Required Fields
if (empty($name) || empty($email) || empty($phone) || empty($age) || empty($gender) || empty($departure) || empty($return) || empty($destination) || empty($package)) {
    die("Error: All fields are required!");
}

// Prepare and Execute SQL Query
$sql = "INSERT INTO users (name, email, phone, age, gender, departure, return_date, destination, package, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssisssssss", $name, $email, $phone, $age, $gender, $departure, $return, $destination, $package, $created_at);

if ($stmt->execute()) {
    // **✅ Redirect with URL Parameters**
    header("Location: receipt.php?name=" . urlencode($name) . 
           "&email=" . urlencode($email) . 
           "&phone=" . urlencode($phone) . 
           "&age=" . urlencode($age) . 
           "&gender=" . urlencode($gender) . 
           "&departure=" . urlencode($departure) . 
           "&return=" . urlencode($return) . 
           "&destination=" . urlencode($destination) . 
           "&package=" . urlencode($package) . 
           "&created_at=" . urlencode($created_at));
    exit();
} else {
    echo "❌ Error: " . $stmt->error;
}

// Close Connection
$stmt->close();
$conn->close();
?>
