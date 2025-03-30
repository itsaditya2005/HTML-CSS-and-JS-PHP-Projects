<?php
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root"; // Database username
    $password = ""; // Database password
    $dbname = "database";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Query to check username and password
    $sql = "SELECT * FROM form3 WHERE username='$user' AND password='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $message = "Login Successful! Redirecting to Dashboard...";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'dashboard.php';
                }, 2000);
              </script>";
    } else {
        $message = "Invalid Username or Password. Please try again.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login and Redirect</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        /* Custom Dialog Box */
        #dialog {
            display: none;
            position: fixed;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        #dialog button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        #dialog button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <label>Login Name :</label>
        <input type="text" name="username" placeholder="Enter Login Name" required /><br />

        <label>Password :</label>
        <input type="password" name="password" placeholder="Enter Password" required /><br />

        <button type="submit">LOGIN</button>
    </form>

    <!-- Custom Dialog Box -->
    <div id="overlay"></div>
    <div id="dialog">
        <p id="dialogMessage"><?php echo $message; ?></p>
        <button onclick="closeDialog()">OK</button>
    </div>

    <script>
        const message = "<?php echo $message; ?>";
        if (message !== "") {
            document.getElementById("dialogMessage").innerText = message;
            document.getElementById("overlay").style.display = "block";
            document.getElementById("dialog").style.display = "block";
        }

        function closeDialog() {
            document.getElementById("overlay").style.display = "none";
            document.getElementById("dialog").style.display = "none";
        }
    </script>
</body>
</html>
