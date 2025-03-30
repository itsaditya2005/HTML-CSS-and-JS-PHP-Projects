<?php
// Retrieve values from URL parameters using GET method
$id = $_GET['id'] ?? 'N/A';
$place = $_GET['place'] ?? 'N/A';
$price = $_GET['price'] ?? 0;
$guests = $_GET['guests'] ?? 0;
$checkin_date = $_GET['checkin_date'] ?? 'N/A';
$checkout_date = $_GET['checkout_date'] ?? 'N/A';
$contact_email = $_GET['contact_email'] ?? 'N/A';
$mobile_number = $_GET['mobile_number'] ?? 'N/A';
$age = $_GET['age'] ?? 'N/A';
$booking_date = $_GET['booking_date'] ?? 'N/A';

// Calculate the total price
$total_price = (float)$price * (int)$guests;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking Receipt - Confirmation</title>
    <link rel="stylesheet" href="assets/css/receipt.css" />
</head>

<body>
    <div class="container">
        <h2>🎉 Congratulations! Booking Confirmed.</h2>
        <h1>Booking Confirmation Receipt</h1>
        
        <!-- Booking Number -->
        <p><strong>Booking Number:</strong> <?php echo $id; ?></p>

        <!-- Booking Details Table -->
        <table>
            <tr>
                <th>Booking Date</th>
                <td><?php echo $booking_date; ?></td>
            </tr>
            <tr>
                <th>Place</th>
                <td><?php echo $place; ?></td>
            </tr>
            <tr>
                <th>Check-in Date</th>
                <td><?php echo $checkin_date; ?></td>
            </tr>
            <tr>
                <th>Check-out Date</th>
                <td><?php echo $checkout_date; ?></td>
            </tr>
            <tr>
                <th>Number of Guests</th>
                <td><?php echo $guests; ?></td>
            </tr>
            <tr>
                <th>Price Per Guest</th>
                <td>$<?php echo number_format($price, 2); ?></td>
            </tr>
            <tr>
                <th>Total Price</th>
                <td>$<?php echo number_format($total_price, 2); ?></td>
            </tr>
            <tr>
                <th>Contact Email</th>
                <td><?php echo $contact_email; ?></td>
            </tr>
            <tr>
                <th>Mobile Number</th>
                <td><?php echo $mobile_number; ?></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><?php echo $age; ?></td>
            </tr>
        </table>

        <!-- Buttons for Print and Redirect-->
        <button onclick="window.print()">🖨️ Print Receipt</button>
        <button onclick="window.location.href='index.html'">🏠 Go to Home</button>
    </div>

</body>

</html>
