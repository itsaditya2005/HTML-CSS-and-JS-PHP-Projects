<?php
$name = $_GET['name'] ?? 'N/A';
$email = $_GET['email'] ?? 'N/A';
$phone = $_GET['phone'] ?? 'N/A';
$age = $_GET['age'] ?? 'N/A';
$gender = $_GET['gender'] ?? 'N/A';
$departure = $_GET['departure'] ?? 'N/A';
$return = $_GET['return'] ?? 'N/A';
$destination = $_GET['destination'] ?? 'N/A';
$package = $_GET['package'] ?? 'N/A';
$created_at = $_GET['created_at'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking Receipt - Confirmation</title>
    <link rel="stylesheet" href="css/receipt.css" />
</head>
<body>
    <div class="container">
        <h2>Congratulations! Registration Successful 🎉 </h2>
        <h1>Registration Receipt</h1>

        <!-- Booking Details Table -->
        <table>
            <tr>
                <th>Registration Date</th>
                <td><?php echo htmlspecialchars($created_at); ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($name); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($email); ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?php echo htmlspecialchars($phone); ?></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><?php echo htmlspecialchars($age); ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?php echo htmlspecialchars($gender); ?></td>
            </tr>
            <tr>
                <th>Departure Date</th>
                <td><?php echo htmlspecialchars($departure); ?></td>
            </tr>
            <tr>
                <th>Return Date</th>
                <td><?php echo htmlspecialchars($return); ?></td>
            </tr>
            <tr>
                <th>Travel Destination</th>
                <td><?php echo htmlspecialchars($destination); ?></td>
            </tr>
            <tr>
                <th>Selected Package</th>
                <td><?php echo htmlspecialchars($package); ?></td>
            </tr>
        </table>

        <!-- Buttons for Print and Redirect-->
        <button onclick="window.print()">🖨️ Print Receipt</button>
        <button onclick="window.location.href='index.html'">🏠 Go to Home</button>
    </div>
</body>
</html>
