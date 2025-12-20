session_start();
<?php
session_start();
require "db.php";

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$isValidUser = false;
$invalidCreds = false;
$bookings = array();
$temp1 = "";
$temp2 = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $mobile = isset($_POST['mno']) ? trim($_POST['mno']) : '';
  $pwd = isset($_POST['password']) ? $_POST['password'] : '';

  // Use prepared statement to avoid SQL injection
  $stmt = $conn->prepare("SELECT id, emailid FROM user WHERE mobileno = ? AND password = ?");
  $stmt->bind_param('ss', $mobile, $pwd);
  $stmt->execute();
  $res = $stmt->get_result();

  if ($row = $res->fetch_assoc()) {
    $temp1 = $row['emailid'];
    $temp2 = $row['id'];
    $isValidUser = true;
    $_SESSION['id'] = $temp2;
  } else {
    $isValidUser = false;
    $invalidCreds = true;
  }

  $stmt->close();

  if ($isValidUser) {
    $q = $conn->prepare("SELECT resv.* FROM resv WHERE resv.id = ?");
    $q->bind_param('i', $temp2);
    $q->execute();
    $r = $q->get_result();
    $bookings = $r->fetch_all(MYSQLI_ASSOC);
    $q->close();
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Tickets - Railway Reservation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }
    .tickets-container {
      max-width: 1100px;
      margin: 0 auto;
    }
    .tickets-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      padding: 30px;
      margin-bottom: 20px;
    }
    .welcome-section {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 25px;
      border-radius: 15px;
      margin-bottom: 25px;
      text-align: center;
      border-bottom: 5px solid #764ba2;
    }
    .welcome-section h2 {
      font-weight: 700;
      margin: 0 0 10px 0;
    }
    .user-email {
      font-size: 18px;
      font-weight: 600;
    }
    .error-alert {
      background: #f8d7da;
      border: 2px solid #f5c6cb;
      color: #721c24;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      margin-bottom: 20px;
    }
    .error-alert i {
      font-size: 32px;
      margin-bottom: 10px;
    }
    .tickets-header {
      text-align: center;
      margin-bottom: 25px;
      border-bottom: 3px solid #667eea;
      padding-bottom: 15px;
    }
    .tickets-header h3 {
      color: #333;
      font-weight: 700;
      margin: 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    thead {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }
    th {
      padding: 15px;
      text-align: left;
      font-weight: 600;
    }
    td {
      padding: 15px;
      border-bottom: 1px solid #ddd;
    }
    tbody tr:hover {
      background: #f8f9fa;
    }
    .status-badge {
      padding: 5px 10px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 12px;
    }
    .status-booked {
      background: #d4edda;
      color: #155724;
    }
    .status-cancelled {
      background: #f8d7da;
      color: #721c24;
    }
    .cancel-form {
      background: #f8f9fa;
      padding: 25px;
      border-radius: 15px;
      margin-top: 25px;
      border: 2px solid #667eea;
    }
    .cancel-form h4 {
      color: #333;
      font-weight: 700;
      margin-bottom: 20px;
      border-bottom: 2px solid #667eea;
      padding-bottom: 10px;
    }
    .form-group-custom {
      margin-bottom: 15px;
    }
    .form-group-custom label {
      font-weight: 600;
      color: #333;
      margin-bottom: 8px;
      display: block;
    }
    .form-group-custom input {
      width: 100%;
      padding: 12px;
      border: 2px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
    }
    .form-group-custom input:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .btn-cancel {
      background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
      color: white;
      border: none;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .btn-cancel:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(255, 107, 107, 0.3);
      color: white;
    }
    .action-links {
      display: flex;
      gap: 10px;
      margin-top: 20px;
      flex-wrap: wrap;
    }
    .btn-link {
      background: #667eea;
      color: white;
      text-decoration: none;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 8px;
      transition: all 0.3s ease;
      display: inline-block;
    }
    .btn-link:hover {
      background: #764ba2;
      transform: translateY(-3px);
      color: white;
    }
    .empty-state {
      text-align: center;
      padding: 40px;
      color: #999;
    }
  </style>
</head>
<body>
  <div class="tickets-container">
    <?php if($_SERVER['REQUEST_METHOD'] !== 'POST') { ?>
      <div class="tickets-card" style="max-width:520px; margin:40px auto;">
        <h3 class="text-center">User Login</h3>
        <p class="text-muted text-center">Enter your registered mobile number and password</p>
        <form action="user_login.php" method="post">
          <div class="mb-3">
            <label class="form-label">Registered Mobile No</label>
            <input type="text" name="mno" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="d-grid">
            <button class="btn btn-primary" style="background:linear-gradient(135deg,#4facfe 0%,#00f2fe 100%); border:none;">Login</button>
          </div>
        </form>
        <div style="text-align:center; margin-top:12px;"><a href="index.htm" class="btn-link">Back to Home</a></div>
      </div>
    <?php } else if($invalidCreds) { ?>
      <div class="tickets-card">
        <div class="error-alert">
          <i class="fas fa-exclamation-circle"></i>
          <h4 style="margin: 10px 0 0 0;">Invalid Credentials</h4>
          <p style="margin: 5px 0 0 0;">The mobile number or password you entered is incorrect.</p>
        </div>
        <div style="text-align: center;">
          <a href="http://localhost/railway/index.htm" class="btn-link">
            <i class="fas fa-home"></i> Go to Home Page
          </a>
        </div>
      </div>
    <?php } else { ?>
      <div class="welcome-section">
        <h2><i class="fas fa-ticket-alt"></i> My Reservations</h2>
        <p class="user-email" style="margin: 0;">Welcome, <strong><?php echo htmlspecialchars($temp1); ?></strong></p>
      </div>

      <div class="tickets-card">
        <div class="tickets-header">
          <h3><i class="fas fa-list"></i> Your Tickets</h3>
        </div>

        <?php if(!empty($bookings)) { ?>
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th><i class="fas fa-barcode"></i> PNR</th>
                <th><i class="fas fa-train"></i> Train No</th>
                <th><i class="fas fa-calendar"></i> Journey Date</th>
                <th><i class="fas fa-layer-group"></i> Class</th>
                <th><i class="fas fa-users"></i> Seats</th>
                <th><i class="fas fa-money-bill-wave"></i> Fare (VND)</th>
                <th><i class="fas fa-check-circle"></i> Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($bookings as $booking) { 
                $statusClass = ($booking['status'] == 'BOOKED') ? 'status-booked' : 'status-cancelled';
              ?>
              <tr>
                <td><strong><?php echo $booking['pnr']; ?></strong></td>
                <td><?php echo $booking['trainno']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($booking['doj'])); ?></td>
                <td><?php echo $booking['class']; ?></td>
                <td><?php echo $booking['nos']; ?></td>
                <td>₹<?php echo number_format($booking['tfare'], 2); ?></td>
                <td>
                  <span class="status-badge <?php echo $statusClass; ?>">
                    <?php echo $booking['status']; ?>
                  </span>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <?php } else { ?>
        <div class="empty-state">
          <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px;"></i>
          <p>No reservations yet! Start booking your tickets now.</p>
        </div>
        <?php } ?>
      </div>

      <?php if(!empty($bookings)) { ?>
      <div class="tickets-card">
        <div class="cancel-form">
          <h4><i class="fas fa-ban"></i> Cancel Reservation</h4>
          <form action="cancel.php" method="post">
            <div class="form-group-custom">
              <label><i class="fas fa-barcode"></i> PNR Number *</label>
              <input type="text" name="cancpnr" placeholder="Enter the PNR number to cancel" required>
            </div>
            <button type="submit" class="btn-cancel">
              <i class="fas fa-trash"></i> Cancel Ticket
            </button>
          </form>
        </div>
      </div>
      <?php } ?>
    <?php } ?>

    <div class="action-links">
      <a href="http://localhost/railway/index.htm" class="btn-link">
        <i class="fas fa-home"></i> Go to Home Page
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
