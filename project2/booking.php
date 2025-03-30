<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Form Data Collecting
    $place = $_POST['place'] ?? '';
    $price = $_POST['price'] ?? '';
    $guests = $_POST['guests'] ?? '';
    $checkin_date = $_POST['checkin_date'] ?? '';
    $checkout_date = $_POST['checkout_date'] ?? '';
    $contact_email = $_POST['contact_email'] ?? '';
    $mobile_number = $_POST['mobile_number'] ?? '';
    $age = $_POST['age'] ?? '';
    $booking_date = date('Y-m-d'); // Current date

    // Empty Fields Check
    if (empty($place) || empty($price) || empty($guests) || empty($checkin_date) || empty($checkout_date) || empty($contact_email) || empty($mobile_number) || empty($age)) {
        header("Location: bookingFailed.html?error=emptyfields");
        exit;
    }

    // Database Connection using PDO
    $host = "localhost";
    $dbname = "database"; // Update with your database name
    $username = "root"; // Default MySQL username
    $password = ""; // No password by default in XAMPP

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Data Insert Query
        $stmt = $conn->prepare("INSERT INTO form2 (place, price, guests, checkin_date, checkout_date, contact_email, mobile_number, age, booking_date) 
                                 VALUES (:place, :price, :guests, :checkin_date, :checkout_date, :contact_email, :mobile_number, :age, :booking_date)");
        $stmt->execute([
            ':place' => $place,
            ':price' => $price,
            ':guests' => $guests,
            ':checkin_date' => $checkin_date,
            ':checkout_date' => $checkout_date,
            ':contact_email' => $contact_email,
            ':mobile_number' => $mobile_number,
            ':age' => $age,
            ':booking_date' => $booking_date
        ]);

        // Redirect to receipt.php with all form data
        $params = http_build_query([
            'place' => $place,
            'price' => $price,
            'guests' => $guests,
            'checkin_date' => $checkin_date,
            'checkout_date' => $checkout_date,
            'contact_email' => $contact_email,
            'mobile_number' => $mobile_number,
            'age' => $age,
            'booking_date' => $booking_date
        ]);
        header("Location: receipt.php?$params");
        exit;
    } catch (PDOException $e) {
        header("Location: bookingFailed.html?error=" . urlencode($e->getMessage()));
        exit;
    }
}
?>
