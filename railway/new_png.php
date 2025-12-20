<?php 
session_start();
require "db.php";

$success = false;
$error = "";
$tempfare = 0;
$adultCount = 0;
$rpnr = null;

$pname = $_POST["pname"];
$page = $_POST["page"];
$pgender = $_POST["pgender"];

$tno = $_SESSION["tno"];
$doj = $_SESSION["doj"];
$sp = $_SESSION["sp"];
$dp = $_SESSION["dp"];
$class = $_SESSION["class"];

// Get fare
$query = "SELECT fare FROM classseats WHERE trainno='" . $conn->real_escape_string($tno) . "' AND class='" . $conn->real_escape_string($class) . "' AND doj='" . $conn->real_escape_string($doj) . "' AND sp='" . $conn->real_escape_string($sp) . "' AND dp='" . $conn->real_escape_string($dp) . "'";
$result = mysqli_query($conn, $query);

if($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_array($result);
  $fare = $row[0];

  // Calculate fare
  for($i = 0; $i < $_SESSION["nos"]; $i++) {
    if($page[$i] >= 18) {
      $adultCount++;
      $tempfare += $fare;
    } else if($page[$i] < 18) {
      $tempfare += 0.5 * $fare;
    }
  }

  // Check for at least one adult
  if($adultCount > 0) {
    // Insert reservation
    $sql = "INSERT INTO resv(id, trainno, sp, dp, doj, tfare, class, nos) VALUES ('" . $_SESSION["id"] . "', '" . $conn->real_escape_string($tno) . "', '" . $conn->real_escape_string($sp) . "', '" . $conn->real_escape_string($dp) . "', '" . $conn->real_escape_string($doj) . "', '" . $tempfare . "', '" . $conn->real_escape_string($class) . "', '" . $_SESSION["nos"] . "')";

    if ($conn->query($sql) === TRUE) {
      // Get the PNR
      $query = "SELECT pnr FROM resv WHERE id='" . $_SESSION["id"] . "' AND trainno='" . $conn->real_escape_string($tno) . "' AND doj='" . $conn->real_escape_string($doj) . "' ORDER BY pnr DESC LIMIT 1";
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      $rpnr = $row['pnr'];

      // Insert passenger details
      $passengerInsertSuccess = true;
      for($i = 0; $i < $_SESSION["nos"]; $i++) {
        $sql = "INSERT INTO pd(pnr, pname, page, pgender) VALUES ('" . $rpnr . "', '" . $conn->real_escape_string($pname[$i]) . "', '" . $page[$i] . "', '" . $conn->real_escape_string($pgender[$i]) . "')";
        if ($conn->query($sql) !== TRUE) {
          $passengerInsertSuccess = false;
          $error = $conn->error;
          break;
        }
      }

      if($passengerInsertSuccess) {
        $success = true;
      }
    } else {
      $error = $conn->error;
    }
  } else {
    $error = "At least one adult (age 18+) must accompany the group!";
  }
} else {
  $error = "Could not retrieve fare information. Please try again.";
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $success ? "Booking Confirmed" : "Booking Error"; ?> - Railway Reservation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .result-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      padding: 40px 30px;
      max-width: 700px;
      width: 100%;
    }
    .success-icon {
      color: #43e97b;
      font-size: 80px;
      margin-bottom: 20px;
      text-align: center;
    }
    .error-icon {
      color: #ff6b6b;
      font-size: 80px;
      margin-bottom: 20px;
      text-align: center;
    }
    h2 {
      color: #333;
      font-weight: 700;
      margin: 20px 0;
      text-align: center;
    }
    .result-message {
      font-size: 16px;
      color: #666;
      margin: 20px 0;
      line-height: 1.6;
      text-align: center;
    }
    .booking-details {
      background: #f8f9fa;
      padding: 25px;
      border-radius: 10px;
      margin: 20px 0;
      border-left: 5px solid #43e97b;
    }
    .booking-section {
      margin-bottom: 20px;
      padding-bottom: 20px;
      border-bottom: 1px solid #ddd;
    }
    .booking-section:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }
    .booking-section-title {
      font-weight: 700;
      color: #667eea;
      margin-bottom: 10px;
      font-size: 14px;
      text-transform: uppercase;
    }
    .booking-item {
      display: flex;
      justify-content: space-between;
      margin: 8px 0;
      color: #333;
    }
    .booking-item-label {
      font-weight: 600;
    }
    .booking-item-value {
      text-align: right;
    }
    .pnr-display {
      background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
      color: white;
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      text-align: center;
    }
    .pnr-label {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      opacity: 0.9;
    }
    .pnr-value {
      font-size: 36px;
      font-weight: 700;
      margin: 10px 0 0 0;
    }
    .fare-summary {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      margin: 20px 0;
      border: 2px solid #667eea;
    }
    .fare-label {
      font-size: 14px;
      color: #667eea;
      font-weight: 600;
    }
    .fare-amount {
      font-size: 28px;
      font-weight: 700;
      color: #333;
      margin: 5px 0 0 0;
    }
    .error-message {
      background: #f8d7da;
      border: 2px solid #f5c6cb;
      color: #721c24;
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      text-align: center;
    }
    .action-buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-top: 30px;
      flex-wrap: wrap;
    }
    .btn-action {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      text-decoration: none;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 8px;
      transition: all 0.3s ease;
      display: inline-block;
      border: none;
      cursor: pointer;
    }
    .btn-action:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
      color: white;
    }
  </style>
