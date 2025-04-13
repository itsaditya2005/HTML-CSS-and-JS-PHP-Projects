<?php
$showModal = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "project5_db");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $item = $_POST['item'];
    $price = $_POST['price'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $quantity = $_POST['quantity'];
    $order_date = date('Y-m-d H:i:s');
    $total = $price * $quantity;

    $stmt = $conn->prepare("INSERT INTO orders (item, price, name, mobile, address, quantity, order_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsssis", $item, $price, $name, $mobile, $address, $quantity, $order_date);

    if ($stmt->execute()) {
        $showModal = true;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Now</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff5e6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            background: orange;
            color: white;
            padding: 15px;
            margin: 0;
        }
        form {
            width: 60%;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border: 2px solid orange;
            border-radius: 10px;
        }
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-group {
            flex: 1;
        }
        input[type=text], input[type=number] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 16px;
            border: 1px solid orange;
            border-radius: 6px;
        }
        input[type=submit] {
            background-color: orange;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 6px;
            width: 100%;
            font-size: 16px;
        }
        input[type=submit]:hover {
            background-color: #e69500;
        }

        .modal {
            display: <?= $showModal ? 'block' : 'none' ?>;
            position: fixed;
            z-index: 999;
            padding-top: 80px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fff5e6;
            margin: auto;
            padding: 25px;
            border: 2px solid orange;
            border-radius: 12px;
            width: 60%;
            text-align: center;
            position: relative;
        }
        .close {
            color: orange;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .receipt {
            margin-top: 20px;
            border-top: 1px dashed #ccc;
            text-align: left;
            padding: 10px;
            font-size: 16px;
        }
        .print-btn {
            background-color: orange;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Place Your Order</h2>

<form method="POST">
    <div class="form-row">
        <div class="form-group">
            <label>Item</label>
            <input 
                type="text" 
                name="item" 
                value="<?= $_GET['item'] ?? '' ?>" 
                <?= isset($_GET['item']) ? 'readonly' : '' ?> 
                required>
        </div>
        <div class="form-group">
            <label>Price</label>
            <input 
                type="text" 
                name="price" 
                value="<?= $_GET['price'] ?? '' ?>" 
                <?= isset($_GET['price']) ? 'readonly' : '' ?> 
                required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Mobile</label>
            <input type="text" name="mobile" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" required>
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" min="1" required>
        </div>
    </div>
    <input type="submit" value="Place Order">
</form>

<div id="orderModal" class="modal" onclick="closeModal(event)">
  <div class="modal-content" onclick="event.stopPropagation()">
    <span class="close" onclick="hideModal()">&times;</span>
    <h2 style="color: green;">Order Placed Successfully!</h2>
    <div class="receipt" id="receipt">
        <strong>Item:</strong> <?= $_POST['item'] ?? '' ?><br>
        <strong>Price:</strong> ₹<?= $_POST['price'] ?? '' ?><br>
        <strong>Quantity:</strong> <?= $_POST['quantity'] ?? '' ?><br>
        <strong>Total:</strong> ₹<?= ($_POST['price'] * $_POST['quantity']) ?? '' ?><br>
        <strong>Name:</strong> <?= $_POST['name'] ?? '' ?><br>
        <strong>Mobile:</strong> <?= $_POST['mobile'] ?? '' ?><br>
        <strong>Address:</strong> <?= $_POST['address'] ?? '' ?><br>
        <strong>Date:</strong> <?= date('d-m-Y H:i') ?><br>
    </div>
    <button class="print-btn" onclick="printReceipt()">Print Receipt</button>
  </div>
</div>

<script>
    function hideModal() {
        document.getElementById('orderModal').style.display = 'none';
        window.location.href = "myorder.php"; 
    }

    function closeModal(event) {
        if (event.target.id === 'orderModal') {
            hideModal();
        }
    }

    function printReceipt() {
        var printContents = document.getElementById('receipt').innerHTML;
        var win = window.open('', '', 'height=600,width=800');
        win.document.write('<html><head><title>Receipt</title>');
        win.document.write('<style>body{font-family: Arial;} h2{color: green;} .receipt{font-size: 16px;}</style>');
        win.document.write('</head><body>');
        win.document.write('<h2>Order Receipt</h2>');
        win.document.write(printContents);
        win.document.write('</body></html>');
        win.document.close();
        win.print();
    }
</script>

</body>
</html>
