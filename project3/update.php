<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "project4_db");

// Connection Error Check
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Get ID from URL
$id = intval($_GET['id'] ?? 0);

// Fetch User Data
$result = $conn->query("SELECT * FROM users WHERE id=$id");
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit;
}

// Update Data
$successDialog = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['myname1'];
    $email = $_POST['myemail'];
    $phone = $_POST['myphone'];
    $age = $_POST['myage'];
    $departure = $_POST['departuredate'];
    $return_date = $_POST['returndate'];
    $destination = implode(",", $_POST['td']);
    $package = $_POST['locations'];

    $sql = "UPDATE users SET 
                name='$name', email='$email', phone='$phone', 
                age='$age', departure='$departure', 
                return_date='$return_date', destination='$destination', 
                package='$package' 
            WHERE id=$id";

    if ($conn->query($sql)) {
        $successDialog = true;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Registration</title>
    <link rel="icon" href="./files/logo.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <style>
        .dialog-box {
            position: fixed;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            padding: 25px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            z-index: 9999;
            font-size: 18px;
            font-family: 'Poppins', sans-serif;
            color: #333;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -60%); }
            to   { opacity: 1; transform: translate(-50%, -50%); }
        }
    </style>
</head>
<body class="register-body">

<?php if ($successDialog): ?>
    <div id="customDialog" class="dialog-box">
        <p>User Updated Successfully!</p>
    </div>
    <script>
        setTimeout(function () {
            document.getElementById('customDialog').style.opacity = '0';
        }, 2500);

        setTimeout(function () {
            window.location = 'dashboard.php';
        }, 3000);
    </script>
<?php endif; ?>

<nav>
    <img src="./files/logo.png" class="logo" alt="Logo" title="FirstFlight Travels">
    <ul class="navbar">
        <li>
            <a href="./index.html">Home</a>
            <a href="./index.html#locations">Locations</a>
            <a href="./index.html#package">Packages</a>
            <a href="./about.html">About Us</a>
            <a href="./contact.html">Contact Us</a>
        </li>
    </ul>
</nav>

<section class="registration">
    <div class="register-form">
        <h1>Update <span>Details</span></h1>
        <form method="POST">
            <input type="text" name="myname1" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            <input type="email" name="myemail" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            <input type="tel" name="myphone" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
            <input type="number" name="myage" value="<?php echo htmlspecialchars($row['age']); ?>" required>

            <h4>Departure</h4>
            <input type="datetime-local" name="departuredate" value="<?php echo date('Y-m-d\TH:i', strtotime($row['departure'])); ?>" required>

            <h4>Return</h4>
            <input type="datetime-local" name="returndate" value="<?php echo date('Y-m-d\TH:i', strtotime($row['return_date'])); ?>" required>

            <h4>Travel Destination</h4>
            <?php
            $selected_destinations = explode(",", $row['destination']);
            $destinations = ["Kashmir", "Istanbul", "Paris", "Bali", "Dubai", "Geneva", "Port Blair", "Rome"];
            foreach ($destinations as $dest) {
                $checked = in_array($dest, $selected_destinations) ? "checked" : "";
                echo "<input type='checkbox' name='td[]' value='$dest' $checked> $dest &nbsp;&nbsp;&nbsp;";
            }
            ?>

            <h4>Package</h4>
            <?php
            $packages = ["Bronze", "Silver", "Gold", "Platinum"];
            foreach ($packages as $pkg) {
                $checked = ($row['package'] == $pkg) ? "checked" : "";
                echo "<input type='radio' name='locations' value='$pkg' $checked> $pkg &nbsp;&nbsp;&nbsp;";
            }
            ?>

            <br><br>
            <input type="checkbox" name="tandc" required> I accept the Terms & Conditions.

            <br><br>
            <input type="submit" value="Update" class="submitbtn">
            <input type="button" value="Cancel" class="cancelbtn" id="cancelBtn">
        </form>
    </div>
</section>

<!-- Footer -->
<section class="footer">
    <div class="foot">
        <div class="footer-content">

            <div class="footlinks">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="./register.html">Register</a></li>
                    <li><a href="./about.html">About Us</a></li>
                    <li><a href="./contact.html">Contact Us</a></li>
                </ul>
            </div>

            <div class="footlinks">
                <h4>Connect</h4>
                <div class="social">
                    <a href="#" target="_blank"><i class='bx bxl-facebook'></i></a>
                    <a href="#" target="_blank"><i class='bx bxl-instagram'></i></a>
                    <a href="#" target="_blank"><i class='bx bxl-twitter'></i></a>
                    <a href="#" target="_blank"><i class='bx bxl-linkedin'></i></a>
                    <a href="#" target="_blank"><i class='bx bxl-youtube'></i></a>
                    <a href="#" target="_blank"><i class='bx bxl-wordpress'></i></a>
                    <a href="#" target="_blank"><i class='bx bxl-github'></i></a>
                </div>
            </div>

        </div>
    </div>

    <div class="end">
        <p>Copyright © 2022 Firstflight Travels All Rights Reserved.<br>Website developed by: Mohd. Rahil</p>
    </div>
</section>

<script>
    // Cancel Button - redirect to dashboard
    document.getElementById('cancelBtn').addEventListener('click', function () {
        window.location.href = 'dashboard.php';
    });
</script>

</body>
</html>
