<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "database");

// Connection Error Check
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Get ID from URL
$id = intval($_GET['id'] ?? 0);

// Fetch Booking Data
$result = $conn->query("SELECT * FROM form2 WHERE id=$id");
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "Booking not found!";
    exit;
}

// Update Booking
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $place = $_POST['place'];
    $price = $_POST['price'];
    $guests = $_POST['guests'];
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $contact_email = $_POST['contact_email'];
    $mobile_number = $_POST['mobile_number'];
    $age = $_POST['age'];

    $sql = "UPDATE form2 SET place='$place', price='$price', guests='$guests', 
            checkin_date='$checkin_date', checkout_date='$checkout_date', 
            contact_email='$contact_email', mobile_number='$mobile_number', 
            age='$age'
            WHERE id=$id";

    if ($conn->query($sql)) {
        echo "<script>alert('Booking Updated Successfully!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Booking</title>
    <link rel="stylesheet" href="assets/css/update.css" />
</head>

<body>
    <div class="container">
        <h2>Update Booking Details</h2>
        <form method="POST">
            <label>Place: <input type="text" name="place" value="<?php echo $row['place']; ?>" required></label>
            <label>Price: <input type="number" name="price" value="<?php echo $row['price']; ?>" required></label>
            <label>Guests: <input type="number" name="guests" value="<?php echo $row['guests']; ?>" required></label>
            <label>Check-in Date: <input type="date" name="checkin_date" value="<?php echo $row['checkin_date']; ?>" required></label>
            <label>Check-out Date: <input type="date" name="checkout_date" value="<?php echo $row['checkout_date']; ?>" required></label>
            <label>Contact Email: <input type="email" name="contact_email" value="<?php echo $row['contact_email']; ?>" required></label>
            <label>Mobile Number: <input type="text" name="mobile_number" value="<?php echo $row['mobile_number']; ?>" required></label>
            <label>Age: <input type="number" name="age" value="<?php echo $row['age']; ?>" required></label>

            <button type="submit">Update Booking</button>
            <button type="button" onclick="window.location.href='dashboard.php'">Cancel</button>
        </form>
    </div>
</body>

</html>
