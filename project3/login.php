<?php
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project4_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user = $_POST['username'];
    $pass = $_POST['password'];

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Page</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #121212;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #1e1e1e;
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 0 15px rgba(255, 165, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        form label {
            color: #ffa500;
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            font-size: 16px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #2a2a2a;
            border: 1px solid #444;
            color: #fff;
            border-radius: 8px;
            font-size: 15px;
        }

        input::placeholder {
            color: #aaa;
        }

        button[type="submit"] {
            width: 100%;
            background-color: #ffa500;
            color: #1e1e1e;
            font-weight: bold;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color:rgb(255, 255, 255);
        }

        #dialog {
            display: none;
            position: fixed;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #1e1e1e;
            padding: 20px 30px;
            border-radius: 14px;
            box-shadow: 0 0 15px rgba(255, 166, 0, 0.8);
            color: white;
            z-index: 1000;
            text-align: center;
            max-width: 400px;
        }

        #overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 999;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <label for="username">Login Name :</label>
        <input type="text" id="username" name="username" placeholder="Enter Login Name" required />

        <label for="password">Password :</label>
        <input type="password" id="password" name="password" placeholder="Enter Password" required />

        <button type="submit">LOGIN</button>
    </form>

    <!-- Custom Dialog Box -->
    <div id="overlay"></div>
    <div id="dialog">
        <p id="dialogMessage"><?php echo $message; ?></p>
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
