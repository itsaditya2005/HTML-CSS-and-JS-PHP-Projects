<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "project4_db");

// Connection Error Check
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Delete Operation
$deleteSuccess = false;
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($conn->query("DELETE FROM users WHERE id=$id")) {
        $deleteSuccess = true;
    }
}

// Fetch Data Based on Date Filter
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
    $result = $conn->query("SELECT * FROM users WHERE created_at BETWEEN '$from_date' AND '$to_date'") or die($conn->error);
} else {
    $result = $conn->query("SELECT * FROM users") or die($conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css" />
    <link rel="stylesheet" type="text/css" href="./css/style.css">
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

    <nav>
        <img src="./files/logo.png" class="logo" alt="Logo" title="FirstFlight Travels">
            
        <ul class="navbar">
            <li>
                <a href="#home">Home</a>
                <a href="#locations">Locations</a>
                <a href="#package">Packages</a>
                <a href="./about.html">About Us</a>
                <a href="./contact.html">Contact Us</a>
            </li>
        </ul>
    </nav>

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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Departure</th>
                        <th>Return Date</th>
                        <th>Destination</th>
                        <th>Package</th>
                        <th>Registration Date</th>
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
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['departure']; ?></td>
                            <td><?php echo $row['return_date']; ?></td>
                            <td><?php echo $row['destination']; ?></td>
                            <td><?php echo $row['package']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <button class="dashboard-btn" onclick="window.location.href='update.php?id=<?php echo $row['id']; ?>'">Update</button>
                                <button class="dashboard-btn delete-btn" onclick="showDeleteDialog(<?php echo $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='12'>No bookings found for the selected date range.</td></tr>";
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