</head>
<body>
  <div class="result-card">
    <?php if($success) { ?>
      <div class="success-icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <h2>Booking Confirmed!</h2>
      <p class="result-message">
        Your reservation has been successfully completed. Here are your booking details:
      </p>

      <div class="pnr-display">
        <div class="pnr-label"><i class="fas fa-ticket-alt"></i> Your PNR Number</div>
        <div class="pnr-value"><?php echo htmlspecialchars($rpnr); ?></div>
      </div>

      <div class="booking-details">
        <div class="booking-section">
          <div class="booking-section-title"><i class="fas fa-train"></i> Journey Details</div>
          <div class="booking-item">
            <span class="booking-item-label">Route:</span>
            <span class="booking-item-value"><?php echo htmlspecialchars($sp) . " → " . htmlspecialchars($dp); ?></span>
          </div>
          <div class="booking-item">
            <span class="booking-item-label">Train No:</span>
            <span class="booking-item-value"><strong><?php echo htmlspecialchars($tno); ?></strong></span>
          </div>
          <div class="booking-item">
            <span class="booking-item-label">Date of Journey:</span>
            <span class="booking-item-value"><?php echo date('d/m/Y', strtotime($doj)); ?></span>
          </div>
        </div>

        <div class="booking-section">
          <div class="booking-section-title"><i class="fas fa-users"></i> Booking Summary</div>
          <div class="booking-item">
            <span class="booking-item-label">Class:</span>
            <span class="booking-item-value"><?php echo htmlspecialchars($class); ?></span>
          </div>
          <div class="booking-item">
            <span class="booking-item-label">No. of Passengers:</span>
            <span class="booking-item-value"><?php echo $_SESSION["nos"]; ?></span>
          </div>
        </div>
      </div>

      <div class="fare-summary">
        <div class="fare-label"><i class="fas fa-money-bill-wave"></i> Total Fare (VND)</div>
        <div class="fare-amount"><?php echo number_format($tempfare, 0, '.', ','); ?> VND</div>
      </div>

      <p class="result-message" style="font-size: 14px; color: #999; margin-top: 20px;">
        <i class="fas fa-info-circle"></i> Please save your PNR number. You will need it for check-in and cancellations.
      </p>

    <?php } else { ?>
      <div class="error-icon">
        <i class="fas fa-exclamation-circle"></i>
      </div>
      <h2>Booking Failed</h2>
      <p class="result-message">
        There was an error while processing your booking.
      </p>
      <div class="error-message">
        <strong><i class="fas fa-times-circle"></i> Error:</strong><br>
        <?php echo htmlspecialchars($error); ?>
      </div>
      <p class="result-message" style="font-size: 14px;">
        Please check your details and try again, or contact customer support.
      </p>
    <?php } ?>

    <div class="action-buttons">
      <?php if($success) { ?>
      <a href="http://localhost/railway/user_login.htm" class="btn-action">
        <i class="fas fa-ticket-alt"></i> View My Tickets
      </a>
      <?php } else { ?>
      <a href="http://localhost/railway/enquiry.php" class="btn-action">
        <i class="fas fa-redo"></i> Try Again
      </a>
      <?php } ?>
      <a href="http://localhost/railway/index.htm" class="btn-action">
        <i class="fas fa-home"></i> Go Home
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
