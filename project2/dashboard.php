<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "database");

// Connection Error Check
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Delete Operation
$deleteSuccess = false;
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($conn->query("DELETE FROM form2 WHERE id=$id")) {
        $deleteSuccess = true;
    }
}

// Fetch Data Based on Date Filter
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
    $result = $conn->query("SELECT * FROM form2 WHERE booking_date BETWEEN '$from_date' AND '$to_date'") or die($conn->error);
} else {
    $result = $conn->query("SELECT * FROM form2") or die($conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css" />
    <script>
        function showDeleteDialog(id) {
            const dialog = document.getElementById('deleteDialog');
            document.getElementById('confirmDelete').onclick = function() {
                window.location.href = 'dashboard.php?delete=' + id;
            };
            dialog.style.display = 'block';
        }

        function closeDialog() {
            document.getElementById('deleteDialog').style.display = 'none';
        }

        function showSuccessDialog() {
            const successDialog = document.getElementById('successDialog');
            successDialog.style.display = 'block';
            setTimeout(() => {
                successDialog.style.display = 'none';
            }, 2500); 
        }

        // Booking Deleted Successful Check
        <?php if ($deleteSuccess) { ?>
            window.onload = function() {
                showSuccessDialog();
            }
        <?php } ?>
    </script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Header Section -->
        <div class="dashboard-header">
            Welcome, Admin..!
        </div>

        <!-- Total Bookings and Date Filter Section -->
        <div class="dashboard-title">
            <h2>Total Bookings</h2>
            <form method="GET" class="date-filter-form">
                <label>From:</label>
                <input type="date" name="from_date" required>
                <label>To:</label>
                <input type="date" name="to_date" required>
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Total Bookings Table -->
        <div class="dashboard-content">
            <table  cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Place</th>
                        <th>Price</th>
                        <th>Guests</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                        <th>Contact Email</th>
                        <th>Mobile Number</th>
                        <th>Age</th>
                        <th>Booking Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['place']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['guests']; ?></td>
                            <td><?php echo $row['checkin_date']; ?></td>
                            <td><?php echo $row['checkout_date']; ?></td>
                            <td><?php echo $row['contact_email']; ?></td>
                            <td><?php echo $row['mobile_number']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo $row['booking_date']; ?></td>
                            <td>
                                <button class="dashboard-btn" onclick="window.location.href='update.php?id=<?php echo $row['id']; ?>'">Update</button>
                                <button class="dashboard-btn delete-btn" onclick="showDeleteDialog(<?php echo $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='11'>No bookings found for the selected date range.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom Delete Confirmation Dialog -->
    <div id="deleteDialog" class="dialog-overlay">
        <div class="dialog-box">
            <h3>Confirm Deletion</h3>
            <p>Are you sure you want to delete this booking?</p>
            <button id="confirmDelete" class="dashboard-btn">Yes, Delete</button>
            <button onclick="closeDialog()" class="dashboard-btn delete-btn">Cancel</button>
        </div>
    </div>

    <!-- Custom Success Dialog -->
    <div id="successDialog" class="dialog-overlay">
        <div class="dialog-box success-box">
            <h3>Success!</h3>
            <p>Booking Deleted Successfully.</p>
        </div>
    </div>
</body>
</html>
