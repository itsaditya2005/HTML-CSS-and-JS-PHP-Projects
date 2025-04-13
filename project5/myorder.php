<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "project5_db";

$conn = new mysqli($host, $user, $pass, $db);

$mobile = '';
$refundAmount = null;
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cancel_id']) && isset($_POST['mobile'])) {
        $mobile = $_POST['mobile'];
        $cancel_id = $_POST['cancel_id'];

        $res = $conn->query("SELECT price, quantity FROM orders WHERE id = $cancel_id");
        if ($res->num_rows > 0) {
            $order = $res->fetch_assoc();
            $total = $order['price'] * $order['quantity'];
            $refundAmount = round($total * 0.9, 2);
        }

        $conn->query("DELETE FROM orders WHERE id = $cancel_id");
    } elseif (isset($_POST['mobile'])) {
        $mobile = $_POST['mobile'];
    }

    $result = $conn->query("SELECT * FROM orders WHERE mobile = '$mobile'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders</title>
  <style>
    body {
      font-family: Arial;
      background: #fff3e0;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 500px;
      margin: 60px auto;
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(255, 153, 0, 0.3);
    }
    h2 {
      text-align: center;
      color: #ff6f00;
    }
    input[type="text"] {
      width: 100%;
      padding: 12px;
      margin: 15px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    button {
      background-color: #ff6f00;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      cursor: pointer;
      width: 100%;
    }
    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
    }
    .cancel-btn {
      background-color: red;
      padding: 8px 14px;
      border: none;
      color: white;
      border-radius: 6px;
      cursor: pointer;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.4);
    }
    .modal.active {
      display: block;
    }
    .modal-content {
      background-color: #fff3e0;
      margin: 10% auto;
      padding: 25px;
      border-radius: 10px;
      width: 400px;
      text-align: center;
      border: 2px solid #ff6f00;
    }
    .modal-content h3 {
      color: #ff6f00;
    }
    .close {
      float: right;
      font-size: 22px;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Check Your Orders</h2>
  <form method="POST">
    <input type="text" name="mobile" placeholder="Enter your mobile number" value="<?= htmlspecialchars($mobile) ?>" required>
    <button type="submit">Show Orders</button>
  </form>

  <?php if (isset($result)): ?>
    <?php if ($result->num_rows > 0): ?>
      <table>
        <tr>
          <th>Item</th>
          <th>Qty</th>
          <th>Total</th>
          <th>Cancel</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['item'] ?></td>
          <td><?= $row['quantity'] ?></td>
          <td>₹<?= $row['price'] * $row['quantity'] ?></td>
          <td>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="mobile" value="<?= $mobile ?>">
              <input type="hidden" name="cancel_id" value="<?= $row['id'] ?>">
              <button type="submit" class="cancel-btn">Cancel</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p style="color:red; text-align:center;">No orders from this number.</p>
    <?php endif; ?>
  <?php endif; ?>
</div>

<div id="cancelModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h3>Order Cancelled</h3>
    <p>Your order has been cancelled.<br>Refund Amount: ₹<?= $refundAmount ?? 0 ?></p>
  </div>
</div>

<?php if ($refundAmount): ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('cancelModal').classList.add('active');
  });

  function closeModal() {
    document.getElementById('cancelModal').classList.remove('active');
  }

  window.onclick = function(event) {
    let modal = document.getElementById('cancelModal');
    if (event.target === modal) {
      closeModal();
    }
  }
</script>
<?php endif; ?>

</body>
</html>
